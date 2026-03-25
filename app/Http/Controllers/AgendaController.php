<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
    // 1. Menampilkan Tabel Daftar Agenda
    public function index()
    {
        // Mengambil semua agenda, diurutkan dari jadwal terbaru/terdekat
        $agendas = Agenda::orderBy('tanggal', 'desc')->orderBy('waktu_mulai', 'desc')->get();
        return view('pages.admin.agenda.index', compact('agendas'));
    }

    // 2. Menampilkan Form Tambah Agenda
    public function create()
    {
        return view('pages.admin.agenda.create');
    }

    // 3. Memproses dan Menyimpan Data
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'waktu_mulai' => 'nullable',
            'waktu_selesai' => 'nullable',
            'lokasi' => 'nullable|string|max:255',
            'deskripsi' => 'required|string',
        ]);

        Agenda::create($request->all());

        return redirect()->route('admin.agenda.index')->with('success', 'Agenda kegiatan PPID berhasil dijadwalkan!');
    }

    // 4. Menghapus Agenda
    public function destroy($id)
    {
        $agenda = Agenda::findOrFail($id);
        $agenda->delete();

        return redirect()->route('admin.agenda.index')->with('success', 'Agenda kegiatan berhasil dihapus!');
    }
}
