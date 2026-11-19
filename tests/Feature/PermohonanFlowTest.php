<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Permohonan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;

class PermohonanFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_halaman_pengajuan_permohonan_dapat_diakses(): void
    {
        $response = $this->get('/ajukan-permohonan');
        $response->assertStatus(200);
        $response->assertSee('Formulir Permohonan Informasi');
    }

    public function test_pengajuan_permohonan_berhasil_dan_nomor_registrasi_terbit(): void
    {
        Mail::fake();
        Storage::fake('local');

        $payload = [
            'kategori' => 'perorangan',
            'nik_identitas' => '3578012345670001',
            'nama_lengkap' => 'Budi Santoso',
            'email' => 'budi.santoso@example.com',
            'nomor_telepon' => '081234567890',
            'rincian_informasi' => 'Permintaan data anggaran pemuda dan olahraga tahun 2025',
            'tujuan_penggunaan' => 'Penelitian tesis akademis',
            'file_pendukung' => UploadedFile::fake()->create('ktp_budi.pdf', 500, 'application/pdf'),
        ];

        $response = $this->post('/ajukan-permohonan', $payload);

        $response->assertSessionHas('success');
        $response->assertSessionHas('nomor_registrasi');

        $this->assertDatabaseHas('permohonans', [
            'nik_identitas' => '3578012345670001',
            'email' => 'budi.santoso@example.com',
            'nama_lengkap' => 'Budi Santoso',
        ]);
    }

    public function test_verifikasi_ganda_lacak_permohonan_bekerja_dengan_aman(): void
    {
        Storage::fake('local');
        $permohonan = Permohonan::create([
            'nomor_registrasi' => Permohonan::generateNomorRegistrasi(),
            'kategori' => 'perorangan',
            'nik_identitas' => '3578998877660002',
            'nama_lengkap' => 'Siti Aminah',
            'email' => 'siti@example.com',
            'nomor_telepon' => '081299887766',
            'rincian_informasi' => 'Rincian data sarana olahraga',
            'tujuan_penggunaan' => 'Informasi umum',
            'file_pendukung' => 'dokumen_permohonan/dummy.pdf',
            'status' => 'diproses',
        ]);

        // Coba verifikasi dengan NIK salah
        $failResponse = $this->post('/lacak-permohonan', [
            'nomor' => $permohonan->nomor_registrasi,
            'nik' => '3578000000000000', // NIK salah
        ]);
        $failResponse->assertSessionHas('authError');

        // Verifikasi dengan No. Reg + NIK benar
        $successResponse = $this->post('/lacak-permohonan', [
            'nomor' => $permohonan->nomor_registrasi,
            'nik' => '3578998877660002',
        ]);
        $successResponse->assertRedirect('/lacak-permohonan');
        $successResponse->assertSessionHas('lacak_verified_permohonan_id', $permohonan->id);
    }

    public function test_unduh_berkas_jawaban_ditolak_tanpa_verifikasi(): void
    {
        Storage::fake('local');
        $permohonan = Permohonan::create([
            'nomor_registrasi' => Permohonan::generateNomorRegistrasi(),
            'kategori' => 'perorangan',
            'nik_identitas' => '3578112233440003',
            'nama_lengkap' => 'Ahmad Dahlan',
            'email' => 'ahmad@example.com',
            'nomor_telepon' => '081311223344',
            'rincian_informasi' => 'Dokumen rekapitulasi data',
            'tujuan_penggunaan' => 'Kajian publik',
            'file_pendukung' => 'dokumen_permohonan/ktp.pdf',
            'file_jawaban' => 'jawaban_permohonan/jawaban.pdf',
            'status' => 'selesai',
        ]);

        // Publik mencoba mengunduh tanpa session verifikasi -> Wajib 403 Forbidden
        $response = $this->get("/permohonan/{$permohonan->id}/download-jawaban");
        $response->assertStatus(403);
    }

    public function test_halaman_standar_layanan_dan_dip_dapat_diakses(): void
    {
        $routes = [
            '/informasi/dip-terpadu',
            '/standar-layanan/prosedur-dan-biaya',
            '/standar-layanan/hak-dan-kewajiban',
            '/standar-layanan/faq',
            '/standar-layanan/kontak-dan-lokasi',
            '/forgot-password',
        ];

        foreach ($routes as $url) {
            $this->get($url)->assertStatus(200);
        }
    }

    public function test_pembatasan_hak_akses_audit_log_dan_cms_profil(): void
    {
        $operator = User::create([
            'name' => 'Operator Uji',
            'email' => 'operator.uji@example.com',
            'password' => Hash::make('password123'),
            'role' => 'operator',
        ]);

        $superadmin = User::create([
            'name' => 'Superadmin Uji',
            'email' => 'superadmin.uji@example.com',
            'password' => Hash::make('password123'),
            'role' => 'superadmin',
        ]);

        // Operator ditolak (403)
        $this->actingAs($operator)->get('/admin/audit-logs')->assertStatus(403);
        $this->actingAs($operator)->get('/admin/profil-setting')->assertStatus(403);

        // Superadmin diizinkan (200)
        $this->actingAs($superadmin)->get('/admin/audit-logs')->assertStatus(200);
        $this->actingAs($superadmin)->get('/admin/profil-setting')->assertStatus(200);
    }
}
