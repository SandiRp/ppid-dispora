<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'PPID Dispora Jatim')</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-gray-800 font-sans antialiased flex flex-col min-h-screen">

    <header
        class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-tosca-100 shadow-sm transition-all duration-300">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">

                <div class="flex-shrink-0 flex items-center gap-3">
                    <div
                        class="w-10 h-10 bg-gradient-to-br from-tosca-400 to-tosca-600 rounded-xl flex items-center justify-center text-white font-bold text-xl shadow-lg shadow-tosca-500/30">
                        <img src="{{ asset('assets/images/logo.jpeg') }}" alt="Logo PPID Dispora"
                            class="w-10 h-10 object-contain rounded-xl drop-shadow-md">
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-900 leading-none">PPID <span
                                class="text-tosca-600">DISPORA</span></h1>
                        <p class="text-xs text-gray-500 font-medium tracking-wider">PROVINSI JAWA TIMUR</p>
                    </div>
                </div>

                <nav class="hidden md:flex space-x-1">
                    <a href="{{ route('dashboard') }}"
                        class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-tosca-600 hover:bg-tosca-50 rounded-lg transition-colors">Dashboard</a>

                    <div class="relative group">
                        <button
                            class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-tosca-600 hover:bg-tosca-50 rounded-lg transition-colors flex items-center">
                            Profil <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div
                            class="absolute left-0 mt-2 w-48 bg-white border border-gray-100 rounded-xl shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform origin-top-left scale-95 group-hover:scale-100">
                            <div class="py-2">
                                <a href="{{ route('profil.ppid') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-tosca-50 hover:text-tosca-600">Profil
                                    PPID</a>
                                <a href="{{ route('profil.visi-misi') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-tosca-50 hover:text-tosca-600">Visi
                                    & Misi</a>
                                <a href="{{ route('profil.struktur') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-tosca-50 hover:text-tosca-600">Struktur
                                    Organisasi</a>
                                <a href="{{ route('profil.maklumat') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-tosca-50 hover:text-tosca-600">Maklumat
                                    Layanan</a>
                            </div>
                        </div>
                    </div>

                    <div class="relative group">
                        <button
                            class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-tosca-600 hover:bg-tosca-50 rounded-lg transition-colors flex items-center">
                            Dokumen <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div
                            class="absolute left-0 mt-2 w-48 bg-white border border-gray-100 rounded-xl shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300">
                            <div class="py-2">
                                <a href="{{ route('dokumen.regulasi') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-tosca-50 hover:text-tosca-600">Regulasi</a>
                                <a href="{{ route('dokumen.sop') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-tosca-50 hover:text-tosca-600">SOP</a>
                                <a href="{{ route('dokumen.sk') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-tosca-50 hover:text-tosca-600">SK
                                    PPID</a>
                            </div>
                        </div>
                    </div>

                    <div class="relative group">
                        <button
                            class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-tosca-600 hover:bg-tosca-50 rounded-lg transition-colors flex items-center">
                            Daftar Informasi <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div
                            class="absolute left-0 mt-2 w-56 bg-white border border-gray-100 rounded-xl shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300">
                            <div class="py-2">
                                <a href="{{ route('informasi.berkala') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-tosca-50 hover:text-tosca-600">Informasi
                                    Berkala</a>
                                <a href="{{ route('informasi.serta-merta') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-tosca-50 hover:text-tosca-600">Informasi
                                    Serta Merta</a>
                                <a href="{{ route('informasi.setiap-saat') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-tosca-50 hover:text-tosca-600">Informasi
                                    Setiap Saat</a>
                                <a href="{{ route('informasi.dikecualikan') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-tosca-50 hover:text-tosca-600">Informasi
                                    Dikecualikan</a>
                            </div>
                        </div>
                    </div>

                    <div class="relative group">
                        <button
                            class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-tosca-600 hover:bg-tosca-50 rounded-lg transition-colors flex items-center">
                            Laporan <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div
                            class="absolute right-0 mt-2 w-56 bg-white border border-gray-100 rounded-xl shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300">
                            <div class="py-2">
                                <a href="{{ route('laporan.akses') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-tosca-50 hover:text-tosca-600">Laporan
                                    Akses Informasi</a>
                                <a href="{{ route('laporan.pelayanan') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-tosca-50 hover:text-tosca-600">Laporan
                                    Pelayanan Publik</a>
                                <a href="{{ route('laporan.agenda') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-tosca-50 hover:text-tosca-600">Laporan
                                    Agenda Bulanan</a>
                            </div>
                        </div>
                    </div>
                </nav>

                <div class="hidden md:flex items-center">
                    <a href="{{ route('permohonan.create') }}"
                        class="bg-gradient-to-r from-tosca-500 to-tosca-600 hover:from-tosca-600 hover:to-tosca-700 text-white px-5 py-2.5 rounded-full text-sm font-semibold shadow-lg shadow-tosca-500/40 transition-all transform hover:-translate-y-0.5">
                        Ajukan Permohonan
                    </a>
                </div>
            </div>
        </div>
    </header>

    <div class="absolute top-0 left-0 w-full h-96 bg-gradient-to-b from-tosca-50 to-transparent -z-10 overflow-hidden">
        <div
            class="absolute -top-24 -right-24 w-96 h-96 bg-tosca-100 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-blob">
        </div>
        <div
            class="absolute top-12 -left-24 w-72 h-72 bg-blue-100 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-blob animation-delay-2000">
        </div>
    </div>

    <main class="flex-grow container mx-auto px-4 sm:px-6 lg:px-8 py-10 z-10">
        @yield('content')
    </main>

    <footer class="bg-white border-t border-gray-200 mt-auto">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="flex items-center gap-2">
                    <div
                        class="w-8 h-8 bg-tosca-500 rounded-lg flex items-center justify-center text-white font-bold text-sm">
                        <img src="{{ asset('assets/images/logo.jpeg') }}" alt="Logo PPID Dispora"
                            class="w-8 h-8 object-contain rounded-xl drop-shadow-md">
                    </div>
                    <span class="text-sm font-semibold text-gray-700">PPID Dinas Kepemudaan dan Olahraga Jawa
                        Timur</span>
                </div>
                <p class="text-sm text-gray-500">
                    &copy; {{ date('Y') }} DISPORA Jawa Timur.
                </p>
            </div>
        </div>
    </footer>

</body>

</html>
