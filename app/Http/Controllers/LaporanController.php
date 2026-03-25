<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LaporanController extends Controller
{
    // 1. Menampilkan Tabel Daftar Laporan
    public function index()
    {
        // Menampilkan semua laporan, diurutkan dari yang terbaru
        $laporans = Laporan::orderBy('tahun', 'desc')->latest()->get();
        return view('pages.admin.laporan.index', compact('laporans'));
    }

    // 2. Menampilkan Form Tambah Laporan
    public function create()
    {
        return view('pages.admin.laporan.create');
    }

    // 3. Memproses dan Menyimpan Data
    public function store(Request $request)
    {
        $request->validate([
            'kategori' => 'required|in:akses,pelayanan',
            'tahun' => 'required|string|max:4',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'file_pdf' => 'required|file|mimes:pdf|max:10240', // Maksimal 10MB, khusus PDF
        ]);

        $data = $request->all();

        // Logika Upload File PDF
        if ($request->hasFile('file_pdf')) {
            $data['file_pdf'] = $request->file('file_pdf')->store('laporan_ppid', 'public');
        }

        Laporan::create($data);

        return redirect()->route('admin.laporan.index')->with('success', 'File Laporan berhasil diunggah dan dipublikasikan!');
    }

    // 4. Menghapus Laporan
    public function destroy($id)
    {
        $laporan = Laporan::findOrFail($id);

        // Hapus file fisik PDF dari storage server
        if ($laporan->file_pdf && Storage::disk('public')->exists($laporan->file_pdf)) {
            Storage::disk('public')->delete($laporan->file_pdf);
        }

        $laporan->delete();

        return redirect()->route('admin.laporan.index')->with('success', 'Data Laporan beserta file PDF berhasil dihapus!');
    }
}
