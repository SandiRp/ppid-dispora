@extends('layouts.app')

@section('title', 'Daftar Informasi Publik (DIP) Terpadu - PPID Dispora Jatim')

@section('content')
    <div class="max-w-7xl mx-auto space-y-6">

        <div class="pb-6 border-b border-gray-200 flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-tosca-100 text-tosca-800 mb-2">
                    UU No. 14 Tahun 2008 &bull; Perki No. 1 Tahun 2021
                </span>
                <h1 class="text-3xl font-extrabold text-gray-900 mb-1">Daftar Informasi Publik (DIP) Terpadu</h1>
                <p class="text-gray-500 text-sm">Rekapitulasi resmi seluruh informasi publik Dinas Kepemudaan dan Olahraga Provinsi Jawa Timur (Berkala, Serta-Merta, & Setiap Saat).</p>
            </div>
            <button type="button" onclick="window.print()"
                class="print:hidden px-4 py-2.5 bg-white hover:bg-gray-50 text-gray-700 border border-gray-200 font-bold text-xs rounded-xl shadow-sm transition-all flex items-center gap-2 shrink-0">
                <svg class="w-4 h-4 text-tosca-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                </svg>
                Cetak Rekap DIP
            </button>
        </div>

        <!-- Ringkasan Jumlah per Klasifikasi -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="{{ route('informasi.dip', ['kategori' => 'berkala']) }}" class="p-4 bg-white rounded-2xl border border-gray-100 shadow-sm hover:border-tosca-300 transition-all">
                <span class="text-xs font-bold text-tosca-700 uppercase">Informasi Berkala</span>
                <div class="text-2xl font-black text-gray-900 mt-1">{{ $countBerkala }}</div>
                <span class="text-[11px] text-gray-400">Tersedia rutin</span>
            </a>
            <a href="{{ route('informasi.dip', ['kategori' => 'serta_merta']) }}" class="p-4 bg-white rounded-2xl border border-gray-100 shadow-sm hover:border-amber-300 transition-all">
                <span class="text-xs font-bold text-amber-700 uppercase">Informasi Serta-Merta</span>
                <div class="text-2xl font-black text-gray-900 mt-1">{{ $countSertaMerta }}</div>
                <span class="text-[11px] text-gray-400">Kondisi darurat / mendesak</span>
            </a>
            <a href="{{ route('informasi.dip', ['kategori' => 'setiap_saat']) }}" class="p-4 bg-white rounded-2xl border border-gray-100 shadow-sm hover:border-blue-300 transition-all">
                <span class="text-xs font-bold text-blue-700 uppercase">Informasi Setiap Saat</span>
                <div class="text-2xl font-black text-gray-900 mt-1">{{ $countSetiapSaat }}</div>
                <span class="text-[11px] text-gray-400">Wajib tersedia kapan saja</span>
            </a>
            <a href="{{ route('informasi.dikecualikan') }}" class="p-4 bg-white rounded-2xl border border-gray-100 shadow-sm hover:border-red-300 transition-all">
                <span class="text-xs font-bold text-red-700 uppercase">Informasi Dikecualikan</span>
                <div class="text-2xl font-black text-gray-900 mt-1">{{ $countDikecualikan }}</div>
                <span class="text-[11px] text-gray-400">Ketat & terbatas (Uji Konsekuensi)</span>
            </a>
        </div>

        <!-- Filter Pencarian, Kategori & Tahun -->
        <div class="print:hidden bg-white p-4 rounded-2xl shadow-sm border border-gray-100">
            <form action="{{ route('informasi.dip') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-4 gap-3">
                <div class="sm:col-span-2 relative">
                    <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari judul informasi atau penanggung jawab..."
                        class="w-full pl-9 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-tosca-500 outline-none text-xs">
                </div>
                <div>
                    <select name="kategori" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:ring-2 focus:ring-tosca-500 outline-none">
                        <option value="">-- Semua Klasifikasi --</option>
                        <option value="berkala" {{ request('kategori') === 'berkala' ? 'selected' : '' }}>Informasi Berkala</option>
                        <option value="serta_merta" {{ request('kategori') === 'serta_merta' ? 'selected' : '' }}>Informasi Serta-Merta</option>
                        <option value="setiap_saat" {{ request('kategori') === 'setiap_saat' ? 'selected' : '' }}>Informasi Setiap Saat</option>
                    </select>
                </div>
                <div class="flex items-center gap-2">
                    <select name="tahun" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:ring-2 focus:ring-tosca-500 outline-none">
                        <option value="">Semua Tahun</option>
                        @foreach ($daftarTahun as $thn)
                            <option value="{{ $thn }}" {{ request('tahun') == $thn ? 'selected' : '' }}>{{ $thn }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="px-4 py-2 bg-tosca-600 hover:bg-tosca-700 text-white font-bold text-xs rounded-xl transition-colors shrink-0">
                        Filter
                    </button>
                    @if (request()->hasAny(['q', 'kategori', 'tahun']))
                        <a href="{{ route('informasi.dip') }}" class="px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 font-bold text-xs rounded-xl">Reset</a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Tabel Resmi DIP Terpadu -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-600">
                    <thead class="bg-tosca-50/60 text-tosca-900 border-b border-gray-200 text-xs uppercase tracking-wider">
                        <tr>
                            <th class="py-4 px-5 font-bold w-14 text-center">No</th>
                            <th class="py-4 px-5 font-bold">Ringkasan Isi Informasi</th>
                            <th class="py-4 px-5 font-bold">Klasifikasi</th>
                            <th class="py-4 px-5 font-bold">Penanggung Jawab</th>
                            <th class="py-4 px-5 font-bold text-center">Tahun</th>
                            <th class="py-4 px-5 font-bold text-center">Format</th>
                            <th class="py-4 px-5 font-bold text-center print:hidden">Dokumen</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($informasis as $index => $item)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="py-4 px-5 text-center text-gray-400">{{ $informasis->firstItem() + $index }}</td>
                                <td class="py-4 px-5">
                                    <p class="font-bold text-gray-800 mb-0.5">{{ $item->ringkasan_informasi }}</p>
                                    @if ($item->deskripsi)
                                        <p class="text-xs text-gray-500 line-clamp-2">{{ $item->deskripsi }}</p>
                                    @endif
                                </td>
                                <td class="py-4 px-5 whitespace-nowrap">
                                    @if ($item->kategori === 'berkala')
                                        <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-tosca-100 text-tosca-800">Berkala</span>
                                    @elseif ($item->kategori === 'serta_merta')
                                        <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-amber-100 text-amber-800">Serta-Merta</span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-blue-100 text-blue-800">Setiap Saat</span>
                                    @endif
                                </td>
                                <td class="py-4 px-5 text-xs text-gray-700 font-medium">{{ $item->penanggung_jawab }}</td>
                                <td class="py-4 px-5 text-center font-bold text-gray-700">{{ $item->tahun }}</td>
                                <td class="py-4 px-5 text-center">
                                    <span class="px-2 py-0.5 rounded-full text-[11px] font-bold bg-gray-100 text-gray-700 uppercase">
                                        {{ $item->format }}
                                    </span>
                                </td>
                                <td class="py-4 px-5 text-center print:hidden">
                                    @if ($item->file_dokumen)
                                        <a href="{{ asset('storage/' . $item->file_dokumen) }}" target="_blank"
                                            class="inline-flex items-center gap-1 px-3 py-1.5 bg-tosca-50 hover:bg-tosca-600 text-tosca-700 hover:text-white border border-tosca-200 rounded-lg text-xs font-bold transition-all">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                            </svg>
                                            Unduh
                                        </a>
                                    @else
                                        <span class="text-xs text-gray-400 italic">Tersedia di Meja PPID</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-12 text-center text-gray-500 italic">
                                    Belum ada data informasi publik yang sesuai dengan filter yang dipilih.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($informasis->hasPages())
                <div class="p-4 border-t border-gray-100 print:hidden">
                    {{ $informasis->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
