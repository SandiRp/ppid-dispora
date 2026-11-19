@extends('layouts.admin')

@section('title', 'Edit Pengguna - Admin PPID')

@section('content')
    <div class="max-w-2xl mx-auto space-y-6">

        <div class="flex items-center gap-4 pb-6 border-b border-gray-200">
            <a href="{{ route('admin.users.index') }}"
                class="p-2 bg-gray-100 text-gray-600 hover:bg-gray-200 rounded-lg transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Edit Pengguna</h1>
                <p class="text-gray-500">Perbarui informasi profil atau peran akun petugas.</p>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <div class="space-y-1.5">
                    <label class="block text-sm font-semibold text-gray-700">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="name" required value="{{ old('name', $user->name) }}"
                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-tosca-500 outline-none text-sm">
                    @error('name') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="space-y-1.5">
                    <label class="block text-sm font-semibold text-gray-700">Alamat Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" required value="{{ old('email', $user->email) }}"
                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-tosca-500 outline-none text-sm">
                    @error('email') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="space-y-1.5">
                    <label class="block text-sm font-semibold text-gray-700">Peran Akses (Role) <span class="text-red-500">*</span></label>
                    <select name="role" required
                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-tosca-500 outline-none text-sm">
                        <option value="operator" {{ old('role', $user->role) == 'operator' ? 'selected' : '' }}>Operator (Kelola Konten & Permohonan)</option>
                        <option value="superadmin" {{ old('role', $user->role) == 'superadmin' ? 'selected' : '' }}>Super Admin (Akses Penuh)</option>
                    </select>
                </div>

                <div class="p-4 bg-gray-50 border border-gray-200 rounded-2xl space-y-4">
                    <p class="text-xs text-gray-500 font-semibold">Ganti Password (Biarkan kosong jika tidak ingin mengubah password)</p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label class="block text-xs font-semibold text-gray-700">Password Baru</label>
                            <input type="password" name="password" placeholder="Minimal 6 karakter"
                                class="w-full px-4 py-2 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-tosca-500 outline-none text-sm">
                            @error('password') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                        </div>

                        <div class="space-y-1.5">
                            <label class="block text-xs font-semibold text-gray-700">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" placeholder="Ulangi password baru"
                                class="w-full px-4 py-2 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-tosca-500 outline-none text-sm">
                        </div>
                    </div>
                </div>

                <div class="pt-4 flex justify-end">
                    <button type="submit"
                        class="px-8 py-3 bg-tosca-600 hover:bg-tosca-700 text-white font-bold rounded-xl shadow-lg shadow-tosca-500/30 transition-all">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
