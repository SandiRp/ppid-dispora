<?php

namespace App\Http\Controllers;

use App\Models\Permohonan;
use App\Models\Survei;
use App\Models\Keberatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatistikController extends Controller
{
    public function index(Request $request)
    {
        $tahun = $request->get('tahun', date('Y'));

        // 1. Total Permohonan per Status
        $totalPermohonan = Permohonan::whereYear('created_at', $tahun)->count();
        $selesai = Permohonan::whereYear('created_at', $tahun)->where('status', 'selesai')->count();
        $diproses = Permohonan::whereYear('created_at', $tahun)->where('status', 'diproses')->count();
        $menunggu = Permohonan::whereYear('created_at', $tahun)->where('status', 'menunggu')->count();
        $ditolak = Permohonan::whereYear('created_at', $tahun)->where('status', 'ditolak')->count();

        // 2. Kategori Pemohon
        $perorangan = Permohonan::whereYear('created_at', $tahun)->where('kategori', 'perorangan')->count();
        $lembaga = Permohonan::whereYear('created_at', $tahun)->where('kategori', 'lembaga')->count();

        // 3. Tren Permohonan per Bulan
        $trenBulan = Permohonan::select(
            DB::raw('MONTH(created_at) as bulan'),
            DB::raw('COUNT(*) as total')
        )
            ->whereYear('created_at', $tahun)
            ->groupBy('bulan')
            ->pluck('total', 'bulan')
            ->toArray();

        $dataBulanan = [];
        for ($m = 1; $m <= 12; $m++) {
            $dataBulanan[$m] = $trenBulan[$m] ?? 0;
        }

        // 4. Statistik IKM
        $totalResponden = Survei::whereYear('created_at', $tahun)->count();
        $nilaiIkm = Survei::whereYear('created_at', $tahun)->avg('nilai_ikm') ?? 0;
        $mutuIkm = 'Belum Ada';
        if ($totalResponden > 0) {
            if ($nilaiIkm >= 88.31) $mutuIkm = 'Sangat Baik (A)';
            elseif ($nilaiIkm >= 76.61) $mutuIkm = 'Baik (B)';
            elseif ($nilaiIkm >= 65.00) $mutuIkm = 'Kurang Baik (C)';
            else $mutuIkm = 'Tidak Baik (D)';
        }

        // 5. Total Keberatan
        $totalKeberatan = Keberatan::whereYear('created_at', $tahun)->count();

        // 6. Statistik Layanan Ramah Disabilitas & Kanal Layanan
        $totalDisabilitas = Permohonan::whereYear('created_at', $tahun)->where('is_disabilitas', true)->count();
        $ragamDisabilitas = Permohonan::select('ragam_disabilitas', DB::raw('COUNT(*) as total'))
            ->whereYear('created_at', $tahun)
            ->where('is_disabilitas', true)
            ->whereNotNull('ragam_disabilitas')
            ->groupBy('ragam_disabilitas')
            ->pluck('total', 'ragam_disabilitas')
            ->toArray();

        $onlineCount = Permohonan::whereYear('created_at', $tahun)->where(function ($q) {
            $q->where('tipe_permohonan', 'online')->orWhereNull('tipe_permohonan');
        })->count();
        $offlineCount = Permohonan::whereYear('created_at', $tahun)->where('tipe_permohonan', 'offline')->count();

        // Daftar tahun yang tersedia
        $daftarTahun = Permohonan::select(DB::raw('YEAR(created_at) as thn'))
            ->distinct()
            ->orderBy('thn', 'desc')
            ->pluck('thn')
            ->toArray();

        if (empty($daftarTahun)) {
            $daftarTahun = [date('Y')];
        }

        return view('pages.statistik.index', compact(
            'tahun',
            'daftarTahun',
            'totalPermohonan',
            'selesai',
            'diproses',
            'menunggu',
            'ditolak',
            'perorangan',
            'lembaga',
            'dataBulanan',
            'totalResponden',
            'nilaiIkm',
            'mutuIkm',
            'totalKeberatan',
            'totalDisabilitas',
            'ragamDisabilitas',
            'onlineCount',
            'offlineCount'
        ));
    }
}
