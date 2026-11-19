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
Route::get('/informasi/dip-terpadu', [App\Http\Controllers\PpidController::class, 'dipTerpadu'])->name('informasi.dip');
Route::get('/informasi/berkala', [App\Http\Controllers\PpidController::class, 'informasiBerkala'])->name('informasi.berkala');
Route::get('/informasi/serta-merta', [App\Http\Controllers\PpidController::class, 'informasiSertaMerta'])->name('informasi.serta-merta');
Route::get('/informasi/setiap-saat', [App\Http\Controllers\PpidController::class, 'informasiSetiapSaat'])->name('informasi.setiap-saat');
Route::get('/informasi/dikecualikan', [App\Http\Controllers\PpidController::class, 'informasiDikecualikan'])->name('informasi.dikecualikan');

// 4B. MENU STANDAR LAYANAN PUBLIK (Monev KI)
Route::prefix('standar-layanan')->name('standar.')->group(function () {
    Route::get('/prosedur-dan-biaya', [PpidController::class, 'prosedurLayanan'])->name('prosedur');
    Route::get('/hak-dan-kewajiban', [PpidController::class, 'hakKewajiban'])->name('hak-kewajiban');
    Route::get('/faq', [PpidController::class, 'faq'])->name('faq');
    Route::get('/kontak-dan-lokasi', [PpidController::class, 'kontak'])->name('kontak');
});

// Rute Sitemap XML & Pencarian Global
Route::get('/sitemap.xml', [\App\Http\Controllers\SitemapController::class, 'index'])->name('sitemap');
Route::get('/cari', [\App\Http\Controllers\PencarianController::class, 'search'])->name('cari');

// 5. MENU LAPORAN
Route::prefix('laporan')->name('laporan.')->group(function () {
    Route::get('/statistik-pelayanan', [\App\Http\Controllers\StatistikController::class, 'index'])->name('statistik');
    Route::get('/agenda-bulanan', [PpidController::class, 'agenda'])->name('agenda');
    Route::get('/akses-informasi', [App\Http\Controllers\PpidController::class, 'laporanAkses'])->name('akses');
    Route::get('/pelayanan-publik', [App\Http\Controllers\PpidController::class, 'laporanPelayanan'])->name('pelayanan');
});

// Survei Kepuasan Masyarakat (IKM)
Route::get('/survei-ikm', [\App\Http\Controllers\SurveiController::class, 'create'])->name('survei.create');
Route::post('/survei-ikm', [\App\Http\Controllers\SurveiController::class, 'store'])->name('survei.store');

// Rute untuk Sistem Permohonan Informasi
Route::get('/ajukan-permohonan', [PermohonanController::class, 'create'])->name('permohonan.create');
Route::post('/ajukan-permohonan', [PermohonanController::class, 'store'])->name('permohonan.store')->middleware('throttle:10,1');
Route::get('/lacak-permohonan', [PermohonanController::class, 'lacak'])->name('permohonan.lacak');
Route::post('/lacak-permohonan', [PermohonanController::class, 'lacakPost'])->name('permohonan.lacak.post')->middleware('throttle:10,1');
Route::get('/permohonan/{id}/download-jawaban', [PermohonanController::class, 'downloadJawaban'])->name('permohonan.download-jawaban');

// Rute untuk Sistem Pengajuan Keberatan Informasi Publik
Route::get('/pengajuan-keberatan', [\App\Http\Controllers\KeberatanController::class, 'create'])->name('keberatan.create');
Route::post('/pengajuan-keberatan', [\App\Http\Controllers\KeberatanController::class, 'store'])->name('keberatan.store')->middleware('throttle:10,1');


// --- RUTE LOGIN & LUPA PASSWORD ---
Route::get('/login', [App\Http\Controllers\AuthController::class, 'login'])->name('login')->middleware('guest');
Route::post('/login', [App\Http\Controllers\AuthController::class, 'authenticate'])->name('authenticate')->middleware('throttle:5,1');
Route::get('/forgot-password', [App\Http\Controllers\AuthController::class, 'forgotPasswordForm'])->name('password.request')->middleware('guest');
Route::post('/forgot-password', [App\Http\Controllers\AuthController::class, 'sendResetLink'])->name('password.email')->middleware(['guest', 'throttle:5,1']);
Route::get('/reset-password/{token}', [App\Http\Controllers\AuthController::class, 'resetPasswordForm'])->name('password.reset')->middleware('guest');
Route::post('/reset-password', [App\Http\Controllers\AuthController::class, 'resetPasswordHandler'])->name('password.update')->middleware(['guest', 'throttle:5,1']);
Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout')->middleware('auth');
// Rute Halaman Admin
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    // Dashboard Admin
    Route::get('/dashboard', [\App\Http\Controllers\Admin\AdminDashboardController::class, 'index'])->name('dashboard');

    // Profil Petugas & Ganti Password Mandiri
    Route::get('/profile', [\App\Http\Controllers\Admin\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [\App\Http\Controllers\Admin\ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::put('/profile/password', [\App\Http\Controllers\Admin\ProfileController::class, 'updatePassword'])->name('profile.password');

    // Permohonan Informasi
    Route::get('/permohonan/export', [App\Http\Controllers\PermohonanController::class, 'export'])->name('permohonan.export');
    Route::get('/permohonan/create-offline', [App\Http\Controllers\PermohonanController::class, 'createOffline'])->name('permohonan.create-offline');
    Route::post('/permohonan/create-offline', [App\Http\Controllers\PermohonanController::class, 'storeOffline'])->name('permohonan.store-offline');
    Route::get('/permohonan', [App\Http\Controllers\PermohonanController::class, 'index'])->name('permohonan.index');
    Route::get('/permohonan/{id}/berkas', [App\Http\Controllers\PermohonanController::class, 'downloadBerkas'])->name('permohonan.berkas');
    Route::put('/permohonan/{id}/status', [App\Http\Controllers\PermohonanController::class, 'updateStatus'])->name('permohonan.update-status');
    Route::post('/permohonan/{id}/perpanjang-sla', [App\Http\Controllers\PermohonanController::class, 'perpanjangSla'])->name('permohonan.perpanjang-sla');

    // Kelola Keberatan (Tanggapan Resmi Khusus Super Admin / Atasan PPID)
    Route::get('/keberatan/export', [\App\Http\Controllers\KeberatanController::class, 'export'])->name('keberatan.export');
    Route::get('/keberatan', [\App\Http\Controllers\KeberatanController::class, 'index'])->name('keberatan.index');
    Route::get('/keberatan/{id}/berkas', [\App\Http\Controllers\KeberatanController::class, 'downloadBerkas'])->name('keberatan.berkas');
    Route::put('/keberatan/{id}/tanggapan', [\App\Http\Controllers\KeberatanController::class, 'updateTanggapan'])->name('keberatan.update-tanggapan')->middleware('role:superadmin');

    // Rekapitulasi Survei IKM
    Route::get('/survei-ikm/export', [\App\Http\Controllers\SurveiController::class, 'export'])->name('survei.export');
    Route::get('/survei-ikm', [\App\Http\Controllers\SurveiController::class, 'adminIndex'])->name('survei.index');

    // Menu Khusus Super Admin (Manajemen Pengguna, Audit Log, & CMS Profil)
    Route::middleware('role:superadmin')->group(function () {
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
        Route::get('/audit-logs', [\App\Http\Controllers\Admin\AuditLogController::class, 'index'])->name('audit-logs.index');
        Route::get('/profil-setting', [\App\Http\Controllers\Admin\ProfilSettingController::class, 'index'])->name('profil-setting.index');
        Route::put('/profil-setting/{key}', [\App\Http\Controllers\Admin\ProfilSettingController::class, 'update'])->name('profil-setting.update');
    });

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
