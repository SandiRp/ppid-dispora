@extends('layouts.app')

@section('title', 'Semua Berita & Informasi - PPID Dispora Jatim')

@section('content')
    <div class="max-w-7xl mx-auto space-y-8">

        <div class="text-center pb-6 border-b border-gray-200">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Pusat Berita & Informasi</h1>
            <p class="text-gray-500">Kumpulan informasi, pengumuman, dan kegiatan terbaru dari PPID Dispora Jawa Timur.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($beritas as $berita)
                <a href="{{ route('berita.show', $berita->slug) }}"
                    class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 group flex flex-col hover:shadow-lg transition-all duration-300">
                    <div class="h-48 bg-gray-100 overflow-hidden relative">
                        @if ($berita->gambar)
                            <img src="{{ asset('storage/' . $berita->gambar) }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-full bg-tosca-50 flex items-center justify-center text-tosca-300">
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
                        <div class="flex items-center justify-between mb-3 text-xs text-gray-500">
                            <span class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                                {{ \Carbon\Carbon::parse($berita->tanggal_publish)->translatedFormat('d F Y') }}
                            </span>
                        </div>
                        <h4 class="font-bold text-gray-900 mb-2 group-hover:text-tosca-600 transition-colors line-clamp-2">
                            {{ $berita->judul }}</h4>
                        <p class="text-sm text-gray-500 line-clamp-3 mt-auto">
                            {{ Str::limit(strip_tags($berita->konten), 100) }}</p>
                    </div>
                </a>
            @empty
                <div class="col-span-full py-12 text-center text-gray-500">Belum ada berita yang diterbitkan.</div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $beritas->links() }}
        </div>

    </div>
@endsection
