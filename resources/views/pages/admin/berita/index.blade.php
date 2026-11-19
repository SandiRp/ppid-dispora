@extends('layouts.admin')

@section('title', 'Kelola Berita - Admin PPID')

@section('content')
    <div class="max-w-7xl mx-auto space-y-6">

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-6 border-b border-gray-200">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-1">Kelola Berita & Informasi</h1>
                <p class="text-gray-500">Publikasikan informasi terbaru kepada masyarakat luas.</p>
            </div>
            <a href="{{ route('admin.berita.create') }}"
                class="px-5 py-2.5 bg-tosca-600 hover:bg-tosca-700 text-white font-semibold rounded-xl shadow-md transition-colors flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tulis Berita Baru
            </a>
        </div>

        <!-- Filter & Search Bar -->
        <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm">
            <form action="{{ route('admin.berita.index') }}" method="GET" class="flex items-center gap-3">
                <input type="text" name="q" value="{{ request('q') }}"
                    placeholder="Cari judul atau kategori berita..."
                    class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:bg-white focus:ring-2 focus:ring-tosca-500 outline-none">
                <button type="submit" class="px-5 py-2 bg-gray-800 hover:bg-gray-900 text-white font-bold text-xs rounded-xl transition-colors whitespace-nowrap">
                    Cari Berita
                </button>
                @if (request()->filled('q'))
                    <a href="{{ route('admin.berita.index') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 text-xs font-bold rounded-xl transition-colors">
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
                            <th class="py-4 px-6 font-semibold">Gambar</th>
                            <th class="py-4 px-6 font-semibold">Judul & Kategori</th>
                            <th class="py-4 px-6 font-semibold text-center">Status</th>
                            <th class="py-4 px-6 font-semibold">Tanggal Publish</th>
                            <th class="py-4 px-6 font-semibold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">

                        @forelse ($beritas as $index => $item)
                            <tr class="hover:bg-tosca-50/50 transition-colors">
                                <td class="py-4 px-6 text-center text-gray-500">{{ $beritas->firstItem() + $index }}</td>

                                <td class="py-4 px-6">
                                    @if ($item->gambar)
                                        <img src="{{ asset('storage/' . $item->gambar) }}"
                                            class="w-20 h-14 object-cover rounded-lg shadow-sm">
                                    @else
                                        <div
                                            class="w-20 h-14 bg-gray-100 rounded-lg flex items-center justify-center text-gray-400 text-xs font-medium">
                                            No Image</div>
                                    @endif
                                </td>

                                <td class="py-4 px-6">
                                    <div class="font-bold text-gray-900 text-base mb-1">{{ $item->judul }}</div>
                                    <span
                                        class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-tosca-100 text-tosca-800">
                                        {{ $item->kategori }}
                                    </span>
                                </td>

                                <td class="py-4 px-6 text-center whitespace-nowrap">
                                    @if (($item->status ?? 'published') === 'published')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                            ✓ Terbit
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800 border border-amber-200">
                                            Draft
                                        </span>
                                    @endif
                                </td>

                                <td class="py-4 px-6">
                                    {{ \Carbon\Carbon::parse($item->tanggal_publish)->translatedFormat('d F Y') }}
                                </td>

                                <td class="py-4 px-6 text-center">
                                    <div class="flex items-center justify-center gap-1">
                                        <a href="{{ route('admin.berita.edit', $item->id) }}"
                                            class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                            title="Edit Berita">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                </path>
                                            </svg>
                                        </a>
                                        <form action="{{ route('admin.berita.destroy', $item->id) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="p-2 text-red-500 hover:bg-red-50 hover:text-red-700 rounded-lg transition-colors"
                                                title="Hapus Berita">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                    </path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-12 text-center text-gray-500">Belum ada berita yang
                                    diterbitkan.</td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>

            @if ($beritas->hasPages())
                <div class="p-4 border-t border-gray-100">
                    {{ $beritas->links() }}
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
