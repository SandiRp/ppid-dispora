@extends('layouts.app')

@section('title', 'Laporan Pelayanan Publik - PPID Dispora Jatim')

@section('content')
    <div class="max-w-5xl mx-auto space-y-8">

        <div class="pb-6 border-b border-gray-200">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Laporan Pelayanan Informasi Publik</h1>
            <p class="text-gray-500">Laporan tahunan komprehensif terkait pelaksanaan tugas dan fungsi PPID sesuai amanat
                Undang-Undang KIP.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

            @forelse ($laporans as $item)
                <div
                    class="bg-white rounded-2xl p-6 shadow-sm {{ $loop->first ? 'border border-blue-200 hover:shadow-xl hover:-translate-y-1' : 'border border-gray-100 hover:shadow-xl hover:-translate-y-1 hover:border-blue-300' }} transition-all duration-300 relative overflow-hidden group">

                    @if ($loop->first)
                        <div
                            class="absolute top-0 right-0 bg-blue-500 text-white text-[10px] font-bold px-3 py-1 rounded-bl-lg z-10">
                            TERBARU</div>
                    @endif

                    <div
                        class="w-16 h-16 {{ $loop->first ? 'bg-blue-50 text-blue-600' : 'bg-gray-50 text-gray-400 group-hover:bg-blue-50 group-hover:text-blue-600' }} rounded-2xl flex items-center justify-center mb-6 transition-colors group-hover:scale-110 duration-300">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                    </div>

                    <h3 class="text-xl font-bold text-gray-900 mb-1">Tahun {{ $item->tahun }}</h3>
                    <p class="text-sm text-gray-500 mb-6 line-clamp-2" title="{{ $item->judul }}">{{ $item->judul }}</p>

                    <a href="{{ asset('storage/' . $item->file_pdf) }}" target="_blank"
                        class="flex items-center justify-center gap-2 w-full py-2.5 {{ $loop->first ? 'bg-blue-50 text-blue-700 hover:bg-blue-600 hover:text-white border border-blue-100' : 'bg-gray-50 text-gray-600 hover:bg-blue-600 hover:text-white border border-gray-200' }} font-semibold rounded-xl transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        Unduh PDF
                    </a>
                </div>
            @empty
                <div
                    class="col-span-full py-12 text-center text-gray-500 italic bg-white rounded-2xl border border-dashed border-gray-200">
                    Belum ada data laporan pelayanan publik.
                </div>
            @endforelse

        </div>
    </div>
@endsection
