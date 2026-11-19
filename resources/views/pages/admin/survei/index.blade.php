@extends('layouts.admin')

@section('title', 'Rekapitulasi Survei IKM - Admin PPID')

@section('content')
    <div class="max-w-7xl mx-auto space-y-6">

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-6 border-b border-gray-200">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-1">Survei Kepuasan Masyarakat (IKM)</h1>
                <p class="text-gray-500">Hasil penilaian kepuasan masyarakat berdasarkan Permenpan RB No. 14 Tahun 2017.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.survei.export') }}"
                    class="px-4 py-2 bg-emerald-50 text-emerald-800 hover:bg-emerald-100 font-bold rounded-xl text-xs border border-emerald-300 transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Ekspor CSV (Excel)
                </a>
                <a href="{{ route('laporan.statistik') }}" target="_blank"
                    class="px-4 py-2 bg-tosca-50 text-tosca-700 hover:bg-tosca-100 font-semibold rounded-xl text-xs border border-tosca-200 transition-colors">
                    Lihat Laporan Publik &rarr;
                </a>
            </div>
        </div>

        <!-- 3 Card Ringkasan IKM -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 bg-tosca-50 text-tosca-600 rounded-xl flex items-center justify-center font-black text-xl">
                    ★
                </div>
                <div>
                    <span class="text-xs font-bold text-gray-400 uppercase">Nilai Rata-rata IKM</span>
                    <h3 class="text-2xl font-black text-tosca-700">{{ number_format($rataRataIkm, 2) }}</h3>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center font-bold text-lg">
                    ✓
                </div>
                <div>
                    <span class="text-xs font-bold text-gray-400 uppercase">Mutu Pelayanan</span>
                    <h3 class="text-lg font-bold text-emerald-700">{{ $mutu }}</h3>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center font-bold text-lg">
                    👥
                </div>
                <div>
                    <span class="text-xs font-bold text-gray-400 uppercase">Total Responden</span>
                    <h3 class="text-2xl font-black text-blue-700">{{ $totalResponden }} Orang</h3>
                </div>
            </div>
        </div>

        <!-- Tabel Responden Survei -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-gray-600">
                    <thead class="bg-gray-50 text-gray-800 border-b border-gray-200 uppercase tracking-wider font-semibold">
                        <tr>
                            <th class="py-3 px-4 w-12 text-center">No</th>
                            <th class="py-3 px-4">Tanggal</th>
                            <th class="py-3 px-4">Responden</th>
                            <th class="py-3 px-4">Terkait Permohonan</th>
                            <th class="py-3 px-4 text-center">Skor (1-4)</th>
                            <th class="py-3 px-4 text-center">Nilai IKM</th>
                            <th class="py-3 px-4">Kritik / Saran</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($surveis as $index => $item)
                            <tr class="hover:bg-gray-50/50">
                                <td class="py-3 px-4 text-center text-gray-400">{{ $surveis->firstItem() + $index }}</td>
                                <td class="py-3 px-4 whitespace-nowrap text-gray-500 font-mono">
                                    {{ $item->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="py-3 px-4 font-bold text-gray-900">
                                    {{ $item->nama_responden }}
                                    <span class="block text-[11px] font-normal text-gray-400">{{ $item->email_responden ?? '-' }}</span>
                                </td>
                                <td class="py-3 px-4 font-mono font-semibold text-tosca-700 whitespace-nowrap">
                                    {{ $item->permohonan->nomor_registrasi ?? '-' }}
                                </td>
                                <td class="py-3 px-4 text-center font-bold text-gray-800">
                                    {{ $item->skor_rata_rata }}
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <span class="px-2 py-0.5 rounded font-black text-xs bg-emerald-100 text-emerald-800">
                                        {{ $item->nilai_ikm }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-gray-700 max-w-xs break-words">
                                    {{ $item->saran_masukan ?? '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-12 text-center text-gray-400">Belum ada responden yang mengisi survei IKM.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($surveis->hasPages())
                <div class="p-4 border-t border-gray-100">
                    {{ $surveis->links() }}
                </div>
            @endif
        </div>

    </div>
@endsection
