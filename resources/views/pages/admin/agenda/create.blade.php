@extends('layouts.admin')

@section('title', 'Tambah Agenda - Admin PPID')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">

        <div class="flex items-center gap-4 pb-6 border-b border-gray-200">
            <a href="{{ route('admin.agenda.index') }}"
                class="p-2 bg-gray-100 text-gray-600 hover:bg-gray-200 rounded-lg transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                    </path>
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Tambah Agenda Kegiatan</h1>
                <p class="text-gray-500">Jadwalkan acara atau rapat baru untuk ditampilkan di timeline PPID.</p>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
            <form action="{{ route('admin.agenda.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Nama / Judul Kegiatan <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="judul" required
                        placeholder="Contoh: Rapat Koordinasi Evaluasi Layanan Informasi"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-tosca-500 outline-none transition-all">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Tanggal Pelaksanaan <span
                                class="text-red-500">*</span></label>
                        <input type="date" name="tanggal" required
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-tosca-500 outline-none transition-all text-gray-700">
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Waktu Mulai (Opsional)</label>
                        <input type="time" name="waktu_mulai"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-tosca-500 outline-none transition-all text-gray-700">
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Waktu Selesai (Opsional)</label>
                        <input type="time" name="waktu_selesai"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-tosca-500 outline-none transition-all text-gray-700">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Lokasi Kegiatan (Opsional)</label>
                    <input type="text" name="lokasi" placeholder="Contoh: Ruang Rapat Utama Lt. 2, Dispora Prov. Jatim"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-tosca-500 outline-none transition-all">
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Deskripsi / Keterangan <span
                            class="text-red-500">*</span></label>
                    <textarea name="deskripsi" required rows="3" placeholder="Jelaskan secara singkat mengenai agenda ini..."
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-tosca-500 outline-none transition-all resize-none"></textarea>
                </div>

                <div class="pt-4 flex justify-end">
                    <button type="submit"
                        class="px-8 py-3 bg-tosca-600 hover:bg-tosca-700 text-white font-bold rounded-xl shadow-lg shadow-tosca-500/30 transform hover:-translate-y-1 transition-all">
                        Simpan & Jadwalkan Agenda
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
