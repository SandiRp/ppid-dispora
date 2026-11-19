@extends('layouts.app')

@section('title', 'Statistik & Indeks Kepuasan Masyarakat (IKM) - PPID Dispora Jatim')

@section('content')
    <div class="max-w-6xl mx-auto space-y-8">

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-4 border-b border-gray-200">
            <div>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-tosca-100 text-tosca-800 mb-2">
                    Transparansi Pelayanan
                </span>
                <h1 class="text-3xl font-extrabold text-gray-900">Statistik Pelayanan & IKM</h1>
                <p class="text-gray-500 text-sm">Rekapitulasi performa pelayanan informasi publik dan penilaian kepuasan masyarakat secara otomatis.</p>
            </div>

            <!-- Filter Tahun -->
            <form action="{{ route('laporan.statistik') }}" method="GET" class="flex items-center gap-2">
                <label class="text-xs font-bold text-gray-600 uppercase">Tahun:</label>
                <select name="tahun" onchange="this.form.submit()"
                    class="px-4 py-2 bg-white border border-gray-200 rounded-xl text-sm font-semibold text-gray-800 focus:ring-2 focus:ring-tosca-500 outline-none shadow-sm">
                    @foreach ($daftarTahun as $thn)
                        <option value="{{ $thn }}" {{ $tahun == $thn ? 'selected' : '' }}>{{ $thn }}</option>
                    @endforeach
                </select>
            </form>
        </div>

        @if (session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl text-sm font-semibold flex items-center gap-3">
                <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        <!-- Card Nilai IKM & Mutu Pelayanan -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-gradient-to-br from-teal-800 to-tosca-600 text-white rounded-3xl p-6 md:p-8 shadow-lg flex flex-col justify-between">
                <div>
                    <span class="text-xs uppercase tracking-wider text-teal-100 font-semibold block mb-1">Indeks Kepuasan Masyarakat (IKM)</span>
                    <h2 class="text-5xl font-black">{{ number_format($nilaiIkm, 2) }}</h2>
                    <span class="text-xs text-teal-100 mt-1 block">Skala 25 - 100 (Permenpan RB 14/2017)</span>
                </div>
                <div class="mt-6 pt-4 border-t border-white/20 flex items-center justify-between">
                    <div>
                        <span class="text-[11px] text-teal-100 uppercase block">Mutu Pelayanan</span>
                        <span class="text-lg font-bold text-white">{{ $mutuIkm }}</span>
                    </div>
                    <div class="text-right">
                        <span class="text-[11px] text-teal-100 uppercase block">Responden</span>
                        <span class="text-lg font-bold text-white">{{ $totalResponden }} Orang</span>
                    </div>
                </div>
            </div>

            <!-- Status Permohonan Breakdown -->
            <div class="md:col-span-2 bg-white rounded-3xl p-6 border border-gray-100 shadow-sm space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                    <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider">Rekapitulasi Permohonan Tahun {{ $tahun }}</h3>
                    <span class="text-xs font-black text-tosca-600">Total: {{ $totalPermohonan }} Permohonan</span>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-center">
                    <div class="p-4 bg-emerald-50 rounded-2xl border border-emerald-100">
                        <span class="text-xs font-semibold text-emerald-800 uppercase block">Selesai</span>
                        <span class="text-2xl font-black text-emerald-600">{{ $selesai }}</span>
                    </div>
                    <div class="p-4 bg-blue-50 rounded-2xl border border-blue-100">
                        <span class="text-xs font-semibold text-blue-800 uppercase block">Diproses</span>
                        <span class="text-2xl font-black text-blue-600">{{ $diproses }}</span>
                    </div>
                    <div class="p-4 bg-amber-50 rounded-2xl border border-amber-100">
                        <span class="text-xs font-semibold text-amber-800 uppercase block">Menunggu</span>
                        <span class="text-2xl font-black text-amber-600">{{ $menunggu }}</span>
                    </div>
                    <div class="p-4 bg-red-50 rounded-2xl border border-red-100">
                        <span class="text-xs font-semibold text-red-800 uppercase block">Ditolak</span>
                        <span class="text-2xl font-black text-red-600">{{ $ditolak }}</span>
                    </div>
                </div>

                <div class="pt-2 grid grid-cols-2 gap-4 text-xs">
                    <div class="p-3 bg-gray-50 rounded-xl flex items-center justify-between">
                        <span class="text-gray-600">Pemohon Perorangan:</span>
                        <span class="font-bold text-gray-900">{{ $perorangan }}</span>
                    </div>
                    <div class="p-3 bg-gray-50 rounded-xl flex items-center justify-between">
                        <span class="text-gray-600">Lembaga / Organisasi:</span>
                        <span class="font-bold text-gray-900">{{ $lembaga }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Layanan Inklusif Disabilitas, Kanal Layanan & Keberatan -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-2 bg-white rounded-3xl p-6 border border-blue-100 shadow-sm space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                    <div>
                        <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider flex items-center gap-2">
                            <span class="text-blue-600">♿</span> Layanan Inklusif & Ramah Disabilitas (Prioritas SPM)
                        </h3>
                        <p class="text-xs text-gray-400">Komitmen kesetaraan akses informasi bagi penyandang disabilitas tahun {{ $tahun }}.</p>
                    </div>
                    <span class="px-3 py-1 bg-blue-50 text-blue-800 border border-blue-200 rounded-full text-xs font-black">
                        {{ $totalDisabilitas }} Layanan Khusus
                    </span>
                </div>

                @if (!empty($ragamDisabilitas))
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @foreach ($ragamDisabilitas as $ragam => $jml)
                            <div class="p-3 bg-blue-50/60 border border-blue-100 rounded-xl flex items-center justify-between text-xs">
                                <span class="font-semibold text-blue-900">{{ $ragam }}</span>
                                <span class="px-2 py-0.5 bg-white text-blue-700 font-black rounded-lg border border-blue-200">{{ $jml }}</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="p-4 bg-gray-50 border border-dashed border-gray-200 rounded-2xl text-xs text-gray-500 text-center">
                        Belum ada catatan pengajuan khusus penyandang disabilitas pada tahun {{ $tahun }}. Fasilitas aksesibilitas digital & pendampingan tetap siap melayani setiap saat.
                    </div>
                @endif
            </div>

            <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm space-y-4">
                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider pb-3 border-b border-gray-100">Kanal & Keberatan</h3>
                <div class="space-y-3 text-xs">
                    <div class="p-3 bg-tosca-50 rounded-xl flex items-center justify-between">
                        <span class="font-semibold text-tosca-900">🌐 Permohonan Online</span>
                        <span class="text-base font-black text-tosca-700">{{ $onlineCount }}</span>
                    </div>
                    <div class="p-3 bg-purple-50 rounded-xl flex items-center justify-between">
                        <span class="font-semibold text-purple-900">🏢 Meja Layanan (Offline)</span>
                        <span class="text-base font-black text-purple-700">{{ $offlineCount }}</span>
                    </div>
                    <div class="p-3 bg-red-50 rounded-xl flex items-center justify-between">
                        <span class="font-semibold text-red-900">⚖️ Pengajuan Keberatan</span>
                        <span class="text-base font-black text-red-700">{{ $totalKeberatan }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grafik Tren Permohonan Per Bulan -->
        <div class="bg-white rounded-3xl p-6 md:p-8 border border-gray-100 shadow-sm space-y-6">
            <div>
                <h3 class="text-base font-bold text-gray-900">Grafik Permohonan Informasi per Bulan (Tahun {{ $tahun }})</h3>
                <p class="text-xs text-gray-400">Visualisasi jumlah permohonan yang masuk setiap bulannya.</p>
            </div>

            @php
                $namaBulan = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
                $maxVal = max(array_values($dataBulanan));
                if ($maxVal == 0) $maxVal = 1;
            @endphp

            <div class="grid grid-cols-12 gap-2 items-end h-48 pt-6 border-b border-gray-200">
                @for ($m = 1; $m <= 12; $m++)
                    @php
                        $val = $dataBulanan[$m];
                        $heightPercent = round(($val / $maxVal) * 100);
                        if ($heightPercent < 6 && $val > 0) $heightPercent = 6;
                    @endphp
                    <div class="flex flex-col items-center h-full justify-end group">
                        <span class="text-[10px] font-bold text-gray-600 mb-1 opacity-0 group-hover:opacity-100 transition-opacity">{{ $val }}</span>
                        <div class="w-full bg-tosca-500 rounded-t-lg transition-all duration-500 group-hover:bg-tosca-600"
                            style="height: {{ $val > 0 ? $heightPercent . '%' : '4px' }}; opacity: {{ $val > 0 ? '1' : '0.2' }}"></div>
                        <span class="text-[11px] text-gray-400 mt-2 font-medium">{{ $namaBulan[$m - 1] }}</span>
                    </div>
                @endfor
            </div>

            <!-- Call to Action Isi Survei -->
            <div class="p-6 bg-gradient-to-r from-tosca-50 to-emerald-50 border border-tosca-100 rounded-2xl flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h4 class="text-sm font-bold text-gray-900">Pernah mengajukan permohonan informasi?</h4>
                    <p class="text-xs text-gray-600 mt-0.5">Bantu kami terus berbenah dengan mengisi survei kepuasan masyarakat singkat.</p>
                </div>
                <a href="{{ route('survei.create') }}"
                    class="px-5 py-2.5 bg-tosca-600 hover:bg-tosca-700 text-white font-bold text-xs rounded-xl shadow transition-all shrink-0 text-center">
                    Isi Survei IKM Sekarang &rarr;
                </a>
            </div>
        </div>

    </div>
@endsection
