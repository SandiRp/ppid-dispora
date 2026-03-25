@extends('layouts.admin')

@section('title', 'Admin - Kelola Permohonan Informasi')

@section('content')
    <div class="max-w-7xl mx-auto space-y-6">

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-6 border-b border-gray-200">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-1">Kelola Permohonan Informasi</h1>
                <p class="text-gray-500">Panel admin PPID untuk memantau dan memproses permintaan data publik.</p>
            </div>
            <div
                class="bg-white px-4 py-2 rounded-xl shadow-sm border border-gray-200 font-semibold text-tosca-700 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                    </path>
                </svg>
                Total: {{ $permohonans->count() }} Masuk
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-600">
                    <thead class="bg-gray-50 text-gray-800 border-b border-gray-200 uppercase text-xs tracking-wider">
                        <tr>
                            <th class="py-4 px-6 font-semibold text-center w-16">No</th>
                            <th class="py-4 px-6 font-semibold">Tanggal Masuk</th>
                            <th class="py-4 px-6 font-semibold">Pemohon</th>
                            <th class="py-4 px-6 font-semibold">Rincian & Tujuan</th>
                            <th class="py-4 px-6 font-semibold text-center">Status</th>
                            <th class="py-4 px-6 font-semibold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">

                        @forelse ($permohonans as $index => $item)
                            <tr class="hover:bg-tosca-50/50 transition-colors">
                                <td class="py-4 px-6 text-center text-gray-500">{{ $index + 1 }}</td>

                                <td class="py-4 px-6 whitespace-nowrap">
                                    <span
                                        class="font-medium text-gray-800">{{ $item->created_at->format('d M Y') }}</span><br>
                                    <span class="text-xs text-gray-400">{{ $item->created_at->format('H:i') }} WIB</span>
                                </td>

                                <td class="py-4 px-6">
                                    <div class="font-bold text-gray-900">{{ $item->nama_lengkap }}</div>
                                    <div class="text-xs text-gray-500 mb-1 uppercase tracking-wide">{{ $item->kategori }}
                                    </div>
                                    <div class="text-xs text-gray-400">NIK: {{ $item->nik_identitas }}</div>
                                    <div class="text-xs text-gray-400">{{ $item->email }}</div>
                                </td>

                                <td class="py-4 px-6 min-w-[250px]">
                                    <div class="mb-2">
                                        <span class="text-xs font-bold text-gray-700 uppercase">Informasi:</span>
                                        <p class="text-sm line-clamp-2" title="{{ $item->rincian_informasi }}">
                                            {{ $item->rincian_informasi }}</p>
                                    </div>
                                    <div>
                                        <span class="text-xs font-bold text-gray-700 uppercase">Tujuan:</span>
                                        <p class="text-sm text-gray-500 line-clamp-1"
                                            title="{{ $item->tujuan_penggunaan }}">{{ $item->tujuan_penggunaan }}</p>
                                    </div>
                                </td>

                                <td class="py-4 px-6 text-center">
                                    @if ($item->status == 'menunggu')
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 border border-yellow-200">Menunggu</span>
                                    @elseif($item->status == 'diproses')
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 border border-blue-200">Diproses</span>
                                    @elseif($item->status == 'selesai')
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">Selesai</span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 border border-red-200">Ditolak</span>
                                    @endif
                                </td>

                                <td class="py-4 px-6 text-center space-y-2">
                                    @if ($item->file_pendukung)
                                        <a href="{{ asset('storage/' . $item->file_pendukung) }}" target="_blank"
                                            class="inline-flex items-center justify-center w-full px-3 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold rounded border border-gray-300 transition-colors">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13">
                                                </path>
                                            </svg>
                                            Cek Berkas
                                        </a>
                                    @else
                                        <span class="text-xs text-red-400 italic">Tidak ada berkas</span>
                                    @endif

                                    <form action="{{ route('admin.permohonan.update-status', $item->id) }}" method="POST"
                                        class="mt-2">
                                        @csrf
                                        @method('PUT') <select name="status" onchange="this.form.submit()"
                                            class="w-full px-2 py-1.5 bg-gray-50 hover:bg-white border border-gray-200 text-gray-700 text-xs font-semibold rounded focus:ring-2 focus:ring-tosca-500 outline-none cursor-pointer transition-all">
                                            <option value="menunggu" {{ $item->status == 'menunggu' ? 'selected' : '' }}>⏳
                                                Menunggu</option>
                                            <option value="diproses" {{ $item->status == 'diproses' ? 'selected' : '' }}>⚙️
                                                Diproses</option>
                                            <option value="selesai" {{ $item->status == 'selesai' ? 'selected' : '' }}>✅
                                                Selesai</option>
                                            <option value="ditolak" {{ $item->status == 'ditolak' ? 'selected' : '' }}>❌
                                                Ditolak</option>
                                        </select>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center text-gray-500">
                                    <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                                        </path>
                                    </svg>
                                    Belum ada permohonan informasi yang masuk.
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
        document.addEventListener("DOMContentLoaded", function() {
            @if (session('success'))
                Swal.fire({
                    title: "Berhasil Diperbarui!",
                    text: "{!! session('success') !!}",
                    icon: "success",
                    confirmButtonText: "Tutup",
                    confirmButtonColor: "#14b8a6", // Warna tosca
                    timer: 3000 // Otomatis menutup dalam 3 detik
                });
            @endif
        });
    </script>
@endsection
