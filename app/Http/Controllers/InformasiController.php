<?php

namespace App\Http\Controllers;

use App\Models\Informasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InformasiController extends Controller
{
    // 1. Menampilkan Tabel Daftar Informasi
    public function index()
    {
        $informasis = Informasi::latest()->get();
        return view('pages.admin.informasi.index', compact('informasis'));
    }

    // 2. Menampilkan Form Tambah Informasi
    public function create()
    {
        return view('pages.admin.informasi.create');
    }

    // 3. Memproses dan Menyimpan Data
    public function store(Request $request)
    {
        $request->validate([
            'ringkasan_informasi' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'penanggung_jawab' => 'required|string|max:255',
            'tahun' => 'required|string|max:4',
            'kategori' => 'required|in:berkala,serta_merta,setiap_saat,dikecualikan',
            'format' => 'required|string|max:10',
            'file_dokumen' => 'nullable|file|mimes:pdf,xls,xlsx,doc,docx|max:10240', // Maks 10MB
        ]);

        $data = $request->all();

        // Upload File jika ada (Untuk Dikecualikan biasanya kosong)
        if ($request->hasFile('file_dokumen')) {
            $data['file_dokumen'] = $request->file('file_dokumen')->store('informasi_publik', 'public');
        }

        Informasi::create($data);

        return redirect()->route('admin.informasi.index')->with('success', 'Data Informasi Publik berhasil ditambahkan!');
    }

    // 4. Menghapus Informasi
    public function destroy($id)
    {
        $informasi = Informasi::findOrFail($id);

        if ($informasi->file_dokumen && Storage::disk('public')->exists($informasi->file_dokumen)) {
            Storage::disk('public')->delete($informasi->file_dokumen);
        }

        $informasi->delete();

        return redirect()->route('admin.informasi.index')->with('success', 'Data Informasi berhasil dihapus!');
    }
}
