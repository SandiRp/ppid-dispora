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

        // Data berita terbaru yang sudah terbit (published)
        $beritaTerbaru = Berita::where('status', 'published')->orderBy('tanggal_publish', 'desc')->take(3)->get();

        // Kirim semua variabel angka tersebut ke halaman view
        return view('pages.dashboard', compact('beritaTerbaru', 'totalPermintaan', 'permintaanProses', 'permintaanSelesai'));
    }
    // Menampilkan halaman Kumpulan Semua Berita
    public function semuaBerita()
    {
        // Mengambil semua berita yang berstatus published dengan pagination
        $beritas = Berita::where('status', 'published')->latest('tanggal_publish')->paginate(9);
        return view('pages.berita.index', compact('beritas'));
    }

    // Menampilkan halaman Detail (Baca) Berita
    public function detailBerita($slug)
    {
        // Mencari berita berdasarkan slug di URL (hanya yang sudah terbit atau jika admin)
        $berita = Berita::where('slug', $slug)
            ->when(!auth()->check(), fn($q) => $q->where('status', 'published'))
            ->firstOrFail();

        // Mengambil 4 berita terbaru lainnya untuk rekomendasi di sidebar
        $beritaLainnya = Berita::where('status', 'published')
            ->where('id', '!=', $berita->id)
            ->latest('tanggal_publish')
            ->take(4)
            ->get();

        return view('pages.berita.show', compact('berita', 'beritaLainnya'));
    }

    // --- 2. PROFIL ---
    public function profilPpid()
    {
        $setting = \App\Models\ProfilSetting::getByKey('profil_ppid');
        return view('pages.profil.ppid', compact('setting'));
    }
    public function visiMisi()
    {
        $setting = \App\Models\ProfilSetting::getByKey('visi_misi');
        return view('pages.profil.visi-misi', compact('setting'));
    }
    public function strukturOrganisasi()
    {
        $setting = \App\Models\ProfilSetting::getByKey('struktur');
        return view('pages.profil.struktur', compact('setting'));
    }
    public function maklumatLayanan()
    {
        $setting = \App\Models\ProfilSetting::getByKey('maklumat');
        return view('pages.profil.maklumat', compact('setting'));
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
    public function dipTerpadu(Request $request)
    {
        $q = trim($request->get('q', ''));
        $kategori = $request->get('kategori', '');
        $tahun = $request->get('tahun', '');

        $publicCategories = ['berkala', 'serta_merta', 'setiap_saat'];

        $informasis = Informasi::whereIn('kategori', $publicCategories)
            ->when($kategori && in_array($kategori, $publicCategories), fn($query) => $query->where('kategori', $kategori))
            ->when($tahun, fn($query) => $query->where('tahun', $tahun))
            ->when($q, function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('ringkasan_informasi', 'like', "%{$q}%")
                        ->orWhere('deskripsi', 'like', "%{$q}%")
                        ->orWhere('penanggung_jawab', 'like', "%{$q}%");
                });
            })
            ->orderBy('tahun', 'desc')
            ->latest()
            ->paginate(25)
            ->withQueryString();

        $countBerkala = Informasi::where('kategori', 'berkala')->count();
        $countSertaMerta = Informasi::where('kategori', 'serta_merta')->count();
        $countSetiapSaat = Informasi::where('kategori', 'setiap_saat')->count();
        $countDikecualikan = Informasi::where('kategori', 'dikecualikan')->count();

        $daftarTahun = Informasi::whereIn('kategori', $publicCategories)
            ->whereNotNull('tahun')
            ->select('tahun')
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun')
            ->toArray();

        if (empty($daftarTahun)) {
            $daftarTahun = [date('Y')];
        }

        return view('pages.informasi.dip-terpadu', compact(
            'informasis',
            'countBerkala',
            'countSertaMerta',
            'countSetiapSaat',
            'countDikecualikan',
            'daftarTahun'
        ));
    }

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

    // --- 6. MENU STANDAR LAYANAN PUBLIK (Monev KI) ---
    public function prosedurLayanan()
    {
        return view('pages.standar.prosedur');
    }

    public function hakKewajiban()
    {
        return view('pages.standar.hak-kewajiban');
    }

    public function faq()
    {
        return view('pages.standar.faq');
    }

    public function kontak()
    {
        return view('pages.standar.kontak');
    }
}
