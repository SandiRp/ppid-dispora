@extends('layouts.admin')

@section('title', 'Kelola Daftar Informasi - Admin PPID')

@section('content')
    <div class="max-w-7xl mx-auto space-y-6">

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-6 border-b border-gray-200">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-1">Kelola Daftar Informasi Publik</h1>
                <p class="text-gray-500">Atur data informasi Berkala, Serta Merta, Setiap Saat, dan Dikecualikan.</p>
            </div>
            <a href="{{ route('admin.informasi.create') }}"
                class="px-5 py-2.5 bg-tosca-600 hover:bg-tosca-700 text-white font-semibold rounded-xl shadow-md transition-colors flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Informasi
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-600">
                    <thead class="bg-gray-50 text-gray-800 border-b border-gray-200 uppercase text-xs tracking-wider">
                        <tr>
                            <th class="py-4 px-6 font-semibold text-center w-16">No</th>
                            <th class="py-4 px-6 font-semibold">Ringkasan Informasi</th>
                            <th class="py-4 px-6 font-semibold text-center">Kategori</th>
                            <th class="py-4 px-6 font-semibold text-center">Tahun</th>
                            <th class="py-4 px-6 font-semibold text-center">Format</th>
                            <th class="py-4 px-6 font-semibold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($informasis as $index => $item)
                            <tr class="hover:bg-tosca-50/50 transition-colors">
                                <td class="py-4 px-6 text-center text-gray-500">{{ $index + 1 }}</td>
                                <td class="py-4 px-6">
                                    <div class="font-bold text-gray-900 mb-1">{{ $item->ringkasan_informasi }}</div>
                                    <div class="text-xs text-gray-500">{{ $item->penanggung_jawab }}</div>
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <span
                                        class="px-3 py-1 bg-gray-100 text-gray-700 text-xs font-bold rounded-full uppercase">
                                        {{ str_replace('_', ' ', $item->kategori) }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-center font-bold">{{ $item->tahun }}</td>
                                <td class="py-4 px-6 text-center">
                                    <span class="font-semibold text-xs border px-2 py-1 rounded">{{ $item->format }}</span>
                                </td>
                                <td class="py-4 px-6 text-center space-y-2">
                                    @if ($item->file_dokumen)
                                        <a href="{{ asset('storage/' . $item->file_dokumen) }}" target="_blank"
                                            class="inline-flex items-center justify-center w-full px-3 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold rounded border border-gray-300 transition-colors">
                                            Cek File
                                        </a>
                                    @endif
                                    <form action="{{ route('admin.informasi.destroy', $item->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus data ini?');">
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
                                <td colspan="6" class="py-12 text-center text-gray-500">Belum ada data informasi publik.
                                </td>
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
