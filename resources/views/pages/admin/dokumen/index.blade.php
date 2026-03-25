@extends('layouts.admin')

@section('title', 'Kelola Dokumen - Admin PPID')

@section('content')
    <div class="max-w-7xl mx-auto space-y-6">

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-6 border-b border-gray-200">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-1">Kelola Dokumen Publik</h1>
                <p class="text-gray-500">Unggah file PDF Regulasi, SOP, dan SK untuk ditampilkan di website.</p>
            </div>
            <a href="{{ route('admin.dokumen.create') }}"
                class="px-5 py-2.5 bg-tosca-600 hover:bg-tosca-700 text-white font-semibold rounded-xl shadow-md transition-colors flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                </svg>
                Unggah Dokumen Baru
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-600">
                    <thead class="bg-gray-50 text-gray-800 border-b border-gray-200 uppercase text-xs tracking-wider">
                        <tr>
                            <th class="py-4 px-6 font-semibold text-center w-16">No</th>
                            <th class="py-4 px-6 font-semibold">Judul & Keterangan</th>
                            <th class="py-4 px-6 font-semibold">Kategori</th>
                            <th class="py-4 px-6 font-semibold text-center">Tahun</th>
                            <th class="py-4 px-6 font-semibold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">

                        @forelse ($dokumens as $index => $item)
                            <tr class="hover:bg-tosca-50/50 transition-colors">
                                <td class="py-4 px-6 text-center text-gray-500">{{ $index + 1 }}</td>

                                <td class="py-4 px-6">
                                    <div class="font-bold text-gray-900 text-base mb-1">{{ $item->judul }}</div>
                                    <div class="text-xs text-gray-500">{{ $item->keterangan ?? '-' }}</div>
                                </td>

                                <td class="py-4 px-6">
                                    @if ($item->kategori == 'regulasi')
                                        <span
                                            class="px-3 py-1 bg-tosca-100 text-tosca-700 text-xs font-bold rounded-full uppercase">Regulasi</span>
                                    @elseif($item->kategori == 'sop')
                                        <span
                                            class="px-3 py-1 bg-orange-100 text-orange-700 text-xs font-bold rounded-full uppercase">SOP</span>
                                    @else
                                        <span
                                            class="px-3 py-1 bg-blue-100 text-blue-700 text-xs font-bold rounded-full uppercase">SK</span>
                                    @endif
                                </td>

                                <td class="py-4 px-6 text-center font-bold text-gray-700">
                                    {{ $item->tahun }}
                                </td>

                                <td class="py-4 px-6 text-center space-y-2">
                                    <a href="{{ asset('storage/' . $item->file_pdf) }}" target="_blank"
                                        class="inline-flex items-center justify-center w-full px-3 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold rounded border border-gray-300 transition-colors">
                                        Cek PDF
                                    </a>
                                    <form action="{{ route('admin.dokumen.destroy', $item->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus dokumen ini? File PDF juga akan terhapus.');">
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
                                <td colspan="5" class="py-12 text-center text-gray-500">Belum ada dokumen yang diunggah.
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
