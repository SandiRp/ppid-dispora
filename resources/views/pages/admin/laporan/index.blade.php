@extends('layouts.admin')

@section('title', 'Kelola Laporan - Admin PPID')

@section('content')
    <div class="max-w-7xl mx-auto space-y-6">

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-6 border-b border-gray-200">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-1">Kelola Laporan PPID</h1>
                <p class="text-gray-500">Unggah Laporan Layanan Informasi dan Laporan Pelayanan Publik Tahunan.</p>
            </div>
            <a href="{{ route('admin.laporan.create') }}"
                class="px-5 py-2.5 bg-tosca-600 hover:bg-tosca-700 text-white font-semibold rounded-xl shadow-md transition-colors flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Unggah Laporan Baru
            </a>
        </div>

        <!-- Filter & Search Bar -->
        <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm">
            <form action="{{ route('admin.laporan.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <input type="text" name="q" value="{{ request('q') }}"
                    placeholder="Cari judul, tahun, atau deskripsi laporan..."
                    class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:bg-white focus:ring-2 focus:ring-tosca-500 outline-none">
                <select name="kategori" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:bg-white focus:ring-2 focus:ring-tosca-500 outline-none">
                    <option value="">-- Semua Kategori --</option>
                    <option value="akses" {{ request('kategori') == 'akses' ? 'selected' : '' }}>Akses Informasi</option>
                    <option value="pelayanan" {{ request('kategori') == 'pelayanan' ? 'selected' : '' }}>Pelayanan Publik</option>
                </select>
                <div class="flex items-center gap-2">
                    <button type="submit" class="w-full py-2 bg-gray-800 hover:bg-gray-900 text-white font-bold text-xs rounded-xl transition-colors">
                        Filter Laporan
                    </button>
                    @if (request()->hasAny(['q', 'kategori']))
                        <a href="{{ route('admin.laporan.index') }}" class="px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 text-xs font-bold rounded-xl transition-colors">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-600">
                    <thead class="bg-gray-50 text-gray-800 border-b border-gray-200 uppercase text-xs tracking-wider">
                        <tr>
                            <th class="py-4 px-6 font-semibold text-center w-16">No</th>
                            <th class="py-4 px-6 font-semibold">Judul Laporan</th>
                            <th class="py-4 px-6 font-semibold text-center">Kategori</th>
                            <th class="py-4 px-6 font-semibold text-center">Tahun</th>
                            <th class="py-4 px-6 font-semibold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($laporans as $index => $item)
                            <tr class="hover:bg-tosca-50/50 transition-colors">
                                <td class="py-4 px-6 text-center text-gray-500">{{ $index + 1 }}</td>
                                <td class="py-4 px-6">
                                    <div class="font-bold text-gray-900 mb-1">{{ $item->judul }}</div>
                                    <div class="text-xs text-gray-500 line-clamp-1">{{ $item->deskripsi ?? '-' }}</div>
                                </td>
                                <td class="py-4 px-6 text-center">
                                    @if ($item->kategori == 'akses')
                                        <span
                                            class="px-3 py-1 bg-tosca-100 text-tosca-700 text-xs font-bold rounded-full uppercase">Akses
                                            Informasi</span>
                                    @else
                                        <span
                                            class="px-3 py-1 bg-blue-100 text-blue-700 text-xs font-bold rounded-full uppercase">Pelayanan
                                            Publik</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-center font-bold text-gray-800">{{ $item->tahun }}</td>
                                <td class="py-4 px-6 text-center space-y-2">
                                    <div class="flex items-center justify-center gap-1">
                                        <a href="{{ asset('storage/' . $item->file_pdf) }}" target="_blank"
                                            class="inline-flex items-center justify-center px-2 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold rounded border border-gray-300 transition-colors"
                                            title="Cek PDF">
                                            Cek PDF
                                        </a>
                                        <a href="{{ route('admin.laporan.edit', $item->id) }}"
                                            class="inline-flex items-center justify-center px-2 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-600 text-xs font-semibold rounded border border-blue-200 transition-colors"
                                            title="Edit Laporan">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.laporan.destroy', $item->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus laporan tahun {{ $item->tahun }} ini?');"
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
                                <td colspan="5" class="py-12 text-center text-gray-500">Belum ada dokumen laporan yang
                                    diunggah.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($laporans->hasPages())
                <div class="p-4 border-t border-gray-100">
                    {{ $laporans->links() }}
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
