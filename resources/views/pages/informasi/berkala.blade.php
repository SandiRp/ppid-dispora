@extends('layouts.app')

@section('title', 'Informasi Berkala - PPID Dispora Jatim')

@section('content')
    <div class="max-w-7xl mx-auto space-y-6">

        <div class="pb-6 border-b border-gray-200 flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Informasi Berkala</h1>
                <p class="text-gray-500">Informasi yang wajib disediakan dan diumumkan secara berkala (rutin).</p>
            </div>
        </div>

        <div
            class="flex flex-col sm:flex-row justify-between items-center gap-4 bg-white p-4 rounded-2xl shadow-sm border border-gray-100">
            <div class="relative w-full sm:w-96">
                <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 w-5 h-5" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <input type="text" placeholder="Cari informasi berkala..."
                    class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-tosca-500 focus:border-tosca-500 outline-none transition-all">
            </div>
            <div class="flex gap-2 w-full sm:w-auto">
                <select
                    class="w-full sm:w-auto px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-tosca-500 outline-none bg-gray-50 text-gray-700">
                    <option value="">Semua Tahun</option>
                    <option value="2026">2026</option>
                    <option value="2025">2025</option>
                </select>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-600">
                    <thead class="bg-tosca-50/50 text-tosca-800 border-b border-gray-200">
                        <tr>
                            <th class="py-4 px-6 font-semibold w-16 text-center">No</th>
                            <th class="py-4 px-6 font-semibold">Ringkasan Informasi</th>
                            <th class="py-4 px-6 font-semibold">Penanggung Jawab</th>
                            <th class="py-4 px-6 font-semibold">Tahun</th>
                            <th class="py-4 px-6 font-semibold text-center">Format</th>
                            <th class="py-4 px-6 font-semibold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($informasis as $index => $item)
                            <tr class="hover:bg-gray-50 transition-colors group">
                                <td class="py-4 px-6 text-center text-gray-400 group-hover:text-gray-900">
                                    {{ $index + 1 }}</td>
                                <td class="py-4 px-6">
                                    <p class="font-bold text-gray-800 mb-1">{{ $item->ringkasan_informasi }}</p>
                                    <p class="text-xs text-gray-500 line-clamp-1">{{ $item->deskripsi }}</p>
                                </td>
                                <td class="py-4 px-6 text-gray-700">{{ $item->penanggung_jawab }}</td>
                                <td class="py-4 px-6 font-semibold text-gray-700">{{ $item->tahun }}</td>
                                <td class="py-4 px-6 text-center">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                {{ strtoupper($item->format) == 'PDF'
                                    ? 'bg-red-100 text-red-800'
                                    : (strtoupper($item->format) == 'XLSX' || strtoupper($item->format) == 'EXCEL'
                                        ? 'bg-green-100 text-green-800'
                                        : 'bg-blue-100 text-blue-800') }}">
                                        {{ strtoupper($item->format) }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-center">
                                    @if ($item->file_dokumen)
                                        <a href="{{ asset('storage/' . $item->file_dokumen) }}" target="_blank"
                                            class="inline-block text-tosca-600 hover:text-white hover:bg-tosca-600 border border-tosca-600 p-2 rounded-lg transition-all"
                                            title="Unduh Dokumen">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4">
                                                </path>
                                            </svg>
                                        </a>
                                    @else
                                        <span class="text-xs text-gray-400 italic">Belum ada file</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-10 text-center text-gray-500 italic">Belum ada data informasi
                                    berkala yang dipublikasikan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50 flex items-center justify-between">
                <span class="text-sm text-gray-500">Menampilkan 1 hingga 2 dari 24 entri</span>
                <div class="flex gap-1">
                    <button
                        class="px-3 py-1 border border-gray-200 rounded-md text-gray-500 hover:bg-gray-100 text-sm">Sebelumnya</button>
                    <button class="px-3 py-1 bg-tosca-600 border border-tosca-600 rounded-md text-white text-sm">1</button>
                    <button
                        class="px-3 py-1 border border-gray-200 rounded-md text-gray-500 hover:bg-gray-100 text-sm">2</button>
                    <button
                        class="px-3 py-1 border border-gray-200 rounded-md text-gray-500 hover:bg-gray-100 text-sm">Selanjutnya</button>
                </div>
            </div>
        </div>
    </div>
@endsection
