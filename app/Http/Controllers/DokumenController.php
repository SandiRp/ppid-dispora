<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DokumenController extends Controller
{
    // 1. Menampilkan Tabel Daftar Dokumen (dengan Paginasi & Pencarian)
    public function index(Request $request)
    {
        $query = Dokumen::query();

        if ($request->filled('q')) {
            $keyword = trim($request->q);
            $query->where(function($q) use ($keyword) {
                $q->where('judul', 'like', "%{$keyword}%")
                  ->orWhere('keterangan', 'like', "%{$keyword}%")
                  ->orWhere('tahun', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $dokumens = $query->latest()->paginate(15)->withQueryString();
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
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'keterangan' => 'nullable|string|max:255',
            'kategori' => 'required|in:regulasi,sop,sk',
            'tahun' => 'required|digits:4',
            'file_pdf' => 'required|file|mimes:pdf|max:10240', // Wajib PDF, Maksimal 10MB
        ]);

        // Logika Upload File PDF
        if ($request->hasFile('file_pdf')) {
            $validated['file_pdf'] = $request->file('file_pdf')->store('dokumen_pdf', 'public');
        }

        $dokumen = Dokumen::create($validated);

        \App\Models\AuditLog::record('CREATE', 'dokumen', "Mengunggah dokumen PDF baru: {$dokumen->judul} ({$dokumen->kategori})", (string) $dokumen->id);

        return redirect()->route('admin.dokumen.index')->with('success', 'Dokumen PDF berhasil diunggah dan dipublikasikan!');
    }

    // Menampilkan Form Edit Dokumen
    public function edit($id)
    {
        $dokumen = Dokumen::findOrFail($id);
        return view('pages.admin.dokumen.edit', compact('dokumen'));
    }

    // Memperbarui Data Dokumen
    public function update(Request $request, $id)
    {
        $dokumen = Dokumen::findOrFail($id);

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'keterangan' => 'nullable|string|max:255',
            'kategori' => 'required|in:regulasi,sop,sk',
            'tahun' => 'required|digits:4',
            'file_pdf' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        if ($request->hasFile('file_pdf')) {
            if ($dokumen->file_pdf && Storage::disk('public')->exists($dokumen->file_pdf)) {
                Storage::disk('public')->delete($dokumen->file_pdf);
            }
            $validated['file_pdf'] = $request->file('file_pdf')->store('dokumen_pdf', 'public');
        }

        $dokumen->update($validated);

        \App\Models\AuditLog::record('UPDATE', 'dokumen', "Memperbarui dokumen PDF: {$dokumen->judul}", (string) $dokumen->id);

        return redirect()->route('admin.dokumen.index')->with('success', 'Dokumen berhasil diperbarui!');
    }

    // 4. Menghapus Dokumen
    public function destroy($id)
    {
        $dokumen = Dokumen::findOrFail($id);
        $judul = $dokumen->judul;

        // Menghapus file fisik dari folder storage agar tidak menumpuk
        if ($dokumen->file_pdf && Storage::disk('public')->exists($dokumen->file_pdf)) {
            Storage::disk('public')->delete($dokumen->file_pdf);
        }

        $dokumen->delete();

        \App\Models\AuditLog::record('DELETE', 'dokumen', "Menghapus dokumen PDF: {$judul}", (string) $id);

        return redirect()->route('admin.dokumen.index')->with('success', 'Dokumen berhasil dihapus dari sistem!');
    }
}
