<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel - PPID Dispora Jatim')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        tosca: {
                            50: '#f0fdfa',
                            100: '#ccfbf1',
                            200: '#99f6e4',
                            500: '#14b8a6',
                            600: '#0d9488',
                            700: '#0f766e',
                            800: '#115e59',
                            900: '#134e4a'
                        }
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-gray-50 font-sans antialiased text-gray-900 flex h-screen overflow-hidden">

    <div id="sidebar-overlay" class="fixed inset-0 bg-gray-900 bg-opacity-50 z-40 hidden md:hidden transition-opacity">
    </div>

    <aside id="sidebar"
        class="fixed inset-y-0 left-0 z-50 w-64 bg-tosca-900 text-white flex flex-col shadow-xl transform -translate-x-full md:relative md:translate-x-0 transition-transform duration-300 ease-in-out">

        <div class="h-16 flex items-center justify-between px-6 bg-tosca-900 border-b border-tosca-800">
            <div class="flex items-center">
                <div
                    class="w-8 h-8 bg-white text-tosca-700 font-black rounded flex items-center justify-center text-xl mr-3">
                    P
                </div>
                <span class="font-bold text-lg tracking-wide">Admin PPID</span>
            </div>
            <button id="close-sidebar-button" class="md:hidden text-tosca-200 hover:text-white focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>

        <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-tosca-800 text-white font-semibold border-l-4 border-tosca-400' : 'text-tosca-100 hover:bg-tosca-800/50 hover:text-white' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                Dashboard
            </a>

            <p class="px-3 text-xs font-bold text-tosca-400 uppercase tracking-wider mb-2 mt-4">Layanan Publik</p>

            <a href="{{ route('admin.permohonan.index') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin.permohonan.*') ? 'bg-tosca-800 text-white font-semibold border-l-4 border-tosca-400' : 'text-tosca-100 hover:bg-tosca-800/50 hover:text-white' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                    </path>
                </svg>
                Permohonan Masuk
            </a>

            <a href="{{ route('admin.keberatan.index') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin.keberatan.*') ? 'bg-tosca-800 text-white font-semibold border-l-4 border-tosca-400' : 'text-tosca-100 hover:bg-tosca-800/50 hover:text-white' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                    </path>
                </svg>
                Pengajuan Keberatan
            </a>

            <a href="{{ route('admin.survei.index') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin.survei.*') ? 'bg-tosca-800 text-white font-semibold border-l-4 border-tosca-400' : 'text-tosca-100 hover:bg-tosca-800/50 hover:text-white' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z">
                    </path>
                </svg>
                Hasil Survei (IKM)
            </a>

            <p class="px-3 text-xs font-bold text-tosca-400 uppercase tracking-wider mb-2 mt-6">Kelola Konten</p>

            @if (auth()->user()?->role === 'superadmin')
                <a href="{{ route('admin.profil-setting.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin.profil-setting.*') ? 'bg-tosca-800 text-white font-semibold border-l-4 border-tosca-400' : 'text-tosca-100 hover:bg-tosca-800/50 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    Halaman Profil (CMS)
                </a>
            @endif

            <a href="{{ route('admin.berita.index') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin.berita.*') ? 'bg-tosca-800 text-white font-semibold border-l-4 border-tosca-400' : 'text-tosca-100 hover:bg-tosca-800/50 hover:text-white' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15">
                    </path>
                </svg>
                Berita & Informasi
            </a>

            <a href="{{ route('admin.dokumen.index') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin.dokumen.*') ? 'bg-tosca-800 text-white font-semibold border-l-4 border-tosca-400' : 'text-tosca-100 hover:bg-tosca-800/50 hover:text-white' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
                Regulasi & SK
            </a>

            <a href="{{ route('admin.informasi.index') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin.informasi.*') ? 'bg-tosca-800 text-white font-semibold border-l-4 border-tosca-400' : 'text-tosca-100 hover:bg-tosca-800/50 hover:text-white' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                    </path>
                </svg>
                Daftar Informasi
            </a>

            <a href="{{ route('admin.laporan.index') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin.laporan.*') ? 'bg-tosca-800 text-white font-semibold border-l-4 border-tosca-400' : 'text-tosca-100 hover:bg-tosca-800/50 hover:text-white' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                    </path>
                </svg>
                Laporan Tahunan
            </a>

            <a href="{{ route('admin.agenda.index') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin.agenda.*') ? 'bg-tosca-800 text-white font-semibold border-l-4 border-tosca-400' : 'text-tosca-100 hover:bg-tosca-800/50 hover:text-white' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                    </path>
                </svg>
                Agenda Kegiatan
            </a>

            @if (auth()->user()?->role === 'superadmin')
                <p class="px-3 text-xs font-bold text-tosca-400 uppercase tracking-wider mb-2 mt-6">Sistem & Keamanan</p>

                <a href="{{ route('admin.audit-logs.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin.audit-logs.*') ? 'bg-tosca-800 text-white font-semibold border-l-4 border-tosca-400' : 'text-tosca-100 hover:bg-tosca-800/50 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Jejak Audit (Logs)
                </a>

                <a href="{{ route('admin.users.index') }}"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors {{ request()->routeIs('admin.users.*') ? 'bg-tosca-800 text-white font-semibold border-l-4 border-tosca-400' : 'text-tosca-100 hover:bg-tosca-800/50 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    Manajemen Pengguna
                </a>
            @endif
        </nav>

        <div class="p-4 bg-tosca-900 border-t border-tosca-800 text-sm">
            <a href="{{ route('admin.profile.edit') }}" class="flex items-center gap-3 hover:bg-tosca-800/60 p-1.5 -m-1.5 rounded-xl transition-colors" title="Buka Profil & Ganti Password">
                <div class="w-8 h-8 rounded-full bg-tosca-700 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <div class="overflow-hidden">
                    <p class="font-bold text-white truncate">{{ Auth::user()->name ?? 'Admin' }}</p>
                    <p class="text-xs text-tosca-300 truncate uppercase tracking-wider font-semibold">{{ Auth::user()->role ?? 'Petugas PPID' }}</p>
                </div>
            </a>
        </div>
    </aside>

    <div class="flex-1 flex flex-col h-screen overflow-hidden w-full relative">

        <header
            class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-4 sm:px-6 z-10 shadow-sm shrink-0">

            <div class="flex items-center gap-3">
                <button id="mobile-sidebar-button"
                    class="md:hidden text-gray-500 hover:text-tosca-600 focus:outline-none p-1">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>

                <div class="text-gray-600 font-medium hidden sm:block">
                    Sistem Pengelolaan Informasi
                </div>
                <div class="text-gray-600 font-bold sm:hidden">
                    Admin Panel
                </div>
            </div>

            <div class="flex items-center gap-3 sm:gap-4">
                <a href="{{ route('dashboard') }}" target="_blank"
                    class="text-sm text-tosca-600 hover:text-tosca-800 font-semibold flex items-center gap-1">
                    <svg class="w-4 h-4 hidden sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                    </svg>
                    <span class="hidden sm:inline">Lihat Web Publik</span>
                    <span class="sm:hidden">Web</span>
                </a>

                <a href="{{ route('admin.profile.edit') }}"
                    class="px-3 sm:px-3.5 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm font-semibold transition-colors flex items-center gap-1.5" title="Profil Akun & Ganti Password">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <span class="hidden sm:inline">Profil & Password</span>
                </a>

                <span class="w-px h-6 bg-gray-200"></span>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="px-3 sm:px-4 py-2 bg-red-50 text-red-600 hover:bg-red-500 hover:text-white rounded-lg text-sm font-bold transition-colors flex items-center gap-1 sm:gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                            </path>
                        </svg>
                        <span class="hidden sm:inline">Logout</span>
                    </button>
                </form>
            </div>
        </header>

        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-4 sm:p-6">
            @yield('content')
        </main>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btnOpen = document.getElementById('mobile-sidebar-button');
            const btnClose = document.getElementById('close-sidebar-button');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');

            // Fungsi untuk membuka/menutup sidebar
            function toggleSidebar() {
                sidebar.classList.toggle('-translate-x-full');
                overlay.classList.toggle('hidden');
            }

            // Event Listeners
            if (btnOpen) btnOpen.addEventListener('click', toggleSidebar);
            if (btnClose) btnClose.addEventListener('click', toggleSidebar);

            // Tutup sidebar jika user mengklik area gelap (overlay)
            if (overlay) overlay.addEventListener('click', toggleSidebar);
        });
    </script>
</body>

</html>
