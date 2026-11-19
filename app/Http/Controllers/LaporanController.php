<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LaporanController extends Controller
{
    // 1. Menampilkan Tabel Daftar Laporan (dengan Paginasi & Filter)
    public function index(Request $request)
    {
        $query = Laporan::query();

        if ($request->filled('q')) {
            $keyword = trim($request->q);
            $query->where(function($q) use ($keyword) {
                $q->where('judul', 'like', "%{$keyword}%")
                  ->orWhere('tahun', 'like', "%{$keyword}%")
                  ->orWhere('deskripsi', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $laporans = $query->orderBy('tahun', 'desc')->latest()->paginate(15)->withQueryString();

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
        $validated = $request->validate([
            'kategori' => 'required|in:akses,pelayanan',
            'tahun' => 'required|digits:4',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'file_pdf' => 'required|file|mimes:pdf|max:10240', // Maksimal 10MB, khusus PDF
        ]);

        if ($request->hasFile('file_pdf')) {
            $validated['file_pdf'] = $request->file('file_pdf')->store('laporan_ppid', 'public');
        }

        $laporan = Laporan::create($validated);

        // Catat Audit Log
        AuditLog::record(
            'CREATE',
            'laporan',
            "Mengunggah laporan [{$laporan->kategori}]: {$laporan->judul} ({$laporan->tahun})",
            $laporan->id
        );

        return redirect()->route('admin.laporan.index')->with('success', 'File Laporan berhasil diunggah dan dipublikasikan!');
    }

    // Menampilkan Form Edit Laporan
    public function edit($id)
    {
        $laporan = Laporan::findOrFail($id);
        return view('pages.admin.laporan.edit', compact('laporan'));
    }

    // Memperbarui Data Laporan
    public function update(Request $request, $id)
    {
        $laporan = Laporan::findOrFail($id);

        $validated = $request->validate([
            'kategori' => 'required|in:akses,pelayanan',
            'tahun' => 'required|digits:4',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'file_pdf' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        if ($request->hasFile('file_pdf')) {
            if ($laporan->file_pdf && Storage::disk('public')->exists($laporan->file_pdf)) {
                Storage::disk('public')->delete($laporan->file_pdf);
            }
            $validated['file_pdf'] = $request->file('file_pdf')->store('laporan_ppid', 'public');
        }

        $laporan->update($validated);

        // Catat Audit Log
        AuditLog::record(
            'UPDATE',
            'laporan',
            "Memperbarui laporan [{$laporan->kategori}]: {$laporan->judul} ({$laporan->tahun})",
            $laporan->id
        );

        return redirect()->route('admin.laporan.index')->with('success', 'Data Laporan berhasil diperbarui!');
    }

    // 4. Menghapus Laporan
    public function destroy($id)
    {
        $laporan = Laporan::findOrFail($id);
        $judul = $laporan->judul;

        if ($laporan->file_pdf && Storage::disk('public')->exists($laporan->file_pdf)) {
            Storage::disk('public')->delete($laporan->file_pdf);
        }

        $laporan->delete();

        // Catat Audit Log
        AuditLog::record(
            'DELETE',
            'laporan',
            "Menghapus berkas laporan: {$judul}",
            $id
        );

        return redirect()->route('admin.laporan.index')->with('success', 'Data Laporan beserta file PDF berhasil dihapus!');
    }
}
