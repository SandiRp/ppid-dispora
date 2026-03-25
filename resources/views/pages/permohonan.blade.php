@extends('layouts.app')

@section('title', 'Ajukan Permohonan Informasi - PPID Dispora Jatim')

@section('content')
    <div class="max-w-4xl mx-auto space-y-8">

        <div class="text-center pb-6">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Formulir Permohonan Informasi</h1>
            <p class="text-gray-500">Silakan lengkapi data di bawah ini dengan benar untuk mengajukan permohonan informasi
                publik.</p>
        </div>

        {{-- @if (session('success'))
            <div
                class="bg-tosca-50 border border-tosca-200 text-tosca-800 px-6 py-4 rounded-2xl shadow-sm flex items-start gap-4">
                <svg class="w-6 h-6 text-tosca-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <h3 class="font-bold text-lg">Berhasil!</h3>
                    <p>{{ session('success') }}</p>
                </div>
            </div>
        @endif --}}

        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 md:p-10 relative overflow-hidden">

            <div
                class="absolute top-0 right-0 w-64 h-64 bg-tosca-50 rounded-full mix-blend-multiply filter blur-3xl opacity-50 pointer-events-none">
            </div>

            <form action="{{ route('permohonan.store') }}" method="POST" enctype="multipart/form-data"
                class="space-y-6 relative z-10">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Kategori Pemohon <span
                                class="text-red-500">*</span></label>
                        <select name="kategori" required
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-tosca-500 outline-none transition-all">
                            <option value="perorangan">Perorangan</option>
                            <option value="lembaga">Lembaga / Organisasi</option>
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">NIK / Nomor Identitas <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="nik_identitas" required placeholder="Masukkan NIK Anda"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-tosca-500 outline-none transition-all">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Nama Lengkap <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="nama_lengkap" required placeholder="Nama sesuai identitas"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-tosca-500 outline-none transition-all">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Alamat Email <span
                                class="text-red-500">*</span></label>
                        <input type="email" name="email" required placeholder="email@contoh.com"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-tosca-500 outline-none transition-all">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Rincian Informasi yang Dibutuhkan <span
                            class="text-red-500">*</span></label>
                    <textarea name="rincian_informasi" required rows="3" placeholder="Jelaskan secara spesifik..."
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-tosca-500 outline-none transition-all resize-none"></textarea>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Tujuan Penggunaan Informasi <span
                            class="text-red-500">*</span></label>
                    <textarea name="tujuan_penggunaan" required rows="2" placeholder="Contoh: Untuk keperluan penelitian..."
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-tosca-500 outline-none transition-all resize-none"></textarea>
                </div>

                <div class="space-y-2 p-5 bg-tosca-50 border border-tosca-100 rounded-xl border-dashed">
                    <label class="block text-sm font-semibold text-tosca-800">Dokumen Pendukung (KTP/Surat Tugas) <span
                            class="text-red-500">*</span></label>
                    <input type="file" name="file_pendukung" required accept=".pdf,.jpg,.jpeg,.png"
                        class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-tosca-600 file:text-white hover:file:bg-tosca-700 transition-all cursor-pointer">
                    <p class="text-xs text-tosca-600 mt-1">*Format yang diizinkan: PDF, JPG, PNG. Maksimal ukuran file: 5MB.
                    </p>
                    @error('file_pendukung')
                        <span class="text-red-500 text-xs font-bold">{{ $message }}</span>
                    @enderror
                </div>

                <div class="pt-4 border-t border-gray-100 flex justify-end">
                    <button type="submit"
                        class="px-8 py-3 bg-gradient-to-r from-tosca-500 to-tosca-600 hover:from-tosca-600 hover:to-tosca-700 text-white font-bold rounded-xl shadow-lg shadow-tosca-500/30 transform hover:-translate-y-1 transition-all flex items-center gap-2">
                        Kirim Permohonan
                    </button>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Mengecek apakah ada session 'success' dari Controller
            @if (session('success'))
                Swal.fire({
                    title: "Berhasil!",
                    text: "{!! session('success') !!}",
                    icon: "success",
                    confirmButtonText: "Tutup",
                    confirmButtonColor: "#14b8a6", // Warna tosca-500 kita
                    background: "#ffffff",
                    backdrop: `
                        rgba(0,0,123,0.1)
                    `
                });
            @endif
        });
    </script>
@endsection
