<?php

namespace App\Http\Controllers;

use App\Models\Permohonan;
use Illuminate\Http\Request;

class PermohonanController extends Controller
{
    public function index()
    {
        // Mengambil semua data permohonan, diurutkan dari yang paling baru masuk (latest)
        $permohonans = Permohonan::latest()->get();

        return view('pages.admin.permohonan', compact('permohonans'));
    }
    // Memperbarui status permohonan dari halaman Admin
    public function updateStatus(Request $request, $id)
    {
        // Validasi input agar hanya menerima 4 status ini
        $request->validate([
            'status' => 'required|in:menunggu,diproses,selesai,ditolak'
        ]);

        // Cari data permohonan berdasarkan ID, lalu update statusnya
        $permohonan = Permohonan::findOrFail($id);
        $permohonan->update([
            'status' => $request->status
        ]);

        // Kembalikan ke halaman sebelumnya dengan pesan sukses
        return redirect()->back()->with('success', 'Status permohonan atas nama ' . $permohonan->nama_lengkap . ' berhasil diperbarui!');
    }

    // Menampilkan halaman formulir
    public function create()
    {
        return view('pages.permohonan');
    }

    // Memproses dan menyimpan data ke database
    public function store(Request $request)
    {
        // 1. Validasi data
        $validatedData = $request->validate([
            'kategori' => 'required|in:perorangan,lembaga',
            'nik_identitas' => 'required|string|max:50',
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'rincian_informasi' => 'required|string',
            'tujuan_penggunaan' => 'required|string',
            'file_pendukung' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120', // Wajib diisi, maks 5MB
        ]);

        // 2. Logika Upload File
        if ($request->hasFile('file_pendukung')) {
            // Simpan file ke folder storage/app/public/dokumen_permohonan
            $path = $request->file('file_pendukung')->store('dokumen_permohonan', 'public');
            $validatedData['file_pendukung'] = $path;
        }

        // 3. Simpan ke database
        Permohonan::create($validatedData);

        // 4. Kembali dengan pesan sukses
        return redirect()->back()->with('success', 'Permohonan Informasi berhasil dikirim!');
    }
}
