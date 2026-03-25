@extends('layouts.app')

@section('title', 'Dashboard - PPID Dispora Jatim')

@section('content')
    <div class="space-y-12">

        <div
            class="bg-white/60 backdrop-blur-lg rounded-3xl p-8 md:p-12 shadow-sm border border-white/50 text-center relative overflow-hidden">
            <div class="relative z-10">
                <h2 class="text-3xl md:text-5xl font-extrabold text-gray-900 mb-4 tracking-tight">
                    Layanan Informasi Publik <span
                        class="text-transparent bg-clip-text bg-gradient-to-r from-tosca-500 to-blue-600">PPID</span>
                </h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto leading-relaxed">
                    Selamat datang di Portal Pejabat Pengelola Informasi dan Dokumentasi (PPID) Dinas Kepemudaan dan
                    Olahraga Provinsi Jawa Timur. Wujud nyata transparansi dan akuntabilitas.
                </p>
            </div>
            <div
                class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-tosca-200 rounded-full mix-blend-multiply filter blur-2xl opacity-60">
            </div>
            <div
                class="absolute bottom-0 left-0 -mb-10 -ml-10 w-40 h-40 bg-blue-200 rounded-full mix-blend-multiply filter blur-2xl opacity-60">
            </div>
        </div>

        <div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <div
                    class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center gap-5 hover:shadow-md transition-shadow group">
                    <div
                        class="w-16 h-16 bg-tosca-50 rounded-2xl flex items-center justify-center text-tosca-600 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-1">Total Permintaan</p>
                        <p class="text-4xl font-black text-gray-900">{{ $totalPermintaan }}</p>
                    </div>
                </div>

                <div
                    class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center gap-5 hover:shadow-md transition-shadow group">
                    <div
                        class="w-16 h-16 bg-yellow-50 rounded-2xl flex items-center justify-center text-yellow-500 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-1">Dalam Proses</p>
                        <p class="text-4xl font-black text-gray-900">{{ $permintaanProses }}</p>
                    </div>
                </div>

                <div
                    class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center gap-5 hover:shadow-md transition-shadow group">
                    <div
                        class="w-16 h-16 bg-green-50 rounded-2xl flex items-center justify-center text-green-500 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-1">Sudah Selesai</p>
                        <p class="text-4xl font-black text-gray-900">{{ $permintaanSelesai }}</p>
                    </div>
                </div>

            </div>
        </div>

        <div>
            <div class="flex items-center gap-3 mb-6">
                <span class="w-8 h-1.5 bg-tosca-500 rounded-full"></span>
                <h3 class="text-2xl font-bold text-gray-800">Alur Layanan Informasi</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                <div
                    class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 hover:-translate-y-2 transition-transform duration-300">
                    <div class="bg-gray-50 rounded-xl mb-4 overflow-hidden relative shadow-inner">
                        <img src="{{ asset('assets/images/informasi.png') }}" alt="Alur Permohonan Informasi"
                            class="w-full h-auto object-contain hover:scale-105 transition-transform duration-500">
                    </div>
                    <h4 class="font-bold text-gray-800 text-center">Permohonan Informasi</h4>
                </div>

                <div
                    class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 hover:-translate-y-2 transition-transform duration-300">
                    <div class="bg-gray-50 rounded-xl mb-4 overflow-hidden relative shadow-inner">
                        <img src="{{ asset('assets/images/keberatan2.png') }}" alt="Alur Pengajuan Keberatan"
                            class="w-full h-auto object-contain hover:scale-105 transition-transform duration-500">
                    </div>
                    <h4 class="font-bold text-gray-800 text-center">Pengajuan Keberatan</h4>
                </div>

                <div
                    class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 hover:-translate-y-2 transition-transform duration-300">
                    <div class="bg-gray-50 rounded-xl mb-4 overflow-hidden relative shadow-inner">
                        <img src="{{ asset('assets/images/sengketa2.png') }}" alt="Alur Sengketa Informasi"
                            class="w-full h-auto object-contain hover:scale-105 transition-transform duration-500">
                    </div>
                    <h4 class="font-bold text-gray-800 text-center">Penyelesaian Sengketa</h4>
                </div>

            </div>
        </div>

        <div class="pb-10">
            <div class="flex items-center gap-3 mb-6">
                <span class="w-8 h-1.5 bg-tosca-500 rounded-full"></span>
                <h3 class="text-2xl font-bold text-gray-800">Berita & Informasi Terbaru</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                @forelse ($beritaTerbaru as $berita)
                    <a href="{{ route('berita.show', $berita->slug) }}"
                        class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 group flex flex-col hover:shadow-lg transition-all duration-300">

                        <div class="h-48 bg-gray-100 overflow-hidden relative">
                            @if ($berita->gambar)
                                <img src="{{ asset('storage/' . $berita->gambar) }}" alt="{{ $berita->judul }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div
                                    class="w-full h-full bg-tosca-50 flex items-center justify-center text-tosca-300 group-hover:scale-105 transition-transform duration-500">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                            @endif
                            <div
                                class="absolute top-4 left-4 bg-white/90 backdrop-blur text-tosca-700 text-xs font-bold px-3 py-1 rounded-full shadow-sm">
                                {{ $berita->kategori }}
                            </div>
                        </div>

                        <div class="p-6 flex-grow flex flex-col">
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-xs text-gray-500 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    {{ \Carbon\Carbon::parse($berita->tanggal_publish)->translatedFormat('d F Y') }}
                                </span>
                            </div>
                            <h4
                                class="font-bold text-gray-900 mb-2 group-hover:text-tosca-600 transition-colors line-clamp-2">
                                {{ $berita->judul }}
                            </h4>
                            <p class="text-sm text-gray-500 line-clamp-3 mt-auto">
                                {{ Str::limit(strip_tags($berita->konten), 100) }}
                            </p>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full bg-white rounded-2xl p-10 text-center border border-dashed border-gray-300">
                        <div
                            class="w-16 h-16 bg-gray-50 text-gray-400 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15">
                                </path>
                            </svg>
                        </div>
                        <h4 class="text-lg font-bold text-gray-700 mb-1">Belum Ada Informasi</h4>
                        <p class="text-gray-500 text-sm">Informasi dan berita terbaru dari PPID Dispora Jatim akan segera
                            hadir di sini.</p>
                    </div>
                @endforelse

            </div>
            <div class="mt-8 text-center">
                <a href="{{ route('berita.index') }}"
                    class="inline-flex items-center gap-2 px-6 py-3 bg-white border border-tosca-200 text-tosca-600 font-semibold rounded-xl hover:bg-tosca-50 transition-colors shadow-sm">
                    Lihat Semua Berita & Informasi
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </a>
            </div>
        </div>

    </div>
@endsection
