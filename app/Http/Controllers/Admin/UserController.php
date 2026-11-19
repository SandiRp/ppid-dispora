<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(15);
        return view('pages.admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('pages.admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'role' => 'required|in:superadmin,operator',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $user = User::create($validated);

        AuditLog::record('CREATE', 'user', "Menambahkan akun pengguna baru: {$user->name} ({$user->email}) dengan peran {$user->role}", (string) $user->id);

        return redirect()->route('admin.users.index')->with('success', 'Akun petugas baru berhasil dibuat!');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('pages.admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:superadmin,operator',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        AuditLog::record('UPDATE', 'user', "Memperbarui profil pengguna: {$user->name} ({$user->email})", (string) $user->id);

        return redirect()->route('admin.users.index')->with('success', 'Data akun berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri yang sedang aktif.');
        }

        $nama = $user->name;
        $user->delete();

        AuditLog::record('DELETE', 'user', "Menghapus akun pengguna: {$nama}", (string) $id);

        return redirect()->route('admin.users.index')->with('success', 'Akun pengguna berhasil dihapus!');
    }
}
