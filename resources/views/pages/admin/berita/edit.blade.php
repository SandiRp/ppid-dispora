@extends('layouts.admin')
@section('title', 'Edit Berita - Admin PPID')

@section('content')
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

    <div class="max-w-4xl mx-auto space-y-6">

        <div class="flex items-center gap-4 pb-6 border-b border-gray-200">
            <a href="{{ route('admin.berita.index') }}"
                class="p-2 bg-gray-100 text-gray-600 hover:bg-gray-200 rounded-lg transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-black text-gray-900">Edit Berita</h1>
                <p class="text-gray-500 text-sm">Perbarui informasi artikel atau ubah status publikasinya.</p>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
            <form id="beritaForm" action="{{ route('admin.berita.update', $berita->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Judul Berita <span class="text-red-500">*</span></label>
                    <input type="text" name="judul" required value="{{ old('judul', $berita->judul) }}"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-tosca-500 outline-none transition-all">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Kategori <span class="text-red-500">*</span></label>
                        <select name="kategori" required
                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-tosca-500 outline-none text-sm">
                            <option value="Informasi" {{ old('kategori', $berita->kategori) == 'Informasi' ? 'selected' : '' }}>Informasi Umum</option>
                            <option value="Kegiatan" {{ old('kategori', $berita->kategori) == 'Kegiatan' ? 'selected' : '' }}>Kegiatan Dispora</option>
                            <option value="Pengumuman" {{ old('kategori', $berita->kategori) == 'Pengumuman' ? 'selected' : '' }}>Pengumuman</option>
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Status Publikasi <span class="text-red-500">*</span></label>
                        <select name="status" required
                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-tosca-500 outline-none text-sm font-bold text-gray-800">
                            <option value="published" {{ old('status', $berita->status) == 'published' ? 'selected' : '' }}>🚀 Diterbitkan (Published)</option>
                            <option value="draft" {{ old('status', $berita->status) == 'draft' ? 'selected' : '' }}>📝 Draft (Belum Terbit)</option>
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Ganti Gambar (Opsional)</label>
                        @if ($berita->gambar)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $berita->gambar) }}" alt="Preview" class="h-16 w-24 object-cover rounded-lg border border-gray-200">
                            </div>
                        @endif
                        <input type="file" name="gambar" accept=".jpg,.jpeg,.png"
                            class="w-full px-2 py-1.5 bg-gray-50 border border-gray-200 rounded-xl text-xs file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-tosca-100 file:text-tosca-700 hover:file:bg-tosca-200 cursor-pointer">
                    </div>
                </div>

                <!-- Rich Text Editor (Quill.js) -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Isi Konten Berita <span class="text-red-500">*</span></label>
                    <input type="hidden" name="konten" id="kontenInput" required value="{{ old('konten', $berita->konten) }}">
                    <div id="quillEditor" class="bg-white rounded-b-xl border border-gray-200 min-h-[300px]">
                        {!! clean(old('konten', $berita->konten)) !!}
                    </div>
                </div>

                <div class="pt-4 flex justify-end gap-3">
                    <a href="{{ route('admin.berita.index') }}" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold rounded-xl transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-8 py-3 bg-tosca-600 hover:bg-tosca-700 text-white font-bold rounded-xl shadow-lg shadow-tosca-500/30 transform hover:-translate-y-0.5 transition-all">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const quill = new Quill('#quillEditor', {
                theme: 'snow',
                placeholder: 'Tuliskan isi artikel berita secara lengkap...',
                modules: {
                    toolbar: [
                        [{ 'header': [1, 2, 3, false] }],
                        ['bold', 'italic', 'underline', 'strike'],
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                        ['blockquote', 'code-block'],
                        ['link', 'clean']
                    ]
                }
            });

            const form = document.getElementById('beritaForm');
            const kontenInput = document.getElementById('kontenInput');

            form.addEventListener('submit', function(e) {
                kontenInput.value = quill.root.innerHTML;
                if (quill.getText().trim().length === 0) {
                    e.preventDefault();
                    alert('Mohon isi konten berita terlebih dahulu.');
                }
            });
        });
    </script>
@endsection
