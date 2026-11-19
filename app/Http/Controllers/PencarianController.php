<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\Dokumen;
use App\Models\Informasi;
use App\Models\Laporan;
use Illuminate\Http\Request;

class PencarianController extends Controller
{
    public function search(Request $request)
    {
        $q = trim($request->get('q', ''));

        $beritas = collect();
        $dokumens = collect();
        $informasis = collect();
        $laporans = collect();

        if ($q) {
            $beritas = Berita::where('status', 'published')
                ->where(function ($query) use ($q) {
                    $query->where('judul', 'like', "%{$q}%")
                        ->orWhere('konten', 'like', "%{$q}%");
                })
                ->latest('tanggal_publish')
                ->take(10)
                ->get();

            $dokumens = Dokumen::where('judul', 'like', "%{$q}%")
                ->orWhere('keterangan', 'like', "%{$q}%")
                ->latest()
                ->take(10)
                ->get();

            $informasis = Informasi::where('ringkasan_informasi', 'like', "%{$q}%")
                ->orWhere('deskripsi', 'like', "%{$q}%")
                ->latest()
                ->take(10)
                ->get();

            $laporans = Laporan::where('judul', 'like', "%{$q}%")
                ->orWhere('deskripsi', 'like', "%{$q}%")
                ->latest()
                ->take(10)
                ->get();
        }

        $totalHasil = $beritas->count() + $dokumens->count() + $informasis->count() + $laporans->count();

        return view('pages.pencarian', compact('q', 'beritas', 'dokumens', 'informasis', 'laporans', 'totalHasil'));
    }
}
