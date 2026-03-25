@extends('layouts.admin')
@section('title', 'Tulis Berita Baru - Admin PPID')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">

        <div class="flex items-center gap-4 pb-6 border-b border-gray-200">
            <a href="{{ route('admin.berita.index') }}"
                class="p-2 bg-gray-100 text-gray-600 hover:bg-gray-200 rounded-lg transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                    </path>
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Tulis Berita Baru</h1>
                <p class="text-gray-500">Isi formulir di bawah untuk mempublikasikan informasi.</p>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
            <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Judul Berita <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="judul" required placeholder="Masukkan judul yang menarik..."
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-tosca-500 outline-none transition-all">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Kategori <span
                                class="text-red-500">*</span></label>
                        <select name="kategori" required
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-tosca-500 outline-none">
                            <option value="Informasi">Informasi Umum</option>
                            <option value="Kegiatan">Kegiatan Dispora</option>
                            <option value="Pengumuman">Pengumuman</option>
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Gambar / Thumbnail (Opsional)</label>
                        <input type="file" name="gambar" accept=".jpg,.jpeg,.png"
                            class="w-full px-2 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm file:mr-4 file:py-1 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-tosca-100 file:text-tosca-700 hover:file:bg-tosca-200 cursor-pointer">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Isi Konten Berita <span
                            class="text-red-500">*</span></label>
                    <textarea name="konten" required rows="10" placeholder="Tuliskan isi berita Anda di sini..."
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-tosca-500 outline-none transition-all"></textarea>
                </div>

                <div class="pt-4 flex justify-end">
                    <button type="submit"
                        class="px-8 py-3 bg-tosca-600 hover:bg-tosca-700 text-white font-bold rounded-xl shadow-lg shadow-tosca-500/30 transform hover:-translate-y-1 transition-all">
                        Publikasikan Berita
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
