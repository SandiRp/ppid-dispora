<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permohonan;
use App\Models\Keberatan;
use App\Models\Berita;
use App\Models\Dokumen;
use App\Models\Informasi;
use App\Models\Laporan;
use App\Models\Agenda;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // 1. Statistik Utama Permohonan
        $totalPermohonan = Permohonan::count();
        $permohonanMenunggu = Permohonan::where('status', 'menunggu')->count();
        $permohonanDiproses = Permohonan::where('status', 'diproses')->count();
        $permohonanSelesai = Permohonan::where('status', 'selesai')->count();
        $permohonanDitolak = Permohonan::where('status', 'ditolak')->count();

        // 2. Statistik Keberatan
        $totalKeberatan = Keberatan::count();
        $keberatanMenunggu = Keberatan::where('status', 'menunggu')->count();

        // 3. Statistik Konten
        $totalBerita = Berita::count();
        $totalDokumen = Dokumen::count();
        $totalInformasi = Informasi::count();
        $totalLaporan = Laporan::count();
        $totalAgenda = Agenda::count();

        // 4. Deteksi Peringatan Batas Waktu SLA Otomatis (UU KIP)
        $permohonanAktif = Permohonan::whereIn('status', ['menunggu', 'diproses'])->get();
        $permohonanMendekatiSla = collect();
        $permohonanLewatSla = collect();

        foreach ($permohonanAktif as $p) {
            $sla = $p->sla_info;
            if ($sla['status_sla'] === 'expired') {
                $permohonanLewatSla->push($p);
            } elseif ($sla['status_sla'] === 'warning') {
                $permohonanMendekatiSla->push($p);
            }
        }

        // 5. Permohonan Terakhir Masuk
        $permohonanTerbaru = Permohonan::latest()->take(6)->get();

        // 6. Audit Log Aktivitas Terbaru
        $aktivitasTerbaru = AuditLog::latest()->take(8)->get();

        return view('pages.admin.dashboard', compact(
            'totalPermohonan',
            'permohonanMenunggu',
            'permohonanDiproses',
            'permohonanSelesai',
            'permohonanDitolak',
            'totalKeberatan',
            'keberatanMenunggu',
            'totalBerita',
            'totalDokumen',
            'totalInformasi',
            'totalLaporan',
            'totalAgenda',
            'permohonanMendekatiSla',
            'permohonanLewatSla',
            'permohonanTerbaru',
            'aktivitasTerbaru'
        ));
    }
}
