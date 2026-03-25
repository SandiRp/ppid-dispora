@extends('layouts.app')

@section('title', $berita->judul . ' - PPID Dispora Jatim')

@section('content')
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">

            <div class="lg:col-span-2 space-y-6">
                <nav class="flex text-sm text-gray-500 gap-2 mb-6">
                    <a href="{{ route('dashboard') }}" class="hover:text-tosca-600 transition-colors">Beranda</a>
                    <span>/</span>
                    <a href="{{ route('berita.index') }}" class="hover:text-tosca-600 transition-colors">Berita</a>
                    <span>/</span>
                    <span class="text-gray-400 line-clamp-1 w-48">{{ $berita->judul }}</span>
                </nav>

                <div>
                    <span
                        class="inline-block px-3 py-1 bg-tosca-100 text-tosca-700 text-xs font-bold rounded-full mb-4">{{ $berita->kategori }}</span>
                    <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 leading-tight mb-4">{{ $berita->judul }}
                    </h1>
                    <div class="flex items-center text-sm text-gray-500 gap-4 mb-6">
                        <span class="flex items-center gap-1">
                            <svg class="w-5 h-5 text-tosca-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                            Dipublikasikan pada
                            {{ \Carbon\Carbon::parse($berita->tanggal_publish)->translatedFormat('d F Y') }}
                        </span>
                        <span class="flex items-center gap-1">
                            <svg class="w-5 h-5 text-tosca-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Admin PPID
                        </span>
                    </div>
                </div>

                @if ($berita->gambar)
                    <div class="w-full h-auto max-h-[500px] overflow-hidden rounded-2xl shadow-sm mb-8">
                        <img src="{{ asset('storage/' . $berita->gambar) }}" alt="{{ $berita->judul }}"
                            class="w-full h-full object-cover">
                    </div>
                @endif

                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100">
                    <div class="prose max-w-none text-gray-700 text-lg leading-relaxed text-justify">
                        {!! nl2br(e($berita->konten)) !!}
                    </div>
                </div>
            </div>

            <div class="lg:col-span-1 space-y-6">
                <h3 class="text-xl font-bold text-gray-900 border-b-2 border-tosca-500 pb-2 inline-block">Berita Lainnya
                </h3>

                <div class="flex flex-col gap-4">
                    @forelse ($beritaLainnya as $lainnya)
                        <a href="{{ route('berita.show', $lainnya->slug) }}"
                            class="group flex gap-4 bg-white p-3 rounded-2xl shadow-sm border border-gray-100 hover:border-tosca-300 transition-all">
                            <div class="w-24 h-24 shrink-0 bg-gray-100 rounded-xl overflow-hidden">
                                @if ($lainnya->gambar)
                                    <img src="{{ asset('storage/' . $lainnya->gambar) }}"
                                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-300">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="flex flex-col justify-center">
                                <span
                                    class="text-[10px] font-bold text-tosca-600 mb-1">{{ \Carbon\Carbon::parse($lainnya->tanggal_publish)->translatedFormat('d M Y') }}</span>
                                <h4
                                    class="font-bold text-gray-800 text-sm leading-snug group-hover:text-tosca-600 transition-colors line-clamp-3">
                                    {{ $lainnya->judul }}
                                </h4>
                            </div>
                        </a>
                    @empty
                        <p class="text-gray-500 text-sm italic">Belum ada berita lainnya.</p>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
@endsection
