@extends('layouts.admin')

@section('title', 'Edit Laporan - Admin PPID')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">

        <div class="flex items-center gap-4 pb-6 border-b border-gray-200">
            <a href="{{ route('admin.laporan.index') }}"
                class="p-2 bg-gray-100 text-gray-600 hover:bg-gray-200 rounded-lg transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                    </path>
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Edit Laporan PPID</h1>
                <p class="text-gray-500">Perbarui data laporan akses atau pelayanan informasi.</p>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
            <form action="{{ route('admin.laporan.update', $laporan->id) }}" method="POST" enctype="multipart/form-data"
                class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Kategori Laporan <span
                                class="text-red-500">*</span></label>
                        <select name="kategori" required
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-tosca-500 outline-none">
                            <option value="akses" {{ old('kategori', $laporan->kategori) == 'akses' ? 'selected' : '' }}>Laporan Akses Informasi Publik</option>
                            <option value="pelayanan" {{ old('kategori', $laporan->kategori) == 'pelayanan' ? 'selected' : '' }}>Laporan Layanan Informasi Publik</option>
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Tahun Laporan <span
                                class="text-red-500">*</span></label>
                        <input type="number" name="tahun" required value="{{ old('tahun', $laporan->tahun) }}"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-tosca-500 outline-none transition-all">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Judul Laporan <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="judul" required value="{{ old('judul', $laporan->judul) }}"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-tosca-500 outline-none transition-all">
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Deskripsi Singkat (Opsional)</label>
                    <textarea name="deskripsi" rows="3"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-tosca-500 outline-none transition-all">{{ old('deskripsi', $laporan->deskripsi) }}</textarea>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Berkas Dokumen PDF (Biarkan kosong jika tidak diubah)</label>
                    @if ($laporan->file_pdf)
                        <div class="mb-2">
                            <a href="{{ asset('storage/' . $laporan->file_pdf) }}" target="_blank"
                                class="text-sm text-tosca-600 hover:underline flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                Lihat File PDF Saat Ini
                            </a>
                        </div>
                    @endif
                    <input type="file" name="file_pdf" accept=".pdf"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl file:mr-4 file:py-1 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-tosca-100 file:text-tosca-700 hover:file:bg-tosca-200 cursor-pointer">
                </div>

                <div class="pt-4 flex justify-end">
                    <button type="submit"
                        class="px-8 py-3 bg-tosca-600 hover:bg-tosca-700 text-white font-bold rounded-xl shadow-lg shadow-tosca-500/30 transform hover:-translate-y-1 transition-all">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
