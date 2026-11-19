<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Str; // Untuk membuat Slug otomatis
use Illuminate\Support\Facades\Storage;

class BeritaController extends Controller
{
    // 1. Menampilkan Tabel Daftar Berita (dengan Paginasi & Pencarian)
    public function index(Request $request)
    {
        $query = Berita::query();

        if ($request->filled('q')) {
            $keyword = trim($request->q);
            $query->where(function($q) use ($keyword) {
                $q->where('judul', 'like', "%{$keyword}%")
                  ->orWhere('kategori', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $beritas = $query->latest('tanggal_publish')->paginate(15)->withQueryString();
        return view('pages.admin.berita.index', compact('beritas'));
    }

    // 2. Menampilkan Form Tulis Berita Baru
    public function create()
    {
        return view('pages.admin.berita.create');
    }

    // 3. Memproses dan Menyimpan Berita ke Database
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string',
            'status' => 'required|in:draft,published',
            'konten' => 'required',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Maksimal 2MB
        ]);

        $validated['konten'] = \Mews\Purifier\Facades\Purifier::clean($request->input('konten'));
        $validated['slug'] = Str::slug($request->judul) . '-' . time(); // Membuat URL unik

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('gambar_berita', 'public');
        }

        $berita = Berita::create($validated);

        \App\Models\AuditLog::record('CREATE', 'berita', "Membuat berita baru [{$berita->status}]: {$berita->judul}", (string) $berita->id);

        $msg = $berita->status === 'published' ? 'Berita berhasil dipublikasikan!' : 'Draft berita berhasil disimpan!';
        return redirect()->route('admin.berita.index')->with('success', $msg);
    }

    // Menampilkan Form Edit Berita
    public function edit($id)
    {
        $berita = Berita::findOrFail($id);
        return view('pages.admin.berita.edit', compact('berita'));
    }

    // Memperbarui Data Berita
    public function update(Request $request, $id)
    {
        $berita = Berita::findOrFail($id);

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string',
            'status' => 'required|in:draft,published',
            'konten' => 'required',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $validated['konten'] = \Mews\Purifier\Facades\Purifier::clean($request->input('konten'));

        if ($request->hasFile('gambar')) {
            if ($berita->gambar && Storage::disk('public')->exists($berita->gambar)) {
                Storage::disk('public')->delete($berita->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('gambar_berita', 'public');
        }

        $berita->update($validated);

        \App\Models\AuditLog::record('UPDATE', 'berita', "Memperbarui berita [{$berita->status}]: {$berita->judul}", (string) $berita->id);

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil diperbarui!');
    }

    // 4. Menghapus Berita
    public function destroy($id)
    {
        $berita = Berita::findOrFail($id);
        $judul = $berita->judul;

        // Hapus file gambar dari server disk public
        if ($berita->gambar && Storage::disk('public')->exists($berita->gambar)) {
            Storage::disk('public')->delete($berita->gambar);
        }

        $berita->delete();

        \App\Models\AuditLog::record('DELETE', 'berita', "Menghapus berita: {$judul}", (string) $id);

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil dihapus!');
    }
}
