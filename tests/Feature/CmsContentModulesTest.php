<?php

namespace Tests\Feature;

use App\Models\Achievement;
use App\Models\Alumni;
use App\Models\AlumniSubmission;
use App\Models\Announcement;
use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Tests\TestCase;

class CmsContentModulesTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    public function test_new_cms_module_pages_render(): void
    {
        $this->actingAs($this->admin());

        $this->get(route('admin.announcements.index'))->assertOk()->assertSee('Kelola pengumuman');
        $this->get(route('admin.announcements.create'))->assertOk()->assertSee('Tambah pengumuman');
        $this->get(route('admin.events.index'))->assertOk()->assertSee('Kelola agenda');
        $this->get(route('admin.events.create'))->assertOk()->assertSee('Tambah agenda');
        $this->get(route('admin.achievements.index'))->assertOk()->assertSee('Kelola prestasi');
        $this->get(route('admin.achievements.create'))->assertOk()->assertSee('Tambah prestasi');
        $this->get(route('admin.alumni.index'))->assertOk()->assertSee('Kelola alumni');
        $this->get(route('admin.alumni.create'))->assertOk()->assertSee('Tambah profil alumni');
    }

    public function test_admin_can_publish_achievement_with_image(): void
    {
        Storage::fake('public');

        $this->actingAs($this->admin())->post(route('admin.achievements.store'), [
            'title' => 'Juara Nasional dari CMS', 'participant' => 'Tim Olimpiade', 'category' => 'Akademik',
            'level' => 'nasional', 'organizer' => 'Kementerian Agama', 'rank' => 'Juara 1',
            'achieved_date' => '2026-08-20', 'description' => 'Prestasi tingkat nasional.',
            'status' => 'published', 'cover' => UploadedFile::fake()->image('prestasi.jpg', 1200, 675),
        ])->assertRedirect(route('admin.achievements.index'))->assertSessionHasNoErrors();

        $achievement = Achievement::where('title', 'Juara Nasional dari CMS')->firstOrFail();
        $this->assertSame(2026, $achievement->year);
        Storage::disk('public')->assertExists($achievement->cover);
        $this->get(route('prestasi.index'))->assertOk()->assertSee('Juara Nasional dari CMS');
    }

    public function test_admin_can_download_template_and_import_achievements_from_excel(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)->get(route('admin.achievements.template'))
            ->assertOk()
            ->assertDownload('template-import-prestasi.xlsx');

        $spreadsheet = new Spreadsheet;
        $spreadsheet->getActiveSheet()->fromArray([
            ['judul', 'peserta', 'kategori', 'tingkat', 'penyelenggara', 'peringkat', 'tanggal_prestasi', 'deskripsi', 'status'],
            ['Juara Excel Nasional', 'Tim Sains', 'Akademik', 'nasional', 'Kemenag', 'Juara 1', '2026-08-21', 'Hasil import.', 'published'],
            ['Juara Excel Kabupaten', null, 'Nonakademik', 'kabupaten', null, 'Juara 2', '2026-08-22', null, 'draft'],
        ]);
        $path = tempnam(sys_get_temp_dir(), 'achievement-import-');
        (new Xlsx($spreadsheet))->save($path);
        $spreadsheet->disconnectWorksheets();

        try {
            $file = new UploadedFile($path, 'prestasi.xlsx', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', null, true);
            $this->post(route('admin.achievements.import'), ['import_file' => $file])
                ->assertRedirect(route('admin.achievements.index'))
                ->assertSessionHasNoErrors();
        } finally {
            @unlink($path);
        }

        $this->assertDatabaseHas('achievements', [
            'title' => 'Juara Excel Nasional',
            'year' => 2026,
            'status' => 'published',
            'author_id' => $admin->id,
        ]);
        $this->assertDatabaseHas('achievements', [
            'title' => 'Juara Excel Kabupaten',
            'status' => 'draft',
        ]);
    }

    public function test_admin_can_publish_announcement_and_event(): void
    {
        Storage::fake('public');
        $admin = $this->admin();

        $this->actingAs($admin)->post(route('admin.announcements.store'), [
            'title' => 'Pengumuman dari CMS', 'body' => '<p>Isi pengumuman resmi.</p>',
            'publish_date' => '2026-08-26', 'start_date' => '2026-08-26', 'end_date' => '2026-09-01',
            'is_important' => 1, 'status' => 'published',
            'attachment' => UploadedFile::fake()->create('lampiran.pdf', 100, 'application/pdf'),
        ])->assertRedirect(route('admin.announcements.index'))->assertSessionHasNoErrors();

        $announcement = Announcement::where('title', 'Pengumuman dari CMS')->firstOrFail();
        Storage::disk('public')->assertExists($announcement->attachment);
        $this->get(route('pengumuman.show', $announcement))->assertOk()->assertSee('Isi pengumuman resmi');

        $this->post(route('admin.events.store'), [
            'title' => 'Agenda dari CMS', 'description' => 'Kegiatan resmi madrasah.', 'location' => 'Aula',
            'start_date' => '2026-09-10', 'end_date' => '2026-09-10', 'start_time' => '08:00', 'end_time' => '10:00',
            'category' => 'akademik', 'status' => 'published', 'cover' => UploadedFile::fake()->image('agenda.webp', 1200, 675),
        ])->assertRedirect(route('admin.events.index'))->assertSessionHasNoErrors();

        $event = Event::where('title', 'Agenda dari CMS')->firstOrFail();
        Storage::disk('public')->assertExists($event->cover);
        $this->get(route('agenda.show', $event))->assertOk()->assertSee('Agenda dari CMS')->assertSee('Aula');
    }

    public function test_admin_can_create_public_alumni_profile(): void
    {
        Storage::fake('public');

        $this->actingAs($this->admin())->post(route('admin.alumni.store'), [
            'name' => 'Alumni dari CMS', 'graduation_year' => 2020, 'university' => 'Universitas Negeri',
            'major' => 'Pendidikan', 'occupation' => 'Guru', 'company' => 'Sekolah Negeri',
            'testimonial' => 'Cerita alumni dari CMS.', 'status' => 'verified', 'is_public' => 1, 'order' => 1,
            'photo' => UploadedFile::fake()->image('alumni.jpg', 600, 600),
        ])->assertRedirect(route('admin.alumni.index'))->assertSessionHasNoErrors();

        $alumnus = Alumni::where('name', 'Alumni dari CMS')->firstOrFail();
        Storage::disk('public')->assertExists($alumnus->photo);
        $this->get(route('alumni.index'))->assertOk()->assertSee('Alumni dari CMS')->assertSee('Cerita alumni dari CMS');
    }

    public function test_admin_can_approve_submission_without_exposing_private_contact(): void
    {
        $submission = AlumniSubmission::create([
            'name' => 'Pendaftar Alumni', 'graduation_year' => 2021, 'email' => 'private@example.test',
            'phone' => '089999112233', 'occupation' => 'Wiraswasta', 'testimonial' => 'Cerita pendaftar.', 'status' => 'pending',
        ]);

        $this->actingAs($this->admin())->post(route('admin.alumni.submissions.approve', $submission))->assertRedirect();

        $this->assertSame('approved', $submission->fresh()->status);
        $this->assertDatabaseHas('alumni', ['name' => 'Pendaftar Alumni', 'status' => 'verified', 'is_public' => true]);
        $this->get(route('alumni.index'))->assertOk()->assertSee('Pendaftar Alumni')->assertDontSee('private@example.test')->assertDontSee('089999112233');
    }

    private function admin(): User
    {
        return User::where('email', 'admin@ma-assaadah.sch.id')->firstOrFail();
    }
}
