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
                                    <a href="{{ asset('storage/' . $item->file_pdf) }}" target="_blank"
                                        class="inline-flex items-center justify-center w-full px-3 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold rounded border border-gray-300 transition-colors">
                                        Cek PDF
                                    </a>
                                    <form action="{{ route('admin.laporan.destroy', $item->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus laporan tahun {{ $item->tahun }} ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center justify-center w-full px-3 py-1.5 bg-red-50 hover:bg-red-500 hover:text-white text-red-600 text-xs font-semibold rounded border border-red-200 transition-colors mt-1">
                                            Hapus
                                        </button>
                                    </form>
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
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if (session('success'))
            Swal.fire({
                title: "Berhasil!",
                text: "{!! session('success') !!}",
                icon: "success",
                confirmButtonColor: "#14b8a6",
                timer: 3000
            });
        @endif
    </script>
@endsection
