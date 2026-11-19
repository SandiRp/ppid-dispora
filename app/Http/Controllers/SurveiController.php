<?php

namespace App\Http\Controllers;

use App\Models\Survei;
use App\Models\Permohonan;
use Illuminate\Http\Request;

class SurveiController extends Controller
{
    // Halaman Form Pengisian Survei IKM Publik
    public function create(Request $request)
    {
        $nomor = trim($request->get('nomor', ''));
        $verifiedId = session('lacak_verified_permohonan_id');
        $permohonan = null;

        if ($verifiedId) {
            $permohonan = Permohonan::find($verifiedId);
        } elseif ($nomor) {
            // Jika ada query nomor tetapi tidak ada session verifikasi ganda NIK,
            // JANGAN autofill nama/email demi mencegah kebocoran data pemohon (UU PDP)
            $permohonan = null;
        }

        // Cek apakah permohonan ini sudah pernah dinilai survei
        if ($permohonan && Survei::where('permohonan_id', $permohonan->id)->exists()) {
            return redirect()->route('permohonan.lacak')
                ->with('success', 'Anda sudah pernah mengisi survei kepuasan untuk permohonan ini. Terima kasih atas partisipasi Anda!');
        }

        return view('pages.survei.create', compact('permohonan', 'nomor'));
    }

    // Memproses Simpan Survei IKM
    public function store(Request $request)
    {
        $validated = $request->validate([
            'permohonan_id' => 'nullable|exists:permohonans,id',
            'nama_responden' => 'required|string|max:255',
            'email_responden' => 'nullable|email|max:255',
            'kesesuaian_persyaratan' => 'required|integer|between:1,4',
            'kemudahan_prosedur' => 'required|integer|between:1,4',
            'kecepatan_waktu' => 'required|integer|between:1,4',
            'kewajaran_biaya' => 'required|integer|between:1,4',
            'kesesuaian_produk' => 'required|integer|between:1,4',
            'kompetensi_petugas' => 'required|integer|between:1,4',
            'kesopanan_petugas' => 'required|integer|between:1,4',
            'kualitas_sarana' => 'required|integer|between:1,4',
            'penanganan_pengaduan' => 'required|integer|between:1,4',
            'saran_masukan' => 'nullable|string',
        ]);

        if (!empty($validated['permohonan_id'])) {
            if (Survei::where('permohonan_id', $validated['permohonan_id'])->exists()) {
                return redirect()->route('permohonan.lacak')
                    ->with('success', 'Survei kepuasan untuk permohonan ini sudah pernah diisi sebelumnya.');
            }
        }

        $indikator = [
            $validated['kesesuaian_persyaratan'],
            $validated['kemudahan_prosedur'],
            $validated['kecepatan_waktu'],
            $validated['kewajaran_biaya'],
            $validated['kesesuaian_produk'],
            $validated['kompetensi_petugas'],
            $validated['kesopanan_petugas'],
            $validated['kualitas_sarana'],
            $validated['penanganan_pengaduan'],
        ];

        $skorRataRata = array_sum($indikator) / count($indikator);
        $nilaiIkm = $skorRataRata * 25; // Konversi Permenpan RB (1-4 -> 25-100)

        $validated['skor_rata_rata'] = round($skorRataRata, 2);
        $validated['nilai_ikm'] = round($nilaiIkm, 2);

        Survei::create($validated);

        return redirect()->route('laporan.statistik')->with('success', 'Terima kasih! Penilaian Indeks Kepuasan Masyarakat (IKM) Anda telah berhasil kami simpan.');
    }

    // Admin: Rekapitulasi Survei IKM
    public function adminIndex()
    {
        $totalResponden = Survei::count();
        $rataRataIkm = Survei::avg('nilai_ikm') ?? 0;

        $mutu = 'Belum Ada Data';
        if ($totalResponden > 0) {
            if ($rataRataIkm >= 88.31) $mutu = 'Sangat Baik (A)';
            elseif ($rataRataIkm >= 76.61) $mutu = 'Baik (B)';
            elseif ($rataRataIkm >= 65.00) $mutu = 'Kurang Baik (C)';
            else $mutu = 'Tidak Baik (D)';
        }

        $surveis = Survei::with('permohonan')->latest()->paginate(20);

        return view('pages.admin.survei.index', compact('surveis', 'totalResponden', 'rataRataIkm', 'mutu'));
    }

    // Admin: Ekspor Data Survei IKM ke CSV (9 Unsur Permenpan RB)
    public function export()
    {
        $items = Survei::with('permohonan')->latest()->get();
        $filename = "rekap_survei_ikm_ppid_" . date('Ymd_His') . ".csv";

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($items) {
            $file = fopen('php://output', 'w');
            fputs($file, "\xEF\xBB\xBF"); // BOM UTF-8

            fputcsv($file, [
                'No.',
                'Tanggal Survei',
                'No. Registrasi Terkait',
                'Nama Responden',
                'Email',
                'U1: Persyaratan',
                'U2: Prosedur',
                'U3: Kecepatan Waktu',
                'U4: Biaya/Tarif',
                'U5: Produk Layanan',
                'U6: Kompetensi Petugas',
                'U7: Kesopanan Petugas',
                'U8: Kualitas Sarana',
                'U9: Penanganan Pengaduan',
                'Skor Rata-Rata (1-4)',
                'Nilai IKM (25-100)',
                'Saran & Masukan'
            ], ';');

            $no = 1;
            foreach ($items as $item) {
                fputcsv($file, [
                    $no++,
                    $item->created_at ? $item->created_at->format('Y-m-d H:i') : '-',
                    $item->permohonan->nomor_registrasi ?? '-',
                    $item->nama_responden,
                    $item->email_responden ?: '-',
                    $item->kesesuaian_persyaratan,
                    $item->kemudahan_prosedur,
                    $item->kecepatan_waktu,
                    $item->kewajaran_biaya,
                    $item->kesesuaian_produk,
                    $item->kompetensi_petugas,
                    $item->kesopanan_petugas,
                    $item->kualitas_sarana,
                    $item->penanganan_pengaduan,
                    $item->skor_rata_rata,
                    $item->nilai_ikm,
                    $item->saran_masukan ?: '-'
                ], ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
