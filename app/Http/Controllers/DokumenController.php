<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DokumenController extends Controller
{
    // 1. Menampilkan Tabel Daftar Dokumen
    public function index()
    {
        // Mengambil semua dokumen diurutkan dari yang terbaru
        $dokumens = Dokumen::latest()->get();
        return view('pages.admin.dokumen.index', compact('dokumens'));
    }

    // 2. Menampilkan Form Upload Dokumen Baru
    public function create()
    {
        return view('pages.admin.dokumen.create');
    }

    // 3. Memproses dan Menyimpan Dokumen
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'keterangan' => 'nullable|string|max:255',
            'kategori' => 'required|in:regulasi,sop,sk',
            'tahun' => 'required|string|max:4',
            'file_pdf' => 'required|file|mimes:pdf|max:10240', // Wajib PDF, Maksimal 10MB
        ]);

        $data = $request->all();

        // Logika Upload File PDF
        if ($request->hasFile('file_pdf')) {
            $data['file_pdf'] = $request->file('file_pdf')->store('dokumen_pdf', 'public');
        }

        Dokumen::create($data);

        return redirect()->route('admin.dokumen.index')->with('success', 'Dokumen PDF berhasil diunggah dan dipublikasikan!');
    }

    // 4. Menghapus Dokumen
    public function destroy($id)
    {
        $dokumen = Dokumen::findOrFail($id);

        // Menghapus file fisik dari folder storage agar tidak menumpuk
        if ($dokumen->file_pdf && Storage::disk('public')->exists($dokumen->file_pdf)) {
            Storage::disk('public')->delete($dokumen->file_pdf);
        }

        $dokumen->delete();

        return redirect()->route('admin.dokumen.index')->with('success', 'Dokumen berhasil dihapus dari sistem!');
    }
}
