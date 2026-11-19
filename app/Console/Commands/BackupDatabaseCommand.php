<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class BackupDatabaseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ppid:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Melakukan pencadangan (backup) otomatis database PPID Dispora Jatim ke storage lokal.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Memulai proses pencadangan database PPID Dispora...');

        $dbHost = config('database.connections.mysql.host', '127.0.0.1');
        $dbPort = config('database.connections.mysql.port', '3306');
        $dbName = config('database.connections.mysql.database', 'ppid_dispora_db');
        $dbUser = config('database.connections.mysql.username', 'root');
        $dbPass = config('database.connections.mysql.password', '');

        $backupDir = storage_path('app/backups');
        if (!File::exists($backupDir)) {
            File::makeDirectory($backupDir, 0755, true);
        }

        $timestamp = date('Y-m-d_His');
        $filename = "ppid_backup_{$timestamp}.sql";
        $filePath = "{$backupDir}/{$filename}";

        // Cari lokasi mysqldump di server / Laragon
        $possibleDumpPaths = [
            'mysqldump',
            'C:\laragon\bin\mysql\mysql-8.0.30-winx64\bin\mysqldump.exe',
            '/usr/bin/mysqldump',
            '/usr/local/bin/mysqldump',
        ];

        $mysqldumpBin = 'mysqldump';
        foreach ($possibleDumpPaths as $p) {
            if ($p === 'mysqldump' || file_exists($p)) {
                $mysqldumpBin = $p;
                if ($p !== 'mysqldump') break;
            }
        }

        $passwordArg = $dbPass !== '' ? "-p\"{$dbPass}\"" : '';
        $cmd = "\"{$mysqldumpBin}\" --host={$dbHost} --port={$dbPort} --user={$dbUser} {$passwordArg} {$dbName} > \"{$filePath}\"";

        $output = [];
        $returnVar = null;
        exec($cmd, $output, $returnVar);

        if ($returnVar === 0 && file_exists($filePath) && filesize($filePath) > 0) {
            $size = round(filesize($filePath) / 1024, 2);
            $this->info("Pencadangan BERHASIL! File tersimpan di: {$filePath} ({$size} KB)");
            Log::info("PPID Database Backup berhasil: {$filename} ({$size} KB)");

            // Bersihkan file backup lama (simpan 7 file terbaru)
            $this->cleanOldBackups($backupDir);

            return Command::SUCCESS;
        } else {
            // Fallback ekspor mandiri via PDO jika mysqldump tidak ada di PATH
            $this->warn("mysqldump CLI tidak merespons, menjalankan fallback export via PDO...");
            $success = $this->fallbackPdoExport($filePath);

            if ($success) {
                $size = round(filesize($filePath) / 1024, 2);
                $this->info("Fallback backup via PDO BERHASIL! File: {$filePath} ({$size} KB)");
                Log::info("PPID Database Backup (PDO Fallback) berhasil: {$filename} ({$size} KB)");
                $this->cleanOldBackups($backupDir);
                return Command::SUCCESS;
            }

            $this->error("Gagal melakukan pencadangan database. Periksa koneksi dan izin folder storage.");
            Log::error("PPID Database Backup GAGAL dieksekusi.");
            return Command::FAILURE;
        }
    }

    protected function cleanOldBackups(string $dir, int $keep = 7): void
    {
        $files = File::glob("{$dir}/ppid_backup_*.sql");
        if (count($files) > $keep) {
            // Urutkan dari terlama
            usort($files, fn($a, $b) => filemtime($a) - filemtime($b));
            $toDelete = array_slice($files, 0, count($files) - $keep);
            foreach ($toDelete as $f) {
                File::delete($f);
                $this->line("Menghapus backup lawas: " . basename($f));
            }
        }
    }

    protected function fallbackPdoExport(string $filePath): bool
    {
        try {
            $pdo = \Illuminate\Support\Facades\DB::connection()->getPdo();
            $tables = $pdo->query('SHOW TABLES')->fetchAll(\PDO::FETCH_COLUMN);

            $sql = "-- PPID Dispora Jatim Database Dump\n-- Generated: " . date('Y-m-d H:i:s') . "\n\nSET FOREIGN_KEY_CHECKS=0;\n\n";

            foreach ($tables as $table) {
                $create = $pdo->query("SHOW CREATE TABLE `{$table}`")->fetch(\PDO::FETCH_ASSOC);
                $sql .= "DROP TABLE IF EXISTS `{$table}`;\n" . $create['Create Table'] . ";\n\n";

                $rows = $pdo->query("SELECT * FROM `{$table}`")->fetchAll(\PDO::FETCH_ASSOC);
                foreach ($rows as $row) {
                    $cols = array_map(fn($k) => "`{$k}`", array_keys($row));
                    $vals = array_map(function ($val) use ($pdo) {
                        return is_null($val) ? 'NULL' : $pdo->quote($val);
                    }, array_values($row));
                    $sql .= "INSERT INTO `{$table}` (" . implode(', ', $cols) . ") VALUES (" . implode(', ', $vals) . ");\n";
                }
                $sql .= "\n";
            }

            $sql .= "SET FOREIGN_KEY_CHECKS=1;\n";
            file_put_contents($filePath, $sql);
            return true;
        } catch (\Throwable $e) {
            $this->error("PDO Export Error: " . $e->getMessage());
            return false;
        }
    }
}
