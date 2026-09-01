<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use ZipArchive;

class AdminBackupTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    public function test_admin_can_create_download_and_delete_a_backup(): void
    {
        Storage::fake('local');
        Storage::fake('public');
        Storage::disk('public')->put('documents/example.txt', 'isi file');

        $admin = User::where('email', 'admin@ma-assaadah.sch.id')->firstOrFail();
        $this->actingAs($admin)->get(route('admin.backups.index'))->assertOk()->assertSee('Backup data');
        $this->actingAs($admin)->post(route('admin.backups.store'))
            ->assertRedirect(route('admin.backups.index'))
            ->assertSessionHas('flash.type', 'success');

        $path = collect(Storage::disk('local')->files('backups'))->first(fn (string $file) => str_ends_with($file, '.zip'));
        $this->assertNotNull($path);

        $zip = new ZipArchive;
        $this->assertTrue($zip->open(Storage::disk('local')->path($path)));
        $this->assertNotFalse($zip->locateName('database.json'));
        $this->assertNotFalse($zip->locateName('uploads/documents/example.txt'));
        $this->assertStringContainsString('users', $zip->getFromName('database.json'));
        $zip->close();

        $filename = basename($path);
        $this->actingAs($admin)->get(route('admin.backups.download', $filename))->assertDownload($filename);
        $this->actingAs($admin)->delete(route('admin.backups.destroy', $filename))
            ->assertRedirect(route('admin.backups.index'));
        Storage::disk('local')->assertMissing($path);
    }
}
