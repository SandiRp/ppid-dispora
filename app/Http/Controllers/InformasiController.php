<?php

namespace App\Http\Controllers;

use App\Models\Informasi;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InformasiController extends Controller
{
    // 1. Menampilkan Tabel Daftar Informasi (dengan Paginasi & Filter)
    public function index(Request $request)
    {
        $query = Informasi::query();

        if ($request->filled('q')) {
            $keyword = trim($request->q);
            $query->where(function($q) use ($keyword) {
                $q->where('ringkasan_informasi', 'like', "%{$keyword}%")
                  ->orWhere('penanggung_jawab', 'like', "%{$keyword}%")
                  ->orWhere('tahun', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $informasis = $query->latest()->paginate(15)->withQueryString();

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
        $validated = $request->validate([
            'ringkasan_informasi' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'penanggung_jawab' => 'required|string|max:255',
            'tahun' => 'required|digits:4',
            'kategori' => 'required|in:berkala,serta_merta,setiap_saat,dikecualikan',
            'format' => 'required|string|max:10',
            'file_dokumen' => 'nullable|file|mimes:pdf,xls,xlsx,doc,docx|max:10240', // Maks 10MB
        ]);

        // Upload File jika ada (Untuk Dikecualikan biasanya kosong)
        if ($request->hasFile('file_dokumen')) {
            $validated['file_dokumen'] = $request->file('file_dokumen')->store('informasi_publik', 'public');
        }

        $informasi = Informasi::create($validated);

        // Catat Audit Log
        AuditLog::record(
            'CREATE',
            'informasi',
            "Menambahkan informasi publik [{$informasi->kategori}]: {$informasi->ringkasan_informasi} ({$informasi->tahun})",
            $informasi->id
        );

        return redirect()->route('admin.informasi.index')->with('success', 'Data Informasi Publik berhasil ditambahkan!');
    }

    // Menampilkan Form Edit Informasi
    public function edit($id)
    {
        $informasi = Informasi::findOrFail($id);
        return view('pages.admin.informasi.edit', compact('informasi'));
    }

    // Memperbarui Data Informasi
    public function update(Request $request, $id)
    {
        $informasi = Informasi::findOrFail($id);

        $validated = $request->validate([
            'ringkasan_informasi' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'penanggung_jawab' => 'required|string|max:255',
            'tahun' => 'required|digits:4',
            'kategori' => 'required|in:berkala,serta_merta,setiap_saat,dikecualikan',
            'format' => 'required|string|max:10',
            'file_dokumen' => 'nullable|file|mimes:pdf,xls,xlsx,doc,docx|max:10240',
        ]);

        if ($request->hasFile('file_dokumen')) {
            if ($informasi->file_dokumen && Storage::disk('public')->exists($informasi->file_dokumen)) {
                Storage::disk('public')->delete($informasi->file_dokumen);
            }
            $validated['file_dokumen'] = $request->file('file_dokumen')->store('informasi_publik', 'public');
        }

        $informasi->update($validated);

        // Catat Audit Log
        AuditLog::record(
            'UPDATE',
            'informasi',
            "Memperbarui informasi publik [{$informasi->kategori}]: {$informasi->ringkasan_informasi} ({$informasi->tahun})",
            $informasi->id
        );

        return redirect()->route('admin.informasi.index')->with('success', 'Data Informasi Publik berhasil diperbarui!');
    }

    // 4. Menghapus Informasi
    public function destroy($id)
    {
        $informasi = Informasi::findOrFail($id);
        $ringkasan = $informasi->ringkasan_informasi;

        if ($informasi->file_dokumen && Storage::disk('public')->exists($informasi->file_dokumen)) {
            Storage::disk('public')->delete($informasi->file_dokumen);
        }

        $informasi->delete();

        // Catat Audit Log
        AuditLog::record(
            'DELETE',
            'informasi',
            "Menghapus informasi publik: {$ringkasan}",
            $id
        );

        return redirect()->route('admin.informasi.index')->with('success', 'Data Informasi berhasil dihapus!');
    }
}
