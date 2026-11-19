<?php

namespace App\Http\Controllers;

use App\Models\Permohonan;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Services\WhatsAppService;

class PermohonanController extends Controller
{
    // 1. Menampilkan Tabel Permohonan Admin (dengan Paginasi, Filter & Pencarian)
    public function index(Request $request)
    {
        $query = Permohonan::query();

        // Pencarian teks
        if ($request->filled('q')) {
            $keyword = trim($request->q);
            $query->where(function ($q) use ($keyword) {
                $q->where('nomor_registrasi', 'like', "%{$keyword}%")
                  ->orWhere('nama_lengkap', 'like', "%{$keyword}%")
                  ->orWhere('nik_identitas', 'like', "%{$keyword}%")
                  ->orWhere('email', 'like', "%{$keyword}%")
                  ->orWhere('rincian_informasi', 'like', "%{$keyword}%");
            });
        }

        // Filter Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter Tipe Permohonan (Online / Offline)
        if ($request->filled('tipe')) {
            $query->where('tipe_permohonan', $request->tipe);
        }

        // Filter Kategori (Perorangan / Lembaga)
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        // Urutkan terbaru
        $permohonans = $query->latest()->paginate(20)->withQueryString();

        return view('pages.admin.permohonan', compact('permohonans'));
    }

    // Form Tambah Permohonan Manual / Offline oleh Petugas
    public function createOffline()
    {
        return view('pages.admin.permohonan_offline');
    }

    // Simpan Permohonan Offline
    public function storeOffline(Request $request)
    {
        $validated = $request->validate([
            'kategori' => 'required|in:perorangan,lembaga',
            'nik_identitas' => 'required|string|max:50',
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'nomor_telepon' => 'required|string|max:30',
            'is_disabilitas' => 'nullable',
            'ragam_disabilitas' => 'nullable|string|max:100',
            'format_jawaban_khusus' => 'nullable|string|max:100',
            'kebutuhan_khusus' => 'nullable|string|max:1000',
            'rincian_informasi' => 'required|string',
            'tujuan_penggunaan' => 'required|string',
            'file_pendukung' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $validated['nomor_registrasi'] = Permohonan::generateNomorRegistrasi();
        $validated['tipe_permohonan'] = 'offline';
        $validated['petugas_pencatat'] = auth()->user()->name ?? 'Petugas Meja Layanan';
        $validated['is_disabilitas'] = $request->boolean('is_disabilitas');
        if (!$validated['is_disabilitas']) {
            $validated['ragam_disabilitas'] = null;
            $validated['format_jawaban_khusus'] = null;
            $validated['kebutuhan_khusus'] = null;
        }

        if ($request->hasFile('file_pendukung')) {
            $validated['file_pendukung'] = $request->file('file_pendukung')->store('dokumen_permohonan', 'local');
        }

        $permohonan = Permohonan::create($validated);

        // Audit Log
        AuditLog::record(
            'CREATE_OFFLINE',
            'permohonan',
            "Mencatat permohonan offline di meja layanan untuk {$permohonan->nama_lengkap} (No. Reg: {$permohonan->nomor_registrasi})",
            $permohonan->nomor_registrasi
        );

        // Kirim email konfirmasi ke pemohon
        try {
            Mail::to($permohonan->email)->send(new \App\Mail\PermohonanDiajukanMail($permohonan));
        } catch (\Throwable $e) {
            Log::error('Gagal kirim email permohonan offline: ' . $e->getMessage());
        }

        // Kirim notifikasi WhatsApp ke pemohon
        WhatsAppService::notifyPermohonanBaru($permohonan);

        return redirect()->route('admin.permohonan.index')
            ->with('success', "Permohonan offline berhasil dicatat dengan Nomor Registrasi: {$permohonan->nomor_registrasi}");
    }

    // Perpanjangan Waktu Pelayanan SLA (7 Hari Kerja) sesuai Pasal 22 ayat (8) UU KIP
    public function perpanjangSla(Request $request, $id)
    {
        $request->validate([
            'alasan_perpanjangan' => 'required|string|min:10',
        ], [
            'alasan_perpanjangan.required' => 'Alasan perpanjangan waktu wajib diisi sesuai regulasi UU KIP.',
            'alasan_perpanjangan.min' => 'Alasan perpanjangan waktu minimal 10 karakter.',
        ]);

        $permohonan = Permohonan::findOrFail($id);

        if ($permohonan->perpanjangan_sla) {
            return back()->with('error', 'Permohonan ini sudah pernah diperpanjang batas waktu SLA-nya sebelumnya.');
        }

        $permohonan->update([
            'perpanjangan_sla' => true,
            'alasan_perpanjangan' => $request->alasan_perpanjangan,
            'tanggal_perpanjangan' => now(),
        ]);

        // Catat Audit Log
        AuditLog::record(
            'SLA_EXTENSION',
            'permohonan',
            "Memperpanjang batas waktu SLA permohonan {$permohonan->nomor_registrasi} sebanyak 7 hari kerja. Alasan: {$request->alasan_perpanjangan}",
            $permohonan->nomor_registrasi
        );

        // Kirim email pemberitahuan ke pemohon
        try {
            Mail::to($permohonan->email)->send(new \App\Mail\SlaDiperpanjangMail($permohonan));
        } catch (\Throwable $e) {
            Log::error('Gagal kirim email perpanjangan SLA: ' . $e->getMessage());
        }

        return back()->with('success', "Batas waktu SLA permohonan [{$permohonan->nomor_registrasi}] berhasil diperpanjang 7 hari kerja dan surat pemberitahuan telah dikirimkan ke email pemohon.");
    }

    // Ekspor Data Permohonan ke CSV (Dapat langsung dibuka di Excel)
    public function export(Request $request)
    {
        $query = Permohonan::query();

        if ($request->filled('q')) {
            $keyword = trim($request->q);
            $query->where(function ($q) use ($keyword) {
                $q->where('nomor_registrasi', 'like', "%{$keyword}%")
                  ->orWhere('nama_lengkap', 'like', "%{$keyword}%")
                  ->orWhere('nik_identitas', 'like', "%{$keyword}%")
                  ->orWhere('email', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('tipe')) {
            $query->where('tipe_permohonan', $request->tipe);
        }

        $items = $query->latest()->get();

        $filename = "rekap_permohonan_ppid_" . date('Ymd_His') . ".csv";

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($items) {
            $file = fopen('php://output', 'w');
            // Menulis BOM UTF-8 untuk kompatibilitas Microsoft Excel
            fputs($file, "\xEF\xBB\xBF");

            // Header kolom CSV
            fputcsv($file, [
                'No.',
                'Nomor Registrasi',
                'Tipe Layanan',
                'Penyandang Disabilitas',
                'Ragam Disabilitas',
                'Format Khusus',
                'Tanggal Masuk',
                'Nama Pemohon',
                'Kategori',
                'NIK / Identitas',
                'Email',
                'No. Telepon',
                'Rincian Informasi',
                'Tujuan Penggunaan',
                'Status',
                'SLA Info',
                'Perpanjangan SLA',
                'Alasan Penolakan / Catatan Admin',
                'Tanggal Selesai'
            ], ';');

            $no = 1;
            foreach ($items as $item) {
                $sla = $item->sla_info;
                fputcsv($file, [
                    $no++,
                    $item->nomor_registrasi,
                    strtoupper($item->tipe_permohonan ?? 'online'),
                    $item->is_disabilitas ? 'YA' : 'TIDAK',
                    $item->ragam_disabilitas ?: '-',
                    $item->format_jawaban_khusus ?: '-',
                    $item->created_at ? $item->created_at->format('Y-m-d H:i') : '-',
                    $item->nama_lengkap,
                    ucfirst($item->kategori),
                    "'" . $item->nik_identitas, // Prefiks kutip agar tidak terpotong ilmiah di Excel
                    $item->email,
                    "'" . $item->nomor_telepon,
                    $item->rincian_informasi,
                    $item->tujuan_penggunaan,
                    strtoupper($item->status),
                    $sla['label'] ?? '-',
                    $item->perpanjangan_sla ? 'Ya (7 Hari Kerja Tambahan)' : 'Tidak',
                    $item->alasan_penolakan ?: ($item->catatan_admin ?: '-'),
                    $item->tanggal_respon ? $item->tanggal_respon->format('Y-m-d H:i') : '-'
                ], ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // Mengunduh / melihat berkas identitas pemohon secara aman (hanya untuk admin)
    public function downloadBerkas($id)
    {
        $permohonan = Permohonan::findOrFail($id);

        if (!$permohonan->file_pendukung) {
            return back()->with('error', 'Berkas pendukung tidak ditemukan.');
        }

        if (Storage::disk('local')->exists($permohonan->file_pendukung)) {
            return Storage::disk('local')->response($permohonan->file_pendukung);
        }

        if (Storage::disk('public')->exists($permohonan->file_pendukung)) {
            return Storage::disk('public')->response($permohonan->file_pendukung);
        }

        return back()->with('error', 'File berkas tidak ditemukan di server.');
    }

    // Mengunduh berkas jawaban permohonan secara aman (hanya jika terverifikasi session NIK pemohon atau admin)
    public function downloadJawaban(Request $request, $id)
    {
        $permohonan = Permohonan::findOrFail($id);

        if (!$permohonan->file_jawaban) {
            return back()->with('error', 'Berkas jawaban belum tersedia.');
        }

        if (auth()->check()) {
            return $this->serveJawabanFile($permohonan);
        }

        $verifiedId = session('lacak_verified_permohonan_id');

        if ($verifiedId && (int)$verifiedId === (int)$permohonan->id) {
            return $this->serveJawabanFile($permohonan);
        }

        return abort(403, 'Akses ditolak: Verifikasi Nomor Registrasi dan NIK diperlukan untuk mengunduh dokumen jawaban ini.');
    }

    protected function serveJawabanFile(Permohonan $permohonan)
    {
        if (Storage::disk('local')->exists($permohonan->file_jawaban)) {
            return Storage::disk('local')->download($permohonan->file_jawaban);
        }

        if (Storage::disk('public')->exists($permohonan->file_jawaban)) {
            return Storage::disk('public')->download($permohonan->file_jawaban);
        }

        return back()->with('error', 'File fisik jawaban tidak ditemukan di server.');
    }

    // Memperbarui status permohonan dari halaman Admin
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:menunggu,diproses,selesai,ditolak',
            'catatan_admin' => 'nullable|string',
            'alasan_penolakan' => 'nullable|string',
            'file_jawaban' => 'nullable|file|mimes:pdf,zip,rar,doc,docx,xls,xlsx|max:20480',
        ]);

        $permohonan = Permohonan::findOrFail($id);

        $updateData = [
            'status' => $request->status,
            'catatan_admin' => $request->catatan_admin,
            'alasan_penolakan' => $request->status === 'ditolak' ? $request->alasan_penolakan : null,
        ];

        if ($request->hasFile('file_jawaban')) {
            if ($permohonan->file_jawaban && Storage::disk('local')->exists($permohonan->file_jawaban)) {
                Storage::disk('local')->delete($permohonan->file_jawaban);
            } elseif ($permohonan->file_jawaban && Storage::disk('public')->exists($permohonan->file_jawaban)) {
                Storage::disk('public')->delete($permohonan->file_jawaban);
            }
            $updateData['file_jawaban'] = $request->file('file_jawaban')->store('jawaban_permohonan', 'local');
        }

        if (in_array($request->status, ['selesai', 'ditolak']) && !$permohonan->tanggal_respon) {
            $updateData['tanggal_respon'] = now();
        }

        $permohonan->update($updateData);

        // Catat Audit Log
        AuditLog::record(
            'STATUS_CHANGE',
            'permohonan',
            "Mengubah status permohonan {$permohonan->nomor_registrasi} menjadi " . strtoupper($request->status) . ($request->filled('catatan_admin') ? ": {$request->catatan_admin}" : ''),
            $permohonan->nomor_registrasi
        );

        // Kirim email notifikasi ke pemohon
        try {
            Mail::to($permohonan->email)->send(new \App\Mail\StatusPermohonanUpdatedMail($permohonan));
        } catch (\Throwable $e) {
            Log::error('Gagal mengirim email status permohonan: ' . $e->getMessage());
        }

        // Kirim notifikasi WhatsApp ke pemohon
        WhatsAppService::notifyStatusUpdated($permohonan);

        return redirect()->back()->with('success', 'Status permohonan [' . ($permohonan->nomor_registrasi ?? $permohonan->id) . '] berhasil diperbarui menjadi ' . ucfirst($permohonan->status) . '!');
    }

    public function create()
    {
        return view('pages.permohonan');
    }

    public function lacak(Request $request)
    {
        if ($request->has('reset')) {
            session()->forget('lacak_verified_permohonan_id');
            return redirect()->route('permohonan.lacak');
        }

        $permohonan = null;
        $verifiedId = session('lacak_verified_permohonan_id');

        if ($verifiedId) {
            $permohonan = Permohonan::with('keberatans')->find($verifiedId);
        }

        $nomor = $request->get('nomor', old('nomor', ''));
        $authError = session('authError');

        return view('pages.lacak_permohonan', compact('permohonan', 'authError', 'nomor'));
    }

    public function lacakPost(Request $request)
    {
        $request->validate([
            'nomor' => 'required|string',
            'nik' => 'required|string',
        ], [
            'nomor.required' => 'Nomor Registrasi wajib diisi.',
            'nik.required' => 'NIK Pemohon wajib diisi.',
        ]);

        $nomor = trim($request->input('nomor'));
        $nik = trim($request->input('nik'));

        $permohonan = Permohonan::where('nomor_registrasi', $nomor)
            ->where('nik_identitas', $nik)
            ->first();

        if (!$permohonan) {
            return redirect()->route('permohonan.lacak', ['nomor' => $nomor])
                ->withInput(['nomor' => $nomor])
                ->with('authError', 'Kombinasi Nomor Registrasi dan NIK tidak cocok dengan data kami. Pastikan nomor registrasi dan NIK yang Anda masukkan sudah sesuai saat pengajuan.');
        }

        session(['lacak_verified_permohonan_id' => $permohonan->id]);

        return redirect()->route('permohonan.lacak');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'kategori' => 'required|in:perorangan,lembaga',
            'nik_identitas' => 'required|string|max:50',
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'nomor_telepon' => 'required|string|max:30',
            'is_disabilitas' => 'nullable',
            'ragam_disabilitas' => 'nullable|string|max:100',
            'format_jawaban_khusus' => 'nullable|string|max:100',
            'kebutuhan_khusus' => 'nullable|string|max:1000',
            'rincian_informasi' => 'required|string',
            'tujuan_penggunaan' => 'required|string',
            'file_pendukung' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $validatedData['nomor_registrasi'] = Permohonan::generateNomorRegistrasi();
        $validatedData['tipe_permohonan'] = 'online';
        $validatedData['is_disabilitas'] = $request->boolean('is_disabilitas');
        if (!$validatedData['is_disabilitas']) {
            $validatedData['ragam_disabilitas'] = null;
            $validatedData['format_jawaban_khusus'] = null;
            $validatedData['kebutuhan_khusus'] = null;
        }

        if ($request->hasFile('file_pendukung')) {
            $path = $request->file('file_pendukung')->store('dokumen_permohonan', 'local');
            $validatedData['file_pendukung'] = $path;
        }

        $permohonan = Permohonan::create($validatedData);

        try {
            Mail::to($permohonan->email)->send(new \App\Mail\PermohonanDiajukanMail($permohonan));

            $adminEmail = config('services.ppid.admin_email', 'disporajatim2024@gmail.com');
            if ($adminEmail) {
                Mail::to($adminEmail)->send(new \App\Mail\NotifikasiPermohonanBaruAdminMail($permohonan));
            }
        } catch (\Throwable $e) {
            Log::error('Gagal mengirim email permohonan: ' . $e->getMessage());
        }

        // Kirim notifikasi WhatsApp ke pemohon
        WhatsAppService::notifyPermohonanBaru($permohonan);

        session(['lacak_verified_permohonan_id' => $permohonan->id]);

        return redirect()->back()
            ->with('success', 'Permohonan Informasi berhasil dikirim dengan Nomor Registrasi: ' . $permohonan->nomor_registrasi)
            ->with('nomor_registrasi', $permohonan->nomor_registrasi);
    }
}
