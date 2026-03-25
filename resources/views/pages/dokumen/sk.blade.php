@extends('layouts.app')

@section('title', 'SK Penetapan PPID - Dispora Jatim')

@section('content')
    <div class="max-w-7xl mx-auto space-y-8">

        <div class="pb-6 border-b border-gray-200">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">SK Penetapan PPID</h1>
            <p class="text-gray-500">Surat Keputusan terkait pembentukan dan susunan keanggotaan pengelola informasi.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <div class="lg:col-span-2 space-y-4">
                <h2 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-blue-500 animate-pulse"></span>
                    SK PPID Terbaru
                </h2>
                <div
                    class="bg-white p-2 rounded-2xl shadow-sm border border-gray-200 h-[600px] relative overflow-hidden group">

                    @if ($terbaru)
                        <iframe src="{{ asset('storage/' . $terbaru->file_pdf) }}" class="w-full h-full rounded-xl"
                            title="Preview SK Terbaru">
                        </iframe>
                        <div
                            class="absolute top-4 left-4 bg-white/90 backdrop-blur text-gray-800 px-4 py-2 rounded-lg shadow text-sm font-bold border border-gray-100">
                            {{ $terbaru->judul }}
                        </div>
                    @else
                        <div
                            class="w-full h-full flex flex-col items-center justify-center text-gray-400 bg-gray-50 rounded-xl">
                            <svg class="w-16 h-16 mb-4 text-blue-200" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                            <p>Belum ada dokumen SK yang diunggah.</p>
                        </div>
                    @endif

                </div>
            </div>

            <div class="lg:col-span-1 space-y-4">
                <h2 class="text-lg font-bold text-gray-800 border-b-2 border-blue-200 pb-2">Daftar SK</h2>

                <div class="space-y-3">

                    @forelse ($dokumens as $index => $dok)
                        <a href="{{ asset('storage/' . $dok->file_pdf) }}" target="_blank"
                            class="block {{ $index === 0 ? 'bg-blue-50 border-blue-200' : 'bg-white border-gray-100 hover:border-blue-300' }} border p-4 rounded-xl hover:shadow-md transition-all relative overflow-hidden group">

                            @if ($index === 0)
                                <div
                                    class="absolute top-0 right-0 bg-blue-500 text-white text-[10px] font-bold px-2 py-1 rounded-bl-lg">
                                    TERBARU</div>
                            @else
                                <div
                                    class="absolute top-0 right-0 bg-gray-200 text-gray-600 text-[10px] font-bold px-2 py-1 rounded-bl-lg">
                                    TAHUN {{ $dok->tahun }}</div>
                            @endif

                            <div class="flex items-start gap-3 mt-1">
                                <div
                                    class="{{ $index === 0 ? 'text-blue-600' : 'text-gray-400 group-hover:text-blue-500' }} bg-white p-2 rounded-lg shadow-sm transition-colors">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3
                                        class="font-bold {{ $index === 0 ? 'text-gray-900' : 'text-gray-700 group-hover:text-gray-900' }} text-sm mb-1 leading-tight">
                                        {{ $dok->judul }}</h3>
                                    <p class="text-xs text-gray-500">{{ $dok->keterangan }}</p>
                                </div>
                            </div>
                        </a>
                    @empty
                        <p class="text-sm text-gray-500 italic text-center py-4">Tidak ada data SK.</p>
                    @endforelse

                </div>
            </div>

        </div>
    </div>
@endsection
