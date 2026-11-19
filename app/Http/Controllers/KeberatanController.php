<?php

namespace App\Http\Controllers;

use App\Models\Keberatan;
use App\Models\Permohonan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class KeberatanController extends Controller
{
    // Menampilkan halaman formulir pengajuan keberatan publik
    public function create(Request $request)
    {
        $nomor = trim($request->get('nomor', ''));
        $verifiedId = session('lacak_verified_permohonan_id');
        $permohonan = null;
        $needsVerification = false;

        // Jika ada session permohonan terverifikasi
        if ($verifiedId) {
            $permohonan = Permohonan::find($verifiedId);
            if ($permohonan) {
                $nomor = $permohonan->nomor_registrasi;
            }
        } elseif ($nomor) {
            // Jika ada query nomor tetapi belum lolos verifikasi ganda NIK
            $needsVerification = true;
        }

        return view('pages.keberatan.create', compact('permohonan', 'nomor', 'needsVerification'));
    }

    // Memproses dan menyimpan data pengajuan keberatan
    public function store(Request $request)
    {
        $verifiedId = session('lacak_verified_permohonan_id');
        $permohonan = null;

        if ($verifiedId) {
            $permohonan = Permohonan::find($verifiedId);
        }

        // Jika belum terverifikasi dari session, validasi Nomor Registrasi + NIK
        if (!$permohonan) {
            $request->validate([
                'nomor_registrasi' => 'required|string',
                'nik_pemohon' => 'required|string',
            ], [
                'nomor_registrasi.required' => 'Nomor Registrasi permohonan wajib diisi.',
                'nik_pemohon.required' => 'NIK Pemohon wajib diisi untuk verifikasi hak keberatan.',
            ]);

            $permohonan = Permohonan::where('nomor_registrasi', trim($request->nomor_registrasi))
                ->where('nik_identitas', trim($request->nik_pemohon))
                ->first();

            if (!$permohonan) {
                return back()->withInput()->with('error', 'Verifikasi gagal: Kombinasi Nomor Registrasi dan NIK tidak cocok. Pastikan data yang dimasukkan sesuai dengan pengajuan awal.');
            }

            // Simpan session verifikasi agar pemohon langsung terautentikasi
            session(['lacak_verified_permohonan_id' => $permohonan->id]);
        }

        $validated = $request->validate([
            'nama_pemohon' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'nomor_telepon' => 'required|string|max:30',
            'alasan_keberatan' => 'required|string|max:255',
            'keterangan_keberatan' => 'required|string',
            'file_pendukung' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $validated['permohonan_id'] = $permohonan->id;
        $validated['nomor_keberatan'] = Keberatan::generateNomorKeberatan();

        if ($request->hasFile('file_pendukung')) {
            $path = $request->file('file_pendukung')->store('dokumen_keberatan', 'local');
            $validated['file_pendukung'] = $path;
        }

        $keberatan = Keberatan::create($validated);

        // Kirim email konfirmasi ke pemohon
        try {
            Mail::to($keberatan->email)->send(new \App\Mail\KeberatanDiajukanMail($keberatan));
        } catch (\Throwable $e) {
            Log::error('Gagal mengirim email keberatan: ' . $e->getMessage());
        }

        // Kirim email peringatan ke email Admin PPID
        try {
            $adminEmail = config('services.ppid.admin_email', 'disporajatim2024@gmail.com');
            if ($adminEmail) {
                Mail::raw("Ada pengajuan keberatan informasi baru dengan nomor {$keberatan->nomor_keberatan} atas permohonan {$permohonan->nomor_registrasi}. Alasan: {$keberatan->alasan_keberatan}.", function ($message) use ($adminEmail, $keberatan, $permohonan) {
                    $message->to($adminEmail)
                        ->subject("⚠️ [Pengajuan Keberatan] Nomor: {$keberatan->nomor_keberatan} - PPID Dispora Jatim");
                });
            }
        } catch (\Throwable $e) {
            Log::error('Gagal kirim notif keberatan ke admin: ' . $e->getMessage());
        }

        return redirect()->route('permohonan.lacak')
            ->with('success', 'Pengajuan keberatan berhasil dikirim dengan Nomor: ' . $keberatan->nomor_keberatan . '. Atasan PPID akan segera menindaklanjuti.');
    }

    // Admin: Menampilkan daftar pengajuan keberatan (dengan Paginasi & Pencarian)
    public function index(Request $request)
    {
        $query = Keberatan::with('permohonan');

        if ($request->filled('q')) {
            $keyword = trim($request->q);
            $query->where(function ($q) use ($keyword) {
                $q->where('nomor_keberatan', 'like', "%{$keyword}%")
                  ->orWhere('nama_pemohon', 'like', "%{$keyword}%")
                  ->orWhere('email', 'like', "%{$keyword}%")
                  ->orWhere('alasan_keberatan', 'like', "%{$keyword}%")
                  ->orWhereHas('permohonan', function ($pq) use ($keyword) {
                      $pq->where('nomor_registrasi', 'like', "%{$keyword}%");
                  });
            });
        }

        if ($request->filled('status')) {
            $query->where('status_tanggapan', $request->status);
        }

        $keberatans = $query->latest()->paginate(20)->withQueryString();

        return view('pages.admin.keberatan.index', compact('keberatans'));
    }

    // Admin: Ekspor Data Keberatan ke CSV
    public function export(Request $request)
    {
        $query = Keberatan::with('permohonan');

        if ($request->filled('q')) {
            $keyword = trim($request->q);
            $query->where(function ($q) use ($keyword) {
                $q->where('nomor_keberatan', 'like', "%{$keyword}%")
                  ->orWhere('nama_pemohon', 'like', "%{$keyword}%")
                  ->orWhere('email', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status_tanggapan', $request->status);
        }

        $items = $query->latest()->get();
        $filename = "rekap_keberatan_ppid_" . date('Ymd_His') . ".csv";

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($items) {
            $file = fopen('php://output', 'w');
            fputs($file, "\xEF\xBB\xBF"); // BOM UTF-8

            fputcsv($file, [
                'No.',
                'Nomor Keberatan',
                'Nomor Registrasi Permohonan',
                'Tanggal Pengajuan',
                'Nama Pemohon Keberatan',
                'Email',
                'Nomor Telepon',
                'Alasan Keberatan',
                'Keterangan / Dalil',
                'Status Tanggapan',
                'Tanggapan Atasan PPID',
                'Tanggal Tanggapan'
            ], ';');

            $no = 1;
            foreach ($items as $item) {
                fputcsv($file, [
                    $no++,
                    $item->nomor_keberatan,
                    $item->permohonan->nomor_registrasi ?? '-',
                    $item->created_at ? $item->created_at->format('Y-m-d H:i') : '-',
                    $item->nama_pemohon,
                    $item->email,
                    "'" . $item->nomor_telepon,
                    $item->alasan_keberatan,
                    $item->keterangan_keberatan,
                    ucfirst($item->status_tanggapan ?? 'menunggu'),
                    $item->tanggapan_atasan ?? '-',
                    $item->tanggal_tanggapan ? $item->tanggal_tanggapan->format('Y-m-d H:i') : '-'
                ], ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // Admin: Mengunduh berkas pendukung keberatan secara aman
    public function downloadBerkas($id)
    {
        $keberatan = Keberatan::findOrFail($id);

        if (!$keberatan->file_pendukung) {
            return back()->with('error', 'Berkas pendukung tidak ditemukan.');
        }

        if (\Illuminate\Support\Facades\Storage::disk('local')->exists($keberatan->file_pendukung)) {
            return \Illuminate\Support\Facades\Storage::disk('local')->response($keberatan->file_pendukung);
        }

        return back()->with('error', 'File fisik tidak ditemukan di server.');
    }

    // Admin: Memperbarui tanggapan Atasan PPID atas keberatan
    public function updateTanggapan(Request $request, $id)
    {
        $keberatan = Keberatan::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:menunggu,diproses,selesai,ditolak',
            'tanggapan_atasan_ppid' => 'required|string',
        ]);

        $validated['tanggal_tanggapan'] = now();
        $keberatan->update($validated);

        // Catat Audit Log
        \App\Models\AuditLog::record(
            'STATUS_CHANGE',
            'keberatan',
            "Memberikan tanggapan keberatan {$keberatan->nomor_keberatan} dengan status " . strtoupper($request->status),
            $keberatan->nomor_keberatan
        );

        // Kirim email pemberitahuan ke pemohon
        try {
            Mail::to($keberatan->email)->send(new \App\Mail\KeberatanDitanggapiMail($keberatan));
        } catch (\Throwable $e) {
            Log::error('Gagal mengirim email tanggapan keberatan: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Tanggapan Atasan PPID untuk keberatan ' . $keberatan->nomor_keberatan . ' berhasil disimpan dan dikirimkan ke pemohon!');
    }
}
