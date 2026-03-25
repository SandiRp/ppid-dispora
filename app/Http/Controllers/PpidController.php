<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permohonan;
use App\Models\Berita;
use App\Models\Dokumen;
use App\Models\Informasi;
use App\Models\Laporan;
use App\Models\Agenda;

class PpidController extends Controller
{
    // --- 1. DASHBOARD ---
    public function dashboard()
    {
        // Menghitung statistik permohonan dari database
        $totalPermintaan = Permohonan::count();

        // Kita gabungkan status 'menunggu' dan 'diproses' sebagai data yang sedang berjalan
        $permintaanProses = Permohonan::whereIn('status', ['menunggu', 'diproses'])->count();

        // Menghitung yang statusnya sudah 'selesai'
        $permintaanSelesai = Permohonan::where('status', 'selesai')->count();

        // Data berita sementara (biarkan kosong dulu)
        $beritaTerbaru = Berita::orderBy('tanggal_publish', 'desc')->take(3)->get();

        // Kirim semua variabel angka tersebut ke halaman view
        return view('pages.dashboard', compact('beritaTerbaru', 'totalPermintaan', 'permintaanProses', 'permintaanSelesai'));
    }
    // Menampilkan halaman Kumpulan Semua Berita
    public function semuaBerita()
    {
        // Mengambil semua berita dengan fitur pagination (9 berita per halaman)
        $beritas = Berita::latest('tanggal_publish')->paginate(9);
        return view('pages.berita.index', compact('beritas'));
    }

    // Menampilkan halaman Detail (Baca) Berita
    public function detailBerita($slug)
    {
        // Mencari berita berdasarkan slug di URL
        $berita = Berita::where('slug', $slug)->firstOrFail();

        // Mengambil 4 berita terbaru lainnya untuk rekomendasi di sidebar
        $beritaLainnya = Berita::where('id', '!=', $berita->id)->latest('tanggal_publish')->take(4)->get();

        return view('pages.berita.show', compact('berita', 'beritaLainnya'));
    }

    // --- 2. PROFIL ---
    public function profilPpid()
    {
        return view('pages.profil.ppid');
    }
    public function visiMisi()
    {
        return view('pages.profil.visi-misi');
    }
    public function strukturOrganisasi()
    {
        return view('pages.profil.struktur');
    }
    public function maklumatLayanan()
    {
        return view('pages.profil.maklumat');
    }

    // --- 3. DOKUMEN ---
    public function regulasi()
    {
        // Ambil semua dokumen kategori 'regulasi' urut dari terbaru
        $dokumens = Dokumen::where('kategori', 'regulasi')->orderBy('tahun', 'desc')->latest()->get();
        $terbaru = $dokumens->first(); // Mengambil 1 file paling atas untuk ditampilkan di iframe
        return view('pages.dokumen.regulasi', compact('dokumens', 'terbaru'));
    }
    public function sop()
    {
        $dokumens = \App\Models\Dokumen::where('kategori', 'sop')->orderBy('tahun', 'desc')->latest()->get();
        $terbaru = $dokumens->first();

        // PASTIKAN ada compact('dokumens', 'terbaru') di sini
        return view('pages.dokumen.sop', compact('dokumens', 'terbaru'));
    }
    public function skPpid()
    {
        // Ambil semua dokumen kategori 'sk'
        $dokumens = \App\Models\Dokumen::where('kategori', 'sk')->orderBy('tahun', 'desc')->latest()->get();
        $terbaru = $dokumens->first();

        // PASTIKAN ada compact('dokumens', 'terbaru') di sini
        return view('pages.dokumen.sk', compact('dokumens', 'terbaru'));
    }

    // --- 4. DAFTAR INFORMASI PUBLIK ---
    public function informasiBerkala()
    {
        // Ambil data khusus kategori 'berkala'
        $informasis = Informasi::where('kategori', 'berkala')->orderBy('tahun', 'desc')->get();
        return view('pages.informasi.berkala', compact('informasis'));
    }

    public function informasiSertaMerta()
    {
        $informasis = Informasi::where('kategori', 'serta_merta')->orderBy('tahun', 'desc')->get();
        return view('pages.informasi.serta-merta', compact('informasis'));
    }

    public function informasiSetiapSaat()
    {
        $informasis = Informasi::where('kategori', 'setiap_saat')->orderBy('tahun', 'desc')->get();
        return view('pages.informasi.setiap-saat', compact('informasis'));
    }

    public function informasiDikecualikan()
    {
        $informasis = Informasi::where('kategori', 'dikecualikan')->orderBy('tahun', 'desc')->get();
        return view('pages.informasi.dikecualikan', compact('informasis'));
    }

    // --- 5. LAPORAN ---
    // --- 5. LAPORAN ---
    public function laporanAkses()
    {
        // Ambil data laporan akses, urutkan dari tahun terbaru
        $laporans = Laporan::where('kategori', 'akses')->orderBy('tahun', 'desc')->get();
        return view('pages.laporan.akses', compact('laporans'));
    }

    public function laporanPelayanan()
    {
        // Ambil data laporan pelayanan, urutkan dari tahun terbaru
        $laporans = Laporan::where('kategori', 'pelayanan')->orderBy('tahun', 'desc')->get();
        return view('pages.laporan.pelayanan', compact('laporans'));
    }
    public function agenda()
    {
        // Mengambil semua agenda, diurutkan dari tanggal paling dekat/baru
        $agendas = Agenda::orderBy('tanggal', 'desc')->get();

        return view('pages.laporan.agenda', compact('agendas')); // Sesuaikan path view-nya dengan folder Anda
    }
}
