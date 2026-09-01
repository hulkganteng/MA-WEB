<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Throwable;
use ZipArchive;

class BackupController extends Controller
{
    private const DIRECTORY = 'backups';

    public function index(): View
    {
        $disk = Storage::disk('local');
        $backups = collect($disk->files(self::DIRECTORY))
            ->filter(fn (string $path) => $this->validFilename(basename($path)))
            ->map(fn (string $path) => [
                'filename' => basename($path),
                'size' => $this->formatBytes($disk->size($path)),
                'created_at' => date('d M Y, H:i', $disk->lastModified($path)),
                'timestamp' => $disk->lastModified($path),
            ])
            ->sortByDesc('timestamp')
            ->values();

        return view('admin.backups.index', compact('backups'));
    }

    public function store(): RedirectResponse
    {
        if (! class_exists(ZipArchive::class)) {
            return back()->with('flash', ['type' => 'error', 'message' => 'Ekstensi ZIP belum tersedia di server.']);
        }

        $disk = Storage::disk('local');
        $disk->makeDirectory(self::DIRECTORY);
        $filename = 'backup-'.now()->format('Ymd-His').'-'.bin2hex(random_bytes(3)).'.zip';
        $path = self::DIRECTORY.'/'.$filename;
        $databasePath = self::DIRECTORY.'/database-'.bin2hex(random_bytes(6)).'.json';

        try {
            $this->writeDatabaseExport($disk->path($databasePath));

            $zip = new ZipArchive;
            if ($zip->open($disk->path($path), ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
                throw new \RuntimeException('Arsip ZIP tidak dapat dibuat.');
            }

            $zip->addFile($disk->path($databasePath), 'database.json');
            $this->addUploadsToZip($zip);

            if (! $zip->close()) {
                throw new \RuntimeException('Arsip ZIP tidak dapat disimpan.');
            }

            return redirect()->route('admin.backups.index')->with('flash', [
                'type' => 'success',
                'message' => 'Backup data berhasil dibuat.',
            ]);
        } catch (Throwable $exception) {
            report($exception);
            $disk->delete($path);

            return redirect()->route('admin.backups.index')->with('flash', [
                'type' => 'error',
                'message' => 'Backup gagal dibuat. Periksa ruang penyimpanan dan konfigurasi server.',
            ]);
        } finally {
            $disk->delete($databasePath);
        }
    }

    public function download(string $filename): BinaryFileResponse
    {
        $path = $this->backupPath($filename);
        abort_unless(Storage::disk('local')->exists($path), 404);

        return response()->download(Storage::disk('local')->path($path), $filename);
    }

    public function destroy(string $filename): RedirectResponse
    {
        $path = $this->backupPath($filename);
        abort_unless(Storage::disk('local')->exists($path), 404);
        Storage::disk('local')->delete($path);

        return redirect()->route('admin.backups.index')->with('flash', [
            'type' => 'success',
            'message' => 'File backup berhasil dihapus.',
        ]);
    }

    private function writeDatabaseExport(string $path): void
    {
        $handle = fopen($path, 'wb');
        if ($handle === false) {
            throw new \RuntimeException('File database sementara tidak dapat dibuat.');
        }

        try {
            fwrite($handle, "{\n");
            $tables = $this->tableNames();

            foreach ($tables as $index => $table) {
                fwrite($handle, json_encode($table).':[');
                $firstRow = true;

                foreach (DB::table($table)->cursor() as $row) {
                    fwrite($handle, $firstRow ? '' : ',');
                    fwrite($handle, json_encode($row, JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE));
                    $firstRow = false;
                }

                fwrite($handle, ']');
                fwrite($handle, $index === array_key_last($tables) ? "\n" : ",\n");
            }

            fwrite($handle, '}');
        } finally {
            fclose($handle);
        }
    }

    private function tableNames(): array
    {
        $connection = DB::connection();

        return match ($connection->getDriverName()) {
            'sqlite' => collect($connection->select("SELECT name FROM sqlite_master WHERE type = 'table' AND name NOT LIKE 'sqlite_%' ORDER BY name"))->pluck('name')->all(),
            'mysql', 'mariadb' => collect($connection->select('SHOW FULL TABLES WHERE Table_type = \'BASE TABLE\''))->map(fn ($row) => array_values((array) $row)[0])->all(),
            'pgsql' => collect($connection->select("SELECT tablename FROM pg_catalog.pg_tables WHERE schemaname = 'public' ORDER BY tablename"))->pluck('tablename')->all(),
            'sqlsrv' => collect($connection->select("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE' ORDER BY TABLE_NAME"))->pluck('TABLE_NAME')->all(),
            default => throw new \RuntimeException('Driver database tidak didukung untuk backup.'),
        };
    }

    private function addUploadsToZip(ZipArchive $zip): void
    {
        $root = rtrim(Storage::disk('public')->path(''), '\\/');
        if (! is_dir($root)) {
            return;
        }

        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($root, RecursiveDirectoryIterator::SKIP_DOTS));
        foreach ($files as $file) {
            if ($file->isFile()) {
                $relativePath = str_replace('\\', '/', substr($file->getPathname(), strlen($root) + 1));
                $zip->addFile($file->getPathname(), 'uploads/'.$relativePath);
            }
        }
    }

    private function backupPath(string $filename): string
    {
        abort_unless($this->validFilename($filename), 404);

        return self::DIRECTORY.'/'.$filename;
    }

    private function validFilename(string $filename): bool
    {
        return preg_match('/\Abackup-\d{8}-\d{6}-[a-f0-9]{6}\.zip\z/', $filename) === 1;
    }

    private function formatBytes(int $bytes): string
    {
        if ($bytes < 1024) {
            return $bytes.' B';
        }

        if ($bytes < 1048576) {
            return number_format($bytes / 1024, 1, ',', '.').' KB';
        }

        return number_format($bytes / 1048576, 1, ',', '.').' MB';
    }
}
