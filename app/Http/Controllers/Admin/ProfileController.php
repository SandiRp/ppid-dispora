<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    // Menampilkan halaman profil & ganti password mandiri
    public function edit()
    {
        $user = auth()->user();
        return view('pages.admin.profile', compact('user'));
    }

    // Memperbarui data profil (nama, email)
    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->update($validated);

        AuditLog::record(
            'UPDATE_PROFILE',
            'users',
            "Petugas {$user->name} memperbarui informasi profil akun pribadinya",
            $user->id
        );

        return back()->with('success', 'Informasi profil berhasil diperbarui.');
    }

    // Memperbarui kata sandi mandiri
    public function updatePassword(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'current_password' => 'required|string',
            'password' => ['required', 'confirmed', Password::min(8)],
        ], [
            'current_password.required' => 'Kata sandi saat ini wajib diisi.',
            'password.required' => 'Kata sandi baru wajib diisi.',
            'password.min' => 'Kata sandi baru minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi baru tidak cocok.',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Kata sandi saat ini yang Anda masukkan salah.']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        AuditLog::record(
            'CHANGE_PASSWORD',
            'users',
            "Petugas {$user->name} berhasil mengubah kata sandi mandiri",
            $user->id
        );

        return back()->with('success', 'Kata sandi Anda berhasil diperbarui! Silakan gunakan kata sandi baru untuk login selanjutnya.');
    }
}
