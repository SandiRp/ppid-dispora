@extends('layouts.app')

@section('title', 'Pencarian Informasi Publik - PPID Dispora Jatim')

@section('content')
    <div class="max-w-5xl mx-auto space-y-8">

        <!-- Form Pencarian Global -->
        <div class="text-center pb-2">
            <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-2">Pencarian Informasi Terpadu</h1>
            <p class="text-gray-500 max-w-xl mx-auto text-sm">Cari berita, dokumen regulasi, surat keputusan, daftar informasi publik, dan laporan tahunan PPID.</p>

            <form action="{{ route('cari') }}" method="GET" class="mt-6 max-w-2xl mx-auto">
                <div class="relative flex items-center">
                    <input type="text" name="q" value="{{ $q }}" required placeholder="Ketik kata kunci dokumen atau berita yang dicari..."
                        class="w-full pl-12 pr-28 py-3.5 bg-white border border-gray-200 rounded-2xl shadow-sm focus:ring-2 focus:ring-tosca-500 outline-none text-sm text-gray-800">
                    <svg class="w-5 h-5 text-gray-400 absolute left-4 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <button type="submit"
                        class="absolute right-2 px-5 py-2 bg-tosca-600 hover:bg-tosca-700 text-white font-bold text-xs rounded-xl transition-all shadow">
                        Cari
                    </button>
                </div>
            </form>
        </div>

        @if ($q)
            <div class="flex items-center justify-between pb-3 border-b border-gray-200">
                <h2 class="text-sm font-semibold text-gray-600">
                    Hasil pencarian untuk: <strong class="text-gray-900 font-bold">"{{ $q }}"</strong>
                </h2>
                <span class="text-xs px-2.5 py-1 bg-tosca-100 text-tosca-800 rounded-full font-bold">
                    {{ $totalHasil }} ditemukan
                </span>
            </div>

            @if ($totalHasil == 0)
                <div class="bg-white rounded-3xl p-12 text-center border border-dashed border-gray-300">
                    <p class="text-gray-500 text-sm">Tidak ditemukan dokumen atau berita dengan kata kunci tersebut. Coba gunakan kata kunci umum lainnya.</p>
                </div>
            @else
                <div class="space-y-6">
                    <!-- Berita -->
                    @if ($beritas->count() > 0)
                        <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm space-y-4">
                            <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-tosca-600"></span>
                                Berita & Informasi Terkait ({{ $beritas->count() }})
                            </h3>
                            <div class="divide-y divide-gray-100">
                                @foreach ($beritas as $b)
                                    <div class="py-3 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                                        <div>
                                            <a href="{{ route('berita.show', $b->slug) }}" class="font-bold text-sm text-gray-800 hover:text-tosca-600 transition-colors">
                                                {{ $b->judul }}
                                            </a>
                                            <span class="block text-xs text-gray-400 mt-0.5">{{ \Carbon\Carbon::parse($b->tanggal_publish)->translatedFormat('d F Y') }}</span>
                                        </div>
                                        <a href="{{ route('berita.show', $b->slug) }}" class="text-xs font-semibold text-tosca-600 hover:underline shrink-0">
                                            Baca Selengkapnya &rarr;
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Dokumen Regulasi / SK / SOP -->
                    @if ($dokumens->count() > 0)
                        <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm space-y-4">
                            <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-blue-600"></span>
                                Dokumen Regulasi, SK & SOP ({{ $dokumens->count() }})
                            </h3>
                            <div class="divide-y divide-gray-100">
                                @foreach ($dokumens as $d)
                                    <div class="py-3 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                                        <div>
                                            <h4 class="font-bold text-sm text-gray-800">{{ $d->judul }}</h4>
                                            <span class="text-xs text-gray-400 uppercase">Kategori: {{ $d->kategori }} &bull; Tahun: {{ $d->tahun }}</span>
                                        </div>
                                        <a href="{{ asset('storage/' . $d->file_pdf) }}" target="_blank"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold text-xs rounded-lg shrink-0">
                                            Unduh PDF
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Daftar Informasi Publik (DIP) -->
                    @if ($informasis->count() > 0)
                        <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm space-y-4">
                            <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider flex items-center gap-2">
                                <span class="w-2.5 h-2.5 rounded-full bg-emerald-600"></span>
                                Daftar Informasi Publik (DIP) ({{ $informasis->count() }})
                            </h3>
                            <div class="divide-y divide-gray-100">
                                @foreach ($informasis as $inf)
                                    <div class="py-3 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                                        <div>
                                            <h4 class="font-bold text-sm text-gray-800">{{ $inf->ringkasan_informasi }}</h4>
                                            <span class="text-xs text-gray-400">PJ: {{ $inf->penanggung_jawab }} &bull; Format: {{ $inf->format }} &bull; Tahun: {{ $inf->tahun }}</span>
                                        </div>
                                        @if ($inf->file_dokumen)
                                            <a href="{{ asset('storage/' . $inf->file_dokumen) }}" target="_blank"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-800 font-semibold text-xs rounded-lg shrink-0">
                                                Unduh Dokumen
                                            </a>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            @endif
        @endif

    </div>
@endsection
