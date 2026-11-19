@extends('layouts.admin')

@section('title', 'Kelola Agenda - Admin PPID')

@section('content')
    <div class="max-w-7xl mx-auto space-y-6">

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-6 border-b border-gray-200">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-1">Kelola Agenda Kegiatan</h1>
                <p class="text-gray-500">Atur jadwal rapat, evaluasi, dan kegiatan PPID Dispora Jatim.</p>
            </div>
            <a href="{{ route('admin.agenda.create') }}"
                class="px-5 py-2.5 bg-tosca-600 hover:bg-tosca-700 text-white font-semibold rounded-xl shadow-md transition-colors flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                Tambah Agenda Baru
            </a>
        </div>

        <!-- Filter & Search Bar -->
        <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm">
            <form action="{{ route('admin.agenda.index') }}" method="GET" class="flex items-center gap-3">
                <input type="text" name="q" value="{{ request('q') }}"
                    placeholder="Cari judul, lokasi, atau deskripsi agenda kegiatan..."
                    class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:bg-white focus:ring-2 focus:ring-tosca-500 outline-none">
                <button type="submit" class="px-5 py-2 bg-gray-800 hover:bg-gray-900 text-white font-bold text-xs rounded-xl transition-colors whitespace-nowrap">
                    Cari Agenda
                </button>
                @if (request()->filled('q'))
                    <a href="{{ route('admin.agenda.index') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 text-xs font-bold rounded-xl transition-colors">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-600">
                    <thead class="bg-gray-50 text-gray-800 border-b border-gray-200 uppercase text-xs tracking-wider">
                        <tr>
                            <th class="py-4 px-6 font-semibold text-center w-16">No</th>
                            <th class="py-4 px-6 font-semibold">Tanggal & Waktu</th>
                            <th class="py-4 px-6 font-semibold">Judul & Lokasi</th>
                            <th class="py-4 px-6 font-semibold">Deskripsi</th>
                            <th class="py-4 px-6 font-semibold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($agendas as $index => $item)
                            <tr class="hover:bg-tosca-50/50 transition-colors">
                                <td class="py-4 px-6 text-center text-gray-500">{{ $index + 1 }}</td>

                                <td class="py-4 px-6 whitespace-nowrap">
                                    <div class="font-bold text-gray-900 mb-1">
                                        {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d M Y') }}
                                    </div>
                                    @if ($item->waktu_mulai)
                                        <div class="text-xs text-gray-500">
                                            {{ \Carbon\Carbon::parse($item->waktu_mulai)->format('H:i') }} -
                                            {{ $item->waktu_selesai ? \Carbon\Carbon::parse($item->waktu_selesai)->format('H:i') : 'Selesai' }}
                                            WIB
                                        </div>
                                    @endif
                                </td>

                                <td class="py-4 px-6">
                                    <div class="font-bold text-gray-800 text-base mb-1">{{ $item->judul }}</div>
                                    <div class="text-xs text-tosca-600 flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                            </path>
                                        </svg>
                                        {{ $item->lokasi ?? 'Tidak ada lokasi' }}
                                    </div>
                                </td>

                                <td class="py-4 px-6">
                                    <p class="text-xs text-gray-500 line-clamp-2" title="{{ $item->deskripsi }}">
                                        {{ $item->deskripsi }}</p>
                                </td>

                                <td class="py-4 px-6 text-center">
                                    <div class="flex items-center justify-center gap-1">
                                        <a href="{{ route('admin.agenda.edit', $item->id) }}"
                                            class="inline-flex items-center justify-center px-2 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-600 text-xs font-semibold rounded border border-blue-200 transition-colors"
                                            title="Edit Agenda">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.agenda.destroy', $item->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus agenda kegiatan ini?');"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center justify-center px-2 py-1.5 bg-red-50 hover:bg-red-500 hover:text-white text-red-600 text-xs font-semibold rounded border border-red-200 transition-colors">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-12 text-center text-gray-500">Belum ada agenda kegiatan yang
                                    dijadwalkan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($agendas->hasPages())
                <div class="p-4 border-t border-gray-100">
                    {{ $agendas->links() }}
                </div>
            @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if (session('success'))
            Swal.fire({
                title: "Berhasil!",
                text: @json(session('success')),
                icon: "success",
                confirmButtonColor: "#14b8a6",
                timer: 3000
            });
        @endif
    </script>
@endsection
