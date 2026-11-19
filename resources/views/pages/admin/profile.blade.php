@extends('layouts.admin')

@section('title', 'Profil Akun & Ganti Kata Sandi - Admin PPID')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">

    <div class="pb-4 border-b border-gray-200">
        <h1 class="text-3xl font-black text-gray-900 mb-1">Pengaturan Profil & Keamanan</h1>
        <p class="text-gray-500 text-sm">Kelola data akun pribadi dan perbarui kata sandi login Anda secara berkala.</p>
    </div>

    @if (session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold rounded-2xl flex items-center gap-3">
            <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Form 1: Ubah Data Profil -->
        <div class="bg-white rounded-3xl p-6 md:p-8 border border-gray-100 shadow-sm space-y-6">
            <div class="flex items-center gap-3 pb-3 border-b border-gray-100">
                <div class="w-10 h-10 rounded-xl bg-tosca-50 text-tosca-600 flex items-center justify-center font-bold">
                    👤
                </div>
                <div>
                    <h2 class="text-base font-bold text-gray-800">Informasi Pribadi</h2>
                    <span class="text-xs text-gray-400">Peran: <strong class="text-tosca-700 uppercase">{{ $user->role ?? 'operator' }}</strong></span>
                </div>
            </div>

            <form action="{{ route('admin.profile.update') }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-gray-700 uppercase">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-tosca-500 outline-none">
                    @error('name') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-gray-700 uppercase">Alamat Email Login</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-tosca-500 outline-none">
                    @error('email') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="pt-2 flex justify-end">
                    <button type="submit" class="px-5 py-2.5 bg-tosca-600 hover:bg-tosca-700 text-white font-bold text-xs rounded-xl shadow-md transition-all">
                        Simpan Perubahan Profil
                    </button>
                </div>
            </form>
        </div>

        <!-- Form 2: Ganti Password Mandiri -->
        <div class="bg-white rounded-3xl p-6 md:p-8 border border-gray-100 shadow-sm space-y-6">
            <div class="flex items-center gap-3 pb-3 border-b border-gray-100">
                <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold">
                    🔒
                </div>
                <div>
                    <h2 class="text-base font-bold text-gray-800">Ganti Kata Sandi</h2>
                    <span class="text-xs text-gray-400">Amankan akun Anda dengan kata sandi yang kuat</span>
                </div>
            </div>

            <form action="{{ route('admin.profile.password') }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-gray-700 uppercase">Kata Sandi Saat Ini</label>
                    <input type="password" name="current_password" required
                        placeholder="Masukkan kata sandi lama Anda"
                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-amber-500 outline-none">
                    @error('current_password') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-gray-700 uppercase">Kata Sandi Baru (Min. 8 Karakter)</label>
                    <input type="password" name="password" required
                        placeholder="Kombinasi huruf, angka, simbol"
                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-amber-500 outline-none">
                    @error('password') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-gray-700 uppercase">Konfirmasi Kata Sandi Baru</label>
                    <input type="password" name="password_confirmation" required
                        placeholder="Ulangi kata sandi baru"
                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-amber-500 outline-none">
                </div>

                <div class="pt-2 flex justify-end">
                    <button type="submit" class="px-5 py-2.5 bg-amber-600 hover:bg-amber-700 text-white font-bold text-xs rounded-xl shadow-md transition-all">
                        Perbarui Kata Sandi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
