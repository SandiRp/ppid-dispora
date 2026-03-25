<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PpidController;
use App\Http\Controllers\PermohonanController;

// 1. DASHBOARD
Route::get('/', [PpidController::class, 'dashboard'])->name('dashboard');
// Rute Kumpulan Semua Berita & Detail Berita
Route::get('/berita', [PpidController::class, 'semuaBerita'])->name('berita.index');
Route::get('/berita/{slug}', [PpidController::class, 'detailBerita'])->name('berita.show');

// 2. MENU PROFIL
Route::prefix('profil')->name('profil.')->group(function () {
    Route::get('/ppid', [PpidController::class, 'profilPpid'])->name('ppid');
    Route::get('/visi-misi', [PpidController::class, 'visiMisi'])->name('visi-misi');
    Route::get('/struktur-organisasi', [PpidController::class, 'strukturOrganisasi'])->name('struktur');
    Route::get('/maklumat-layanan', [PpidController::class, 'maklumatLayanan'])->name('maklumat');
});

// 3. MENU DOKUMEN
Route::prefix('dokumen')->name('dokumen.')->group(function () {
    Route::get('/regulasi', [PpidController::class, 'regulasi'])->name('regulasi');
    Route::get('/sop', [PpidController::class, 'sop'])->name('sop');
    Route::get('/sk-ppid', [PpidController::class, 'skPpid'])->name('sk');
});

// 4. MENU DAFTAR INFORMASI
// Rute untuk Menu Daftar Informasi Publik
Route::get('/informasi/berkala', [App\Http\Controllers\PpidController::class, 'informasiBerkala'])->name('informasi.berkala');
Route::get('/informasi/serta-merta', [App\Http\Controllers\PpidController::class, 'informasiSertaMerta'])->name('informasi.serta-merta');
Route::get('/informasi/setiap-saat', [App\Http\Controllers\PpidController::class, 'informasiSetiapSaat'])->name('informasi.setiap-saat');
Route::get('/informasi/dikecualikan', [App\Http\Controllers\PpidController::class, 'informasiDikecualikan'])->name('informasi.dikecualikan');

// 5. MENU LAPORAN
// Rute Menu Laporan Publik

Route::prefix('laporan')->name('laporan.')->group(function () {
    Route::get('/agenda-bulanan', [PpidController::class, 'agenda'])->name('agenda');
});
// Rute Menu Laporan Publik
Route::get('/laporan/akses-informasi', [App\Http\Controllers\PpidController::class, 'laporanAkses'])->name('laporan.akses');
Route::get('/laporan/pelayanan-publik', [App\Http\Controllers\PpidController::class, 'laporanPelayanan'])->name('laporan.pelayanan');

// Rute untuk Sistem Permohonan Informasi
Route::get('/ajukan-permohonan', [PermohonanController::class, 'create'])->name('permohonan.create');
Route::post('/ajukan-permohonan', [PermohonanController::class, 'store'])->name('permohonan.store');


// --- RUTE LOGIN ---
Route::get('/login', [App\Http\Controllers\AuthController::class, 'login'])->name('login')->middleware('guest');
Route::post('/login', [App\Http\Controllers\AuthController::class, 'authenticate'])->name('authenticate');
Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
// Rute Halaman Admin
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/permohonan', [App\Http\Controllers\PermohonanController::class, 'index'])->name('permohonan.index');

    // update status
    Route::put('/permohonan/{id}/status', [App\Http\Controllers\PermohonanController::class, 'updateStatus'])->name('permohonan.update-status');

    // Rute Baru untuk Kelola Berita
    Route::resource('berita', App\Http\Controllers\BeritaController::class);
    // Rute Baru untuk Kelola Dokumen
    Route::resource('dokumen', App\Http\Controllers\DokumenController::class);
    // Rute Baru untuk Kelola Daftar Informasi Publik
    Route::resource('informasi', App\Http\Controllers\InformasiController::class);
    Route::resource('laporan', App\Http\Controllers\LaporanController::class);
    // Rute untuk kelola Agenda
    Route::resource('agenda', App\Http\Controllers\AgendaController::class);
});
