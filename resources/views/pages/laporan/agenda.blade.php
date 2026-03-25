@extends('layouts.app')

@section('title', 'Agenda Bulanan - PPID Dispora Jatim')

@section('content')
    <div class="max-w-4xl mx-auto space-y-8">

        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 pb-6 border-b border-gray-200">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Agenda Kegiatan PPID</h1>
                <p class="text-gray-500">Jadwal kegiatan, rapat koordinasi, dan evaluasi tim PPID Dispora Jatim.</p>
            </div>
            <div class="flex gap-2">
                <select
                    class="px-4 py-2 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-tosca-500 outline-none shadow-sm text-gray-700 font-medium">
                    <option value="03" selected>Maret 2026</option>
                    <option value="02">Februari 2026</option>
                    <option value="01">Januari 2026</option>
                </select>
            </div>
        </div>

        <div class="relative border-l-2 border-gray-200 ml-4 lg:ml-0 space-y-8 mt-8">

            @forelse ($agendas as $index => $item)
                <div class="relative pl-8">
                    @if ($index === 0)
                        <div class="absolute w-4 h-4 bg-tosca-500 border-4 border-tosca-100 rounded-full -left-[9px] top-1">
                        </div>
                    @else
                        <div class="absolute w-4 h-4 bg-gray-300 border-4 border-white rounded-full -left-[9px] top-1">
                        </div>
                    @endif

                    <div
                        class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">

                        <div class="flex flex-wrap items-center gap-3 mb-4">
                            <span
                                class="px-3 py-1 {{ $index === 0 ? 'bg-tosca-100 text-tosca-700' : 'bg-gray-100 text-gray-600' }} text-xs font-bold rounded-lg flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                                {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}
                            </span>

                            @if ($item->waktu_mulai)
                                <span class="text-xs text-gray-500 flex items-center gap-1 font-medium">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ \Carbon\Carbon::parse($item->waktu_mulai)->format('H:i') }} -
                                    {{ $item->waktu_selesai ? \Carbon\Carbon::parse($item->waktu_selesai)->format('H:i') . ' WIB' : 'Selesai' }}
                                </span>
                            @endif
                        </div>

                        <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $item->judul }}</h3>
                        <p class="text-sm text-gray-600 mb-4">{{ $item->deskripsi }}</p>

                        @if ($item->lokasi)
                            <div class="bg-gray-50 px-4 py-3 rounded-xl flex items-center gap-2 text-sm text-gray-500">
                                <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                {{ $item->lokasi }}
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="pl-8 py-10">
                    <p class="text-gray-500 italic">Belum ada agenda kegiatan yang dijadwalkan.</p>
                </div>
            @endforelse

        </div>
    </div>
@endsection
