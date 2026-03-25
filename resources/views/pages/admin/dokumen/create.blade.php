@extends('layouts.admin')

@section('title', 'Unggah Dokumen Baru - Admin PPID')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">

        <div class="flex items-center gap-4 pb-6 border-b border-gray-200">
            <a href="{{ route('admin.dokumen.index') }}"
                class="p-2 bg-gray-100 text-gray-600 hover:bg-gray-200 rounded-lg transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                    </path>
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Unggah Dokumen Baru</h1>
                <p class="text-gray-500">Pilih kategori (Regulasi/SOP/SK) agar masuk ke halaman yang tepat.</p>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
            <form action="{{ route('admin.dokumen.store') }}" method="POST" enctype="multipart/form-data"
                class="space-y-6">
                @csrf

                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Judul Dokumen <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="judul" required placeholder="Contoh: UU Nomor 14 Tahun 2008..."
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-tosca-500 outline-none transition-all">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Kategori Dokumen <span
                                class="text-red-500">*</span></label>
                        <select name="kategori" required
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-tosca-500 outline-none">
                            <option value="regulasi">Regulasi</option>
                            <option value="sop">SOP (Standar Operasional)</option>
                            <option value="sk">SK (Surat Keputusan)</option>
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Tahun <span
                                class="text-red-500">*</span></label>
                        <input type="number" name="tahun" required placeholder="Contoh: 2026"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-tosca-500 outline-none transition-all">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Keterangan Singkat</label>
                    <textarea name="keterangan" rows="2" placeholder="Penjelasan singkat mengenai isi dokumen..."
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-tosca-500 outline-none transition-all resize-none"></textarea>
                </div>

                <div class="space-y-2 p-5 bg-gray-50 border border-gray-200 rounded-xl border-dashed">
                    <label class="block text-sm font-semibold text-gray-700">Unggah File (Wajib PDF) <span
                            class="text-red-500">*</span></label>
                    <input type="file" name="file_pdf" required accept=".pdf"
                        class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-tosca-600 file:text-white hover:file:bg-tosca-700 transition-all cursor-pointer">
                    <p class="text-xs text-gray-500 mt-1">*Maksimal ukuran file: 10MB.</p>
                    @error('file_pdf')
                        <span class="text-red-500 text-xs font-bold">{{ $message }}</span>
                    @enderror
                </div>

                <div class="pt-4 flex justify-end">
                    <button type="submit"
                        class="px-8 py-3 bg-tosca-600 hover:bg-tosca-700 text-white font-bold rounded-xl shadow-lg shadow-tosca-500/30 transform hover:-translate-y-1 transition-all">
                        Simpan & Publikasikan Dokumen
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
