@extends('layouts.admin')

@section('title', 'Manajemen Pengguna & Peran - Admin PPID')

@section('content')
    <div class="max-w-7xl mx-auto space-y-6">

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-6 border-b border-gray-200">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-1">Manajemen Pengguna & Peran</h1>
                <p class="text-gray-500">Kelola akun administrator dan operator sistem PPID.</p>
            </div>
            <a href="{{ route('admin.users.create') }}"
                class="px-5 py-2.5 bg-tosca-600 hover:bg-tosca-700 text-white font-semibold rounded-xl shadow-md transition-colors flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Pengguna Baru
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-600">
                    <thead class="bg-gray-50 text-gray-800 border-b border-gray-200 uppercase text-xs tracking-wider font-semibold">
                        <tr>
                            <th class="py-4 px-6 text-center w-16">No</th>
                            <th class="py-4 px-6">Nama Petugas</th>
                            <th class="py-4 px-6">Alamat Email</th>
                            <th class="py-4 px-6 text-center">Peran (Role)</th>
                            <th class="py-4 px-6 text-center">Terdaftar Sejak</th>
                            <th class="py-4 px-6 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($users as $index => $u)
                            <tr class="hover:bg-gray-50/50">
                                <td class="py-4 px-6 text-center text-gray-400">{{ $users->firstItem() + $index }}</td>
                                <td class="py-4 px-6 font-bold text-gray-900">
                                    {{ $u->name }}
                                    @if ($u->id === auth()->id())
                                        <span class="ml-1 text-[11px] px-2 py-0.5 rounded bg-tosca-100 text-tosca-800 font-semibold">(Anda)</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 font-mono text-xs text-gray-700">{{ $u->email }}</td>
                                <td class="py-4 px-6 text-center">
                                    @if ($u->role === 'superadmin')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-purple-100 text-purple-800">
                                            Super Admin
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700">
                                            Operator
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-center text-xs text-gray-400">
                                    {{ $u->created_at->format('d M Y') }}
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <div class="flex items-center justify-center gap-1">
                                        <a href="{{ route('admin.users.edit', $u->id) }}"
                                            class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Edit Akun">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>

                                        @if ($u->id !== auth()->id())
                                            <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun ini?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors" title="Hapus Akun">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center text-gray-400">Belum ada akun pengguna.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($users->hasPages())
                <div class="p-4 border-t border-gray-100">
                    {{ $users->links() }}
                </div>
            @endif
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            @if (session('success'))
                Swal.fire({
                    title: "Berhasil!",
                    text: @json(session('success')),
                    icon: "success",
                    confirmButtonColor: "#14b8a6",
                });
            @endif
            @if (session('error'))
                Swal.fire({
                    title: "Gagal!",
                    text: @json(session('error')),
                    icon: "error",
                    confirmButtonColor: "#dc2626",
                });
            @endif
        });
    </script>
@endsection
