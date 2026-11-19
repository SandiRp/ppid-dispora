@extends('layouts.admin')

@section('title', 'Dashboard Admin - PPID Dispora Jatim')

@section('content')
    <div class="max-w-7xl mx-auto space-y-8">

        <!-- Welcome Banner -->
        <div class="bg-gradient-to-r from-teal-800 via-teal-700 to-tosca-600 rounded-3xl p-6 md:p-8 text-white shadow-lg relative overflow-hidden">
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-white/20 text-white backdrop-blur-sm mb-2">
                        Portal Manajemen PPID
                    </span>
                    <h1 class="text-2xl md:text-3xl font-black">Selamat Datang, {{ auth()->user()->name ?? 'Petugas PPID' }}!</h1>
                    <p class="text-teal-100 text-sm mt-1 max-w-xl">
                        Kelola permohonan informasi publik, pengajuan keberatan, dan konten publikasi Dinas Kepemudaan dan Olahraga Provinsi Jawa Timur.
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.permohonan.index') }}"
                        class="px-5 py-2.5 bg-white text-teal-800 hover:bg-teal-50 font-bold text-sm rounded-xl shadow transition-colors flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Buka Permohonan
                    </a>
                </div>
            </div>
            <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
        </div>

        <!-- 4 Kotak Statistik Utama Permohonan -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <!-- Total Permohonan -->
            <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm flex items-center gap-4">
                <div class="w-13 h-13 bg-tosca-50 text-tosca-600 rounded-2xl flex items-center justify-center p-3">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div>
                    <span class="text-xs uppercase font-bold text-gray-400">Total Permohonan</span>
                    <h3 class="text-2xl font-black text-gray-900">{{ $totalPermohonan }}</h3>
                </div>
            </div>

            <!-- Menunggu Tindak Lanjut -->
            <div class="bg-white rounded-2xl p-5 border border-amber-100 shadow-sm flex items-center gap-4">
                <div class="w-13 h-13 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center p-3">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <span class="text-xs uppercase font-bold text-amber-600">Menunggu Verifikasi</span>
                    <h3 class="text-2xl font-black text-gray-900">{{ $permohonanMenunggu }}</h3>
                </div>
            </div>

            <!-- Sedang Diproses -->
            <div class="bg-white rounded-2xl p-5 border border-blue-100 shadow-sm flex items-center gap-4">
                <div class="w-13 h-13 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center p-3">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                </div>
                <div>
                    <span class="text-xs uppercase font-bold text-blue-600">Sedang Diproses</span>
                    <h3 class="text-2xl font-black text-gray-900">{{ $permohonanDiproses }}</h3>
                </div>
            </div>

            <!-- Selesai Diberikan -->
            <div class="bg-white rounded-2xl p-5 border border-emerald-100 shadow-sm flex items-center gap-4">
                <div class="w-13 h-13 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center p-3">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <span class="text-xs uppercase font-bold text-emerald-600">Selesai / Terjawab</span>
                    <h3 class="text-2xl font-black text-gray-900">{{ $permohonanSelesai }}</h3>
                </div>
            </div>
        </div>

        <!-- Peringatan Batas Waktu SLA Otomatis (UU KIP) -->
        @if ($permohonanLewatSla->count() > 0 || $permohonanMendekatiSla->count() > 0)
            <div class="space-y-3">
                @if ($permohonanLewatSla->count() > 0)
                    <div class="p-4 bg-red-50 border-l-4 border-red-500 rounded-2xl flex items-center justify-between gap-4 shadow-sm">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-red-100 text-red-600 flex items-center justify-center shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-red-900">Perhatian: {{ $permohonanLewatSla->count() }} Permohonan Melewati Batas Waktu SLA!</h4>
                                <p class="text-xs text-red-700 mt-0.5">Permohonan ini telah melebihi standar waktu pelayanan (10 hari kerja). Segera berikan tanggapan resmi atau lakukan perpanjangan waktu 7 hari kerja.</p>
                            </div>
                        </div>
                        <a href="{{ route('admin.permohonan.index') }}" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-bold text-xs rounded-xl whitespace-nowrap shadow-sm transition-colors">
                            Tindak Lanjuti Sekarang &rarr;
                        </a>
                    </div>
                @endif

                @if ($permohonanMendekatiSla->count() > 0)
                    <div class="p-4 bg-amber-50 border-l-4 border-amber-500 rounded-2xl flex items-center justify-between gap-4 shadow-sm">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-amber-900">Peringatan: {{ $permohonanMendekatiSla->count() }} Permohonan Mendekati Jatuh Tempo SLA</h4>
                                <p class="text-xs text-amber-800 mt-0.5">Tersisa &le; 3 hari kerja sebelum batas waktu pelayanan berakhir.</p>
                            </div>
                        </div>
                        <a href="{{ route('admin.permohonan.index') }}" class="px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white font-bold text-xs rounded-xl whitespace-nowrap shadow-sm transition-colors">
                            Lihat Daftar &rarr;
                        </a>
                    </div>
                @endif
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Tabel Permohonan Terbaru & Status SLA -->
            <div class="lg:col-span-2 bg-white rounded-2xl p-6 border border-gray-100 shadow-sm space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                    <div>
                        <h2 class="text-base font-bold text-gray-900">Permohonan Terbaru & Tenggat Waktu (SLA)</h2>
                        <p class="text-xs text-gray-500">Pantau batas waktu 10 hari kerja sesuai UU KIP.</p>
                    </div>
                    <a href="{{ route('admin.permohonan.index') }}" class="text-xs font-bold text-tosca-600 hover:underline">
                        Lihat Semua &rarr;
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-gray-600">
                        <thead class="bg-gray-50 text-gray-700 uppercase font-semibold">
                            <tr>
                                <th class="py-2.5 px-3">No. Reg</th>
                                <th class="py-2.5 px-3">Pemohon</th>
                                <th class="py-2.5 px-3 text-center">Status</th>
                                <th class="py-2.5 px-3 text-center">SLA Waktu</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($permohonanTerbaru as $item)
                                @php $sla = $item->sla_info; @endphp
                                <tr class="hover:bg-gray-50/50">
                                    <td class="py-3 px-3 font-mono font-bold text-tosca-700">
                                        {{ $item->nomor_registrasi ?? ('ID #' . $item->id) }}
                                        <span class="block font-normal text-[11px] text-gray-400">{{ $item->created_at->format('d M Y') }}</span>
                                    </td>
                                    <td class="py-3 px-3">
                                        <div class="font-bold text-gray-800">{{ $item->nama_lengkap }}</div>
                                        <div class="text-[11px] text-gray-400 truncate max-w-[180px]">{{ $item->rincian_informasi }}</div>
                                    </td>
                                    <td class="py-3 px-3 text-center">
                                        @if ($item->status == 'menunggu')
                                            <span class="px-2 py-0.5 rounded text-[11px] font-semibold bg-amber-100 text-amber-800">Menunggu</span>
                                        @elseif ($item->status == 'diproses')
                                            <span class="px-2 py-0.5 rounded text-[11px] font-semibold bg-blue-100 text-blue-800">Diproses</span>
                                        @elseif ($item->status == 'selesai')
                                            <span class="px-2 py-0.5 rounded text-[11px] font-semibold bg-emerald-100 text-emerald-800">Selesai</span>
                                        @else
                                            <span class="px-2 py-0.5 rounded text-[11px] font-semibold bg-red-100 text-red-800">Ditolak</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-3 text-center">
                                        @if ($sla['status_sla'] === 'expired')
                                            <span class="px-2 py-0.5 rounded font-bold text-[11px] bg-red-100 text-red-700 animate-pulse">
                                                ⚠️ {{ $sla['label'] }}
                                            </span>
                                        @elseif ($sla['status_sla'] === 'warning')
                                            <span class="px-2 py-0.5 rounded font-bold text-[11px] bg-amber-100 text-amber-800">
                                                ⏱️ {{ $sla['label'] }}
                                            </span>
                                        @else
                                            <span class="px-2 py-0.5 rounded text-[11px] text-gray-600 bg-gray-100">
                                                {{ $sla['label'] }}
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-6 text-center text-gray-400">Belum ada permohonan masuk.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Ringkasan Konten & Keberatan -->
            <div class="space-y-6">
                <!-- Box Keberatan -->
                <div class="bg-white rounded-2xl p-5 border border-red-100 shadow-sm space-y-3">
                    <div class="flex items-center justify-between">
                        <h3 class="text-sm font-bold text-gray-900 flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-red-600"></span>
                            Pengajuan Keberatan
                        </h3>
                        <a href="{{ route('admin.keberatan.index') }}" class="text-xs font-semibold text-red-600 hover:underline">Kelola &rarr;</a>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-red-50/50 rounded-xl">
                        <span class="text-xs text-red-800 font-medium">Perlu Tanggapan Atasan PPID:</span>
                        <span class="text-lg font-black text-red-700">{{ $keberatanMenunggu }}</span>
                    </div>
                </div>

                <!-- Box Rekap Data Konten -->
                <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm space-y-3">
                    <h3 class="text-sm font-bold text-gray-900 pb-2 border-b border-gray-100">Kelola Publikasi & Konten</h3>
                    <div class="space-y-2 text-xs">
                        <div class="flex items-center justify-between p-2 hover:bg-gray-50 rounded-lg">
                            <span class="text-gray-600 font-medium">Berita & Informasi Publik</span>
                            <span class="font-bold text-gray-900">{{ $totalBerita }}</span>
                        </div>
                        <div class="flex items-center justify-between p-2 hover:bg-gray-50 rounded-lg">
                            <span class="text-gray-600 font-medium">Dokumen Regulasi, SK & SOP</span>
                            <span class="font-bold text-gray-900">{{ $totalDokumen }}</span>
                        </div>
                        <div class="flex items-center justify-between p-2 hover:bg-gray-50 rounded-lg">
                            <span class="text-gray-600 font-medium">Daftar Informasi Publik (DIP)</span>
                            <span class="font-bold text-gray-900">{{ $totalInformasi }}</span>
                        </div>
                        <div class="flex items-center justify-between p-2 hover:bg-gray-50 rounded-lg">
                            <span class="text-gray-600 font-medium">Dokumen Laporan PPID</span>
                            <span class="font-bold text-gray-900">{{ $totalLaporan }}</span>
                        </div>
                        <div class="flex items-center justify-between p-2 hover:bg-gray-50 rounded-lg">
                            <span class="text-gray-600 font-medium">Agenda Kegiatan</span>
                            <span class="font-bold text-gray-900">{{ $totalAgenda }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Audit Log Aktivitas Terbaru -->
        <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                <div>
                    <h2 class="text-base font-bold text-gray-900">Aktivitas & Jejak Audit Petugas (Audit Log)</h2>
                    <p class="text-xs text-gray-500">Catatan aktivitas perubahan data dan penanganan permohonan.</p>
                </div>
                <a href="{{ route('admin.audit-logs.index') }}" class="text-xs font-bold text-tosca-600 hover:underline">
                    Buka Semua Log &rarr;
                </a>
            </div>

            <div class="space-y-3">
                @forelse ($aktivitasTerbaru as $log)
                    <div class="flex items-start gap-3 p-3 bg-gray-50/70 hover:bg-gray-50 rounded-xl transition-colors text-xs">
                        <span class="px-2 py-0.5 rounded font-mono font-bold uppercase text-[10px] {{ $log->action === 'CREATE' ? 'bg-emerald-100 text-emerald-800' : ($log->action === 'STATUS_CHANGE' ? 'bg-amber-100 text-amber-800' : ($log->action === 'DELETE' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800')) }}">
                            {{ $log->action }}
                        </span>
                        <div class="flex-1">
                            <p class="text-gray-800 font-medium">{{ $log->description }}</p>
                            <span class="text-[11px] text-gray-400 mt-0.5 block">
                                Oleh: <strong class="text-gray-600">{{ $log->user_name }}</strong> &bull; Modul: <strong class="capitalize text-gray-600">{{ $log->module }}</strong> &bull; {{ $log->created_at->diffForHumans() }}
                            </span>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-xs text-gray-400 py-4">Belum ada catatan log aktivitas.</p>
                @endforelse
            </div>
        </div>

    </div>
@endsection
