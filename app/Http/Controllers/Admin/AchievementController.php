<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use DateTimeInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date as SpreadsheetDate;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Throwable;

class AchievementController extends Controller
{
    public function index(Request $request)
    {
        $achievements = Achievement::query()
            ->when($request->filled('q'), fn ($query) => $query->where(fn ($query) => $query->where('title', 'like', '%'.$request->string('q').'%')->orWhere('participant', 'like', '%'.$request->string('q').'%')))
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')))
            ->latest('achieved_date')->paginate(15)->withQueryString();

        return view('admin.achievements.index', compact('achievements'));
    }

    public function create()
    {
        return view('admin.achievements.form', ['achievement' => new Achievement(['level' => 'kabupaten', 'status' => 'draft'])]);
    }

    public function template()
    {
        $spreadsheet = new Spreadsheet;
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Data Prestasi');
        $sheet->fromArray([self::IMPORT_HEADERS], null, 'A1');
        $sheet->freezePane('A2');
        $sheet->setAutoFilter('A1:I1');
        $sheet->getStyle('A1:I1')->getFont()->setBold(true)->getColor()->setARGB('FFFFFFFF');
        $sheet->getStyle('A1:I1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF166534');
        foreach (range('A', 'I') as $column) {
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }

        $instructions = $spreadsheet->createSheet();
        $instructions->setTitle('Petunjuk');
        $instructions->fromArray([
            ['Kolom', 'Ketentuan', 'Contoh'],
            ['judul', 'Wajib, maksimal 255 karakter', 'Juara 1 Olimpiade Matematika'],
            ['peserta', 'Opsional, nama siswa atau tim', 'Ahmad Fauzan'],
            ['kategori', 'Wajib, maksimal 50 karakter', 'Akademik'],
            ['tingkat', 'Wajib: madrasah/kecamatan/kabupaten/provinsi/nasional/internasional', 'nasional'],
            ['penyelenggara', 'Opsional', 'Kementerian Agama'],
            ['peringkat', 'Opsional', 'Juara 1'],
            ['tanggal_prestasi', 'Wajib, format YYYY-MM-DD', '2026-08-20'],
            ['deskripsi', 'Opsional, maksimal 5000 karakter', 'Olimpiade tingkat nasional.'],
            ['status', 'Wajib: draft/published', 'published'],
        ], null, 'A1');
        $instructions->getStyle('A1:C1')->getFont()->setBold(true)->getColor()->setARGB('FFFFFFFF');
        $instructions->getStyle('A1:C1')->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FF166534');
        foreach (range('A', 'C') as $column) {
            $instructions->getColumnDimension($column)->setAutoSize(true);
        }

        return response()->streamDownload(function () use ($spreadsheet) {
            (new Xlsx($spreadsheet))->save('php://output');
            $spreadsheet->disconnectWorksheets();
        }, 'template-import-prestasi.xlsx', [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    public function import(Request $request)
    {
        $request->validate([
            'import_file' => ['required', 'file', 'mimes:xlsx,xls', 'max:5120'],
        ], [
            'import_file.required' => 'Pilih file Excel yang akan diimport.',
            'import_file.mimes' => 'File import harus berformat XLSX atau XLS.',
            'import_file.max' => 'Ukuran file import maksimal 5 MB.',
        ]);

        try {
            $spreadsheet = IOFactory::load($request->file('import_file')->getRealPath());
            $sheet = $spreadsheet->getSheetByName('Data Prestasi') ?? $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray(null, true, false, false);
            $spreadsheet->disconnectWorksheets();
        } catch (Throwable) {
            return back()->withErrors(['import_file' => 'File Excel tidak dapat dibaca. Pastikan file tidak rusak.']);
        }

        $headers = array_map(fn ($value) => Str::lower(trim((string) $value)), array_shift($rows) ?? []);
        if ($headers !== self::IMPORT_HEADERS) {
            return back()->withErrors(['import_file' => 'Kolom file tidak sesuai template. Unduh dan gunakan template yang tersedia.']);
        }

        $records = [];
        foreach ($rows as $index => $row) {
            if (collect($row)->every(fn ($value) => $value === null || trim((string) $value) === '')) {
                continue;
            }

            $record = array_combine(self::IMPORT_HEADERS, array_pad(array_slice($row, 0, count(self::IMPORT_HEADERS)), count(self::IMPORT_HEADERS), null));
            $record = array_map(fn ($value) => is_string($value) ? trim($value) : $value, $record);
            $record['tingkat'] = Str::lower((string) $record['tingkat']);
            $record['status'] = Str::lower((string) $record['status']);
            $record['tanggal_prestasi'] = $this->normalizeExcelDate($record['tanggal_prestasi']);

            $validator = Validator::make($record, [
                'judul' => ['required', 'string', 'max:255'],
                'peserta' => ['nullable', 'string', 'max:255'],
                'kategori' => ['required', 'string', 'max:50'],
                'tingkat' => ['required', Rule::in(Achievement::LEVELS)],
                'penyelenggara' => ['nullable', 'string', 'max:255'],
                'peringkat' => ['nullable', 'string', 'max:255'],
                'tanggal_prestasi' => ['required', 'date_format:Y-m-d'],
                'deskripsi' => ['nullable', 'string', 'max:5000'],
                'status' => ['required', Rule::in(['draft', 'published'])],
            ], [], [
                'judul' => 'judul', 'peserta' => 'peserta', 'kategori' => 'kategori',
                'tingkat' => 'tingkat', 'penyelenggara' => 'penyelenggara', 'peringkat' => 'peringkat',
                'tanggal_prestasi' => 'tanggal prestasi', 'deskripsi' => 'deskripsi', 'status' => 'status',
            ]);

            if ($validator->fails()) {
                return back()->withErrors(['import_file' => 'Baris '.($index + 2).': '.$validator->errors()->first()]);
            }

            $records[] = $validator->validated();
        }

        if ($records === []) {
            return back()->withErrors(['import_file' => 'File Excel tidak memiliki data untuk diimport.']);
        }

        DB::transaction(function () use ($records, $request) {
            foreach ($records as $record) {
                Achievement::create([
                    'title' => $record['judul'],
                    'slug' => $this->uniqueSlug($record['judul']),
                    'participant' => $record['peserta'] ?: null,
                    'category' => $record['kategori'],
                    'level' => $record['tingkat'],
                    'organizer' => $record['penyelenggara'] ?: null,
                    'rank' => $record['peringkat'] ?: null,
                    'achieved_date' => $record['tanggal_prestasi'],
                    'year' => (int) Str::before($record['tanggal_prestasi'], '-'),
                    'description' => $record['deskripsi'] ?: null,
                    'status' => $record['status'],
                    'author_id' => $request->user()->id,
                ]);
            }
        });

        activity_log('achievement.import', null, ['count' => count($records)]);

        return redirect()->route('admin.achievements.index')->with('flash', [
            'type' => 'success',
            'message' => count($records).' data prestasi berhasil diimport',
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = $this->uniqueSlug($data['title']);
        $data['year'] = (int) str($data['achieved_date'])->before('-')->toString();
        $data['author_id'] = $request->user()->id;
        $data['cover'] = $request->file('cover')?->store('achievements', 'public');
        $achievement = Achievement::create($data);
        activity_log('achievement.create', $achievement, ['title' => $achievement->title]);

        return redirect()->route('admin.achievements.index')->with('flash', ['type' => 'success', 'message' => 'Prestasi ditambahkan']);
    }

    public function edit(Achievement $achievement)
    {
        return view('admin.achievements.form', compact('achievement'));
    }

    public function update(Request $request, Achievement $achievement)
    {
        $data = $this->validated($request);
        if ($achievement->title !== $data['title']) {
            $data['slug'] = $this->uniqueSlug($data['title'], $achievement);
        }
        $data['year'] = (int) str($data['achieved_date'])->before('-')->toString();
        if ($request->hasFile('cover')) {
            if ($achievement->cover) {
                Storage::disk('public')->delete($achievement->cover);
            }
            $data['cover'] = $request->file('cover')->store('achievements', 'public');
        }
        $achievement->update($data);
        activity_log('achievement.update', $achievement, ['title' => $achievement->title]);

        return redirect()->route('admin.achievements.index')->with('flash', ['type' => 'success', 'message' => 'Prestasi diperbarui']);
    }

    public function destroy(Achievement $achievement)
    {
        activity_log('achievement.delete', $achievement, ['title' => $achievement->title]);
        $achievement->delete();

        return back()->with('flash', ['type' => 'success', 'message' => 'Prestasi dipindahkan ke sampah']);
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'participant' => ['nullable', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:50'],
            'level' => ['required', Rule::in(Achievement::LEVELS)],
            'organizer' => ['nullable', 'string', 'max:255'],
            'rank' => ['nullable', 'string', 'max:255'],
            'achieved_date' => ['required', 'date'],
            'description' => ['nullable', 'string', 'max:5000'],
            'cover' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'status' => ['required', Rule::in(['draft', 'published'])],
        ]);
    }

    private function uniqueSlug(string $title, ?Achievement $ignore = null): string
    {
        $base = Str::slug($title) ?: Str::random(8);
        $slug = $base;
        $suffix = 2;
        while (Achievement::withTrashed()->where('slug', $slug)->when($ignore, fn ($query) => $query->whereKeyNot($ignore->id))->exists()) {
            $slug = $base.'-'.$suffix++;
        }

        return $slug;
    }

    private function normalizeExcelDate(mixed $value): mixed
    {
        if ($value instanceof DateTimeInterface) {
            return $value->format('Y-m-d');
        }

        if (is_numeric($value)) {
            try {
                return SpreadsheetDate::excelToDateTimeObject((float) $value)->format('Y-m-d');
            } catch (Throwable) {
                return $value;
            }
        }

        return $value;
    }

    private const IMPORT_HEADERS = [
        'judul', 'peserta', 'kategori', 'tingkat', 'penyelenggara',
        'peringkat', 'tanggal_prestasi', 'deskripsi', 'status',
    ];
}
