<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProfilSetting;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfilSettingController extends Controller
{
    // Menampilkan halaman kelola konten profil di admin
    public function index()
    {
        $settings = ProfilSetting::all()->keyBy('key');
        return view('pages.admin.profil_setting.index', compact('settings'));
    }

    // Memperbarui konten profil tertentu
    public function update(Request $request, $key)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $setting = ProfilSetting::firstOrNew(['key' => $key]);
        $setting->judul = $request->judul;
        $setting->konten = $request->konten;

        if ($request->hasFile('gambar')) {
            if ($setting->gambar && Storage::disk('public')->exists($setting->gambar)) {
                Storage::disk('public')->delete($setting->gambar);
            }
            $setting->gambar = $request->file('gambar')->store('profil_cms', 'public');
        }

        $setting->save();

        AuditLog::record(
            'UPDATE_CMS',
            'profil',
            "Memperbarui konten halaman profil: {$setting->judul} ({$key})",
            (string) $setting->id
        );

        return back()->with('success', "Konten [{$setting->judul}] berhasil diperbarui.");
    }
}
