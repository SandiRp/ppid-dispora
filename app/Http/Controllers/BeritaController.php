<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Str; // Untuk membuat Slug otomatis

class BeritaController extends Controller
{
    // 1. Menampilkan Tabel Daftar Berita
    public function index()
    {
        $beritas = Berita::latest('tanggal_publish')->get();
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
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string',
            'konten' => 'required',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Maksimal 2MB
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->judul) . '-' . time(); // Membuat URL unik

        // Logika Upload Gambar
        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('gambar_berita', 'public');
        }

        Berita::create($data);

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil dipublikasikan!');
    }

    // 4. Menghapus Berita
    public function destroy($id)
    {
        $berita = Berita::findOrFail($id);

        // Hapus file gambar dari server (opsional, tapi disarankan)
        // if ($berita->gambar) { \Storage::disk('public')->delete($berita->gambar); }

        $berita->delete();

        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil dihapus!');
    }
}
