@extends('layouts.admin')

@section('title', 'Jejak Audit Aktivitas (Audit Log) - Admin PPID')

@section('content')
    <div class="max-w-7xl mx-auto space-y-6">

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-6 border-b border-gray-200">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-1">Jejak Audit Aktivitas (Audit Log)</h1>
                <p class="text-gray-500">Rekam jejak setiap aksi pembuatan, pengubahan, pembaruan status, dan penghapusan data.</p>
            </div>
            <div class="px-4 py-2 bg-gray-100 text-gray-700 font-semibold rounded-xl text-sm">
                Total: {{ $logs->total() }} Catatan Aktivitas
            </div>
        </div>

        <!-- Filter & Search Bar -->
        <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-sm">
            <form action="{{ route('admin.audit-logs.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 text-xs">
                <div>
                    <label class="block font-semibold text-gray-700 mb-1">Cari Keterangan / Petugas</label>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari..."
                        class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white focus:ring-2 focus:ring-tosca-500 outline-none">
                </div>

                <div>
                    <label class="block font-semibold text-gray-700 mb-1">Filter Modul</label>
                    <select name="module" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white outline-none">
                        <option value="">-- Semua Modul --</option>
                        <option value="permohonan" {{ request('module') == 'permohonan' ? 'selected' : '' }}>Permohonan</option>
                        <option value="keberatan" {{ request('module') == 'keberatan' ? 'selected' : '' }}>Keberatan</option>
                        <option value="berita" {{ request('module') == 'berita' ? 'selected' : '' }}>Berita</option>
                        <option value="dokumen" {{ request('module') == 'dokumen' ? 'selected' : '' }}>Dokumen</option>
                        <option value="informasi" {{ request('module') == 'informasi' ? 'selected' : '' }}>Informasi Publik</option>
                        <option value="laporan" {{ request('module') == 'laporan' ? 'selected' : '' }}>Laporan</option>
                        <option value="agenda" {{ request('module') == 'agenda' ? 'selected' : '' }}>Agenda</option>
                        <option value="user" {{ request('module') == 'user' ? 'selected' : '' }}>Pengguna</option>
                    </select>
                </div>

                <div>
                    <label class="block font-semibold text-gray-700 mb-1">Filter Aksi</label>
                    <select name="action" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:bg-white outline-none">
                        <option value="">-- Semua Aksi --</option>
                        <option value="CREATE" {{ request('action') == 'CREATE' ? 'selected' : '' }}>CREATE</option>
                        <option value="UPDATE" {{ request('action') == 'UPDATE' ? 'selected' : '' }}>UPDATE</option>
                        <option value="STATUS_CHANGE" {{ request('action') == 'STATUS_CHANGE' ? 'selected' : '' }}>STATUS_CHANGE</option>
                        <option value="DELETE" {{ request('action') == 'DELETE' ? 'selected' : '' }}>DELETE</option>
                    </select>
                </div>

                <div class="flex items-end gap-2">
                    <button type="submit"
                        class="px-5 py-2 bg-tosca-600 hover:bg-tosca-700 text-white font-bold rounded-lg shadow-sm transition-colors w-full">
                        Filter
                    </button>
                    @if (request()->hasAny(['q', 'module', 'action']))
                        <a href="{{ route('admin.audit-logs.index') }}"
                            class="px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-lg text-center font-medium">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Tabel Log -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-gray-600">
                    <thead class="bg-gray-50 text-gray-800 border-b border-gray-200 uppercase tracking-wider font-semibold">
                        <tr>
                            <th class="py-3 px-4 w-12 text-center">No</th>
                            <th class="py-3 px-4">Waktu</th>
                            <th class="py-3 px-4">Petugas</th>
                            <th class="py-3 px-4 text-center">Aksi</th>
                            <th class="py-3 px-4">Modul</th>
                            <th class="py-3 px-4">Keterangan Aktivitas</th>
                            <th class="py-3 px-4">IP Address</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($logs as $index => $log)
                            <tr class="hover:bg-gray-50/50">
                                <td class="py-3 px-4 text-center text-gray-400">{{ $logs->firstItem() + $index }}</td>
                                <td class="py-3 px-4 whitespace-nowrap text-gray-500 font-mono">
                                    {{ $log->created_at->format('d/m/Y H:i:s') }}
                                </td>
                                <td class="py-3 px-4 font-bold text-gray-800 whitespace-nowrap">
                                    {{ $log->user_name }}
                                </td>
                                <td class="py-3 px-4 text-center whitespace-nowrap">
                                    <span class="px-2 py-0.5 rounded font-mono font-bold text-[10px] {{ $log->action === 'CREATE' ? 'bg-emerald-100 text-emerald-800' : ($log->action === 'STATUS_CHANGE' ? 'bg-amber-100 text-amber-800' : ($log->action === 'DELETE' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800')) }}">
                                        {{ $log->action }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 uppercase font-bold text-gray-600">
                                    {{ $log->module }}
                                </td>
                                <td class="py-3 px-4 text-gray-800 max-w-[360px] break-words">
                                    {{ $log->description }}
                                </td>
                                <td class="py-3 px-4 font-mono text-gray-400 whitespace-nowrap">
                                    {{ $log->ip_address ?? '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-12 text-center text-gray-400">Belum ada catatan log aktivitas yang sesuai.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($logs->hasPages())
                <div class="p-4 border-t border-gray-100">
                    {{ $logs->links() }}
                </div>
            @endif
        </div>

    </div>
@endsection
