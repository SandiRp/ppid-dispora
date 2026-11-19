<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
    // 1. Menampilkan Tabel Daftar Agenda (dengan Paginasi & Pencarian)
    public function index(Request $request)
    {
        $query = Agenda::query();

        if ($request->filled('q')) {
            $keyword = trim($request->q);
            $query->where(function($q) use ($keyword) {
                $q->where('judul', 'like', "%{$keyword}%")
                  ->orWhere('lokasi', 'like', "%{$keyword}%")
                  ->orWhere('deskripsi', 'like', "%{$keyword}%");
            });
        }

        $agendas = $query->orderBy('tanggal', 'desc')->orderBy('waktu_mulai', 'desc')->paginate(15)->withQueryString();

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
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'waktu_mulai' => 'nullable',
            'waktu_selesai' => 'nullable',
            'lokasi' => 'nullable|string|max:255',
            'deskripsi' => 'required|string',
        ]);

        $agenda = Agenda::create($validated);

        // Catat Audit Log
        AuditLog::record(
            'CREATE',
            'agenda',
            "Menambahkan jadwal agenda PPID: {$agenda->judul} pada tanggal {$agenda->tanggal}",
            $agenda->id
        );

        return redirect()->route('admin.agenda.index')->with('success', 'Agenda kegiatan PPID berhasil dijadwalkan!');
    }

    // Menampilkan Form Edit Agenda
    public function edit($id)
    {
        $agenda = Agenda::findOrFail($id);
        return view('pages.admin.agenda.edit', compact('agenda'));
    }

    // Memperbarui Data Agenda
    public function update(Request $request, $id)
    {
        $agenda = Agenda::findOrFail($id);

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'waktu_mulai' => 'nullable',
            'waktu_selesai' => 'nullable',
            'lokasi' => 'nullable|string|max:255',
            'deskripsi' => 'required|string',
        ]);

        $agenda->update($validated);

        // Catat Audit Log
        AuditLog::record(
            'UPDATE',
            'agenda',
            "Memperbarui agenda PPID: {$agenda->judul} ({$agenda->tanggal})",
            $agenda->id
        );

        return redirect()->route('admin.agenda.index')->with('success', 'Agenda kegiatan berhasil diperbarui!');
    }

    // 4. Menghapus Agenda
    public function destroy($id)
    {
        $agenda = Agenda::findOrFail($id);
        $judul = $agenda->judul;
        $agenda->delete();

        // Catat Audit Log
        AuditLog::record(
            'DELETE',
            'agenda',
            "Menghapus agenda PPID: {$judul}",
            $id
        );

        return redirect()->route('admin.agenda.index')->with('success', 'Agenda kegiatan berhasil dihapus!');
    }
}
