<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'PPID Dispora Jawa Timur - Portal Layanan Informasi Publik Resmi')</title>

    <!-- Meta SEO & Aksesibilitas -->
    <meta name="description" content="@yield('meta_description', 'Portal Resmi Pejabat Pengelola Informasi dan Dokumentasi (PPID) Dinas Kepemudaan dan Olahraga Provinsi Jawa Timur. Melayani permohonan informasi publik secara transparan, cepat, dan akuntabel.')">
    <meta name="keywords" content="PPID, Dispora Jatim, Informasi Publik, Pemuda Olahraga Jawa Timur, Keterbukaan Informasi">
    <meta name="author" content="Dinas Kepemudaan dan Olahraga Provinsi Jawa Timur">

    <!-- Open Graph / Facebook / WhatsApp -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', 'PPID Dispora Jawa Timur')">
    <meta property="og:description" content="@yield('meta_description', 'Portal Resmi Pejabat Pengelola Informasi dan Dokumentasi (PPID) Dinas Kepemudaan dan Olahraga Provinsi Jawa Timur.')">
    <meta property="og:image" content="{{ asset('assets/images/logo.jpeg') }}">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', 'PPID Dispora Jawa Timur')">
    <meta name="twitter:description" content="@yield('meta_description', 'Layanan Keterbukaan Informasi Publik PPID Dispora Jatim.')">
    <meta name="twitter:image" content="{{ asset('assets/images/logo.jpeg') }}">

    <link rel="sitemap" type="application/xml" title="Sitemap" href="{{ route('sitemap') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        /* Mode Kontras Tinggi Standar Aksesibilitas Web (WCAG 2.1 AAA) */
        html.high-contrast,
        html.high-contrast body {
            background-color: #000000 !important;
            color: #ffff00 !important;
        }
        html.high-contrast header,
        html.high-contrast footer,
        html.high-contrast main,
        html.high-contrast .bg-white,
        html.high-contrast .bg-gray-50,
        html.high-contrast .bg-gray-100,
        html.high-contrast .bg-tosca-50,
        html.high-contrast .bg-tosca-100 {
            background-color: #000000 !important;
            color: #ffff00 !important;
            border-color: #ffff00 !important;
        }
        html.high-contrast a,
        html.high-contrast button,
        html.high-contrast h1,
        html.high-contrast h2,
        html.high-contrast h3,
        html.high-contrast h4,
        html.high-contrast p,
        html.high-contrast span,
        html.high-contrast td,
        html.high-contrast th,
        html.high-contrast label {
            color: #ffff00 !important;
        }
        html.high-contrast a:hover {
            color: #00ffff !important;
            text-decoration: underline !important;
        }
        html.high-contrast input,
        html.high-contrast textarea,
        html.high-contrast select {
            background-color: #111111 !important;
            color: #ffffff !important;
            border: 2px solid #ffff00 !important;
        }
        html.high-contrast .shadow-sm,
        html.high-contrast .shadow-md,
        html.high-contrast .shadow-lg,
        html.high-contrast .shadow-xl {
            box-shadow: 0 0 0 1px #ffff00 !important;
        }

        /* Mode Monokrom / Grayscale */
        html.grayscale-mode {
            filter: grayscale(100%) !important;
        }

        /* Mode Pembalik Warna (Invert) */
        html.invert-mode {
            filter: invert(100%) hue-rotate(180deg) !important;
        }
        html.invert-mode img,
        html.invert-mode video {
            filter: invert(100%) hue-rotate(180deg) !important;
        }

        /* Mode Font Ramah Disleksia */
        html.dyslexic-font body,
        html.dyslexic-font h1,
        html.dyslexic-font h2,
        html.dyslexic-font h3,
        html.dyslexic-font h4,
        html.dyslexic-font p,
        html.dyslexic-font span,
        html.dyslexic-font a,
        html.dyslexic-font button,
        html.dyslexic-font input,
        html.dyslexic-font textarea {
            font-family: 'Comic Sans MS', 'Comic Neue', 'Trebuchet MS', sans-serif !important;
            letter-spacing: 0.05em !important;
            line-height: 1.8 !important;
        }

        /* Spasi Teks & Baris Lega */
        html.large-spacing body,
        html.large-spacing p,
        html.large-spacing span,
        html.large-spacing a {
            letter-spacing: 0.1em !important;
            line-height: 2 !important;
            word-spacing: 0.15em !important;
        }

        /* Sorot Semua Tautan (Highlight Links) */
        html.highlight-links a {
            outline: 3px solid #ff0055 !important;
            background-color: #fffb00 !important;
            color: #000000 !important;
            text-decoration: underline !important;
            font-weight: 800 !important;
            padding: 2px 4px !important;
            border-radius: 4px !important;
        }

        /* Kursor Besar */
        html.big-cursor,
        html.big-cursor * {
            cursor: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 24 24" fill="black" stroke="white" stroke-width="1.5"><polygon points="0 0, 0 19, 5 15, 9 24, 13 22, 9 13, 16 13"/></svg>'), auto !important;
        }

        /* Hentikan Animasi */
        html.stop-animations *,
        html.stop-animations *::before,
        html.stop-animations *::after {
            animation: none !important;
            transition: none !important;
            scroll-behavior: auto !important;
        }

        /* Garis Panduan Membaca (Reading Ruler) */
        #reading-ruler {
            position: fixed;
            left: 0;
            right: 0;
            height: 38px;
            background: rgba(254, 240, 138, 0.35);
            border-top: 2px solid #eab308;
            border-bottom: 2px solid #eab308;
            pointer-events: none;
            z-index: 99999;
            display: none;
            box-shadow: 0 0 20px rgba(0,0,0,0.15);
        }

        /* Styling Terintegrasi Multi-Bahasa Google Translate Tanpa Bar Mengganggu */
        .goog-te-banner-frame.skiptranslate,
        .goog-te-banner-frame {
            display: none !important;
        }
        body {
            top: 0px !important;
        }
        #goog-gt-tt,
        .goog-te-balloon-frame {
            display: none !important;
        }
        .goog-text-highlight {
            background: none !important;
            box-shadow: none !important;
        }
        .skiptranslate iframe {
            display: none !important;
        }
        font {
            background-color: transparent !important;
            box-shadow: none !important;
        }
    </style>

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
                        <a href="{{ route('dashboard') }}">
                            <img src="{{ asset('assets/images/logo.jpeg') }}" alt="Logo PPID Dispora"
                                class="w-10 h-10 object-contain rounded-xl drop-shadow-md">
                        </a>
                    </div>
                    <div>
                        <a href="{{ route('dashboard') }}">
                            <h1 class="text-xl font-bold text-gray-900 leading-none">PPID <span
                                    class="text-tosca-600">DISPORA</span></h1>
                        </a>
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
                                <a href="{{ route('informasi.dip') }}"
                                    class="block px-4 py-2 text-sm font-bold text-tosca-700 bg-tosca-50/50 hover:bg-tosca-50 hover:text-tosca-800 border-b border-gray-100">📋
                                    DIP Terpadu (Semua)</a>
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
                            Standar Layanan <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div
                            class="absolute left-0 mt-2 w-60 bg-white border border-gray-100 rounded-xl shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300">
                            <div class="py-2">
                                <a href="{{ route('standar.prosedur') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-tosca-50 hover:text-tosca-600">Prosedur, Waktu & Biaya</a>
                                <a href="{{ route('standar.hak-kewajiban') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-tosca-50 hover:text-tosca-600">Hak & Kewajiban</a>
                                <a href="{{ route('standar.faq') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-tosca-50 hover:text-tosca-600">Tanya Jawab (FAQ) & Privasi</a>
                                <a href="{{ route('standar.kontak') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-tosca-50 hover:text-tosca-600">Kontak, Lokasi & Pengaduan</a>
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
                                <a href="{{ route('laporan.statistik') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-tosca-50 hover:text-tosca-600 font-semibold text-tosca-700">
                                    📊 Statistik & IKM
                                </a>
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

                <div class="hidden md:flex items-center gap-2">
                    <!-- Tombol Pencarian Cepat -->
                    <a href="{{ route('cari') }}" title="Pencarian Informasi"
                        class="p-2 text-gray-500 hover:text-tosca-600 hover:bg-tosca-50 rounded-full transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </a>

                    <!-- Tombol Aksesibilitas & Ramah Disabilitas di Header -->
                    <button type="button" onclick="toggleA11yPanel()"
                        class="flex items-center gap-1.5 px-3 py-1.5 bg-tosca-50 hover:bg-tosca-100 text-tosca-700 hover:text-tosca-800 border border-tosca-200/80 rounded-full text-xs font-bold transition-all shadow-sm"
                        title="Buka Menu Aksesibilitas & Ramah Disabilitas (Alt + A)">
                        <span class="text-sm">♿</span> Aksesibilitas
                    </button>

                    <!-- Pemilih Bahasa / Language Switcher Dropdown -->
                    <div class="relative group">
                        <button type="button" class="flex items-center gap-1.5 px-3 py-1.5 bg-gray-50 hover:bg-gray-100 text-gray-700 border border-gray-200/80 rounded-full text-xs font-bold transition-all shadow-sm">
                            <span id="current-lang-flag">🇮🇩</span>
                            <span id="current-lang-code">ID</span>
                            <svg class="w-3 h-3 text-gray-400 group-hover:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div class="absolute right-0 mt-2 w-48 bg-white border border-gray-100 rounded-2xl shadow-xl py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                            <div class="px-3 py-1.5 text-[10px] font-extrabold text-gray-400 uppercase tracking-wider border-b border-gray-100">
                                Bahasa / Language
                            </div>
                            <button type="button" onclick="setLanguage('id', '🇮🇩', 'ID')" class="w-full px-4 py-2 text-left text-xs font-semibold text-gray-700 hover:bg-tosca-50 hover:text-tosca-700 flex items-center justify-between transition-colors">
                                <span class="flex items-center gap-2"><span>🇮🇩</span> Bahasa Indonesia</span>
                                <span class="text-[10px] text-tosca-600 font-bold">Utama</span>
                            </button>
                            <button type="button" onclick="setLanguage('en', '🇬🇧', 'EN')" class="w-full px-4 py-2 text-left text-xs font-semibold text-gray-700 hover:bg-tosca-50 hover:text-tosca-700 flex items-center gap-2 transition-colors">
                                <span>🇬🇧</span> English
                            </button>
                            <button type="button" onclick="setLanguage('jw', 'ꦗ', 'JW')" class="w-full px-4 py-2 text-left text-xs font-semibold text-gray-700 hover:bg-tosca-50 hover:text-tosca-700 flex items-center gap-2 transition-colors">
                                <span>ꦗ</span> Basa Jawa
                            </button>
                            <button type="button" onclick="setLanguage('ar', '🇸🇦', 'AR')" class="w-full px-4 py-2 text-left text-xs font-semibold text-gray-700 hover:bg-tosca-50 hover:text-tosca-700 flex items-center gap-2 transition-colors">
                                <span>🇸🇦</span> العربية (Arabic)
                            </button>
                            <button type="button" onclick="setLanguage('zh-CN', '🇨🇳', 'ZH')" class="w-full px-4 py-2 text-left text-xs font-semibold text-gray-700 hover:bg-tosca-50 hover:text-tosca-700 flex items-center gap-2 transition-colors">
                                <span>🇨🇳</span> 简体中文 (Chinese)
                            </button>
                            <button type="button" onclick="setLanguage('ja', '🇯🇵', 'JA')" class="w-full px-4 py-2 text-left text-xs font-semibold text-gray-700 hover:bg-tosca-50 hover:text-tosca-700 flex items-center gap-2 transition-colors">
                                <span>🇯🇵</span> 日本語 (Japanese)
                            </button>
                        </div>
                    </div>

                    <a href="{{ route('permohonan.lacak') }}"
                        class="text-gray-600 hover:text-tosca-600 px-3 py-2 text-sm font-semibold rounded-full hover:bg-tosca-50 transition-colors">
                        Lacak Status
                    </a>
                    <a href="{{ route('permohonan.create') }}"
                        class="bg-gradient-to-r from-tosca-500 to-tosca-600 hover:from-tosca-600 hover:to-tosca-700 text-white px-5 py-2.5 rounded-full text-sm font-semibold shadow-lg shadow-tosca-500/40 transition-all transform hover:-translate-y-0.5">
                        Ajukan Permohonan
                    </a>
                </div>

                <div class="flex items-center md:hidden">
                    <button id="mobile-menu-button" type="button"
                        class="text-gray-500 hover:text-tosca-600 focus:outline-none">
                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path id="icon-menu" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                            <path id="icon-close" class="hidden" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

            </div>
        </div>

        <div id="mobile-menu-panel"
            class="hidden md:hidden bg-white shadow-xl absolute w-full left-0 border-t border-gray-100 h-[calc(100vh-5rem)] overflow-y-auto">
            <div class="px-4 py-4 space-y-1 pb-10">
                <a href="{{ route('dashboard') }}"
                    class="block px-3 py-2 rounded-md text-base font-bold text-gray-900 bg-gray-50 hover:bg-tosca-50">Dashboard</a>

                <div class="font-bold text-sm text-gray-500 px-3 pt-4 pb-1 uppercase tracking-wider">Profil</div>
                <a href="{{ route('profil.ppid') }}"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-tosca-50">Profil PPID</a>
                <a href="{{ route('profil.visi-misi') }}"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-tosca-50">Visi & Misi</a>
                <a href="{{ route('profil.struktur') }}"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-tosca-50">Struktur Organisasi</a>
                <a href="{{ route('profil.maklumat') }}"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-tosca-50">Maklumat Layanan</a>

                <div class="font-bold text-sm text-gray-500 px-3 pt-4 pb-1 uppercase tracking-wider border-t mt-2">
                    Dokumen</div>
                <a href="{{ route('dokumen.regulasi') }}"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-tosca-50">Regulasi</a>
                <a href="{{ route('dokumen.sop') }}"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-tosca-50">SOP</a>
                <a href="{{ route('dokumen.sk') }}"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-tosca-50">SK PPID</a>

                <div class="font-bold text-sm text-gray-500 px-3 pt-4 pb-1 uppercase tracking-wider border-t mt-2">
                    Daftar Informasi</div>
                <a href="{{ route('informasi.dip') }}"
                    class="block px-4 py-2 text-sm font-bold text-tosca-700 hover:bg-tosca-50">📋 DIP Terpadu (Semua)</a>
                <a href="{{ route('informasi.berkala') }}"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-tosca-50">Informasi Berkala</a>
                <a href="{{ route('informasi.serta-merta') }}"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-tosca-50">Informasi Serta Merta</a>
                <a href="{{ route('informasi.setiap-saat') }}"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-tosca-50">Informasi Setiap Saat</a>
                <a href="{{ route('informasi.dikecualikan') }}"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-tosca-50">Informasi Dikecualikan</a>

                <div class="font-bold text-sm text-gray-500 px-3 pt-4 pb-1 uppercase tracking-wider border-t mt-2">
                    Standar Layanan</div>
                <a href="{{ route('standar.prosedur') }}"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-tosca-50">Prosedur, Waktu & Biaya</a>
                <a href="{{ route('standar.hak-kewajiban') }}"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-tosca-50">Hak & Kewajiban</a>
                <a href="{{ route('standar.faq') }}"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-tosca-50">Tanya Jawab (FAQ) & Privasi</a>
                <a href="{{ route('standar.kontak') }}"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-tosca-50">Kontak, Lokasi & Pengaduan</a>

                <div class="font-bold text-sm text-gray-500 px-3 pt-4 pb-1 uppercase tracking-wider border-t mt-2">
                    Laporan</div>
                <a href="{{ route('laporan.statistik') }}"
                    class="block px-4 py-2 text-sm font-bold text-tosca-700 hover:bg-tosca-50">📊 Statistik & IKM</a>
                <a href="{{ route('laporan.akses') }}"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-tosca-50">Laporan Akses Informasi</a>
                <a href="{{ route('laporan.pelayanan') }}"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-tosca-50">Laporan Pelayanan Publik</a>
                <a href="{{ route('laporan.agenda') }}"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-tosca-50">Laporan Agenda Bulanan</a>

                <div class="mt-6 pt-4 border-t border-gray-200 space-y-2">
                    <!-- Pilihan Bahasa Mobile -->
                    <div class="p-3 bg-gray-50 border border-gray-200 rounded-xl space-y-2">
                        <div class="text-[11px] font-bold text-gray-500 uppercase tracking-wider flex items-center justify-between">
                            <span>🌐 Bahasa / Language</span>
                            <span id="current-lang-mobile" class="text-tosca-700 font-extrabold">🇮🇩 ID</span>
                        </div>
                        <div class="grid grid-cols-3 gap-1.5">
                            <button type="button" onclick="setLanguage('id', '🇮🇩', 'ID')" class="px-2 py-1.5 bg-white border border-gray-200 rounded-lg text-xs font-bold text-gray-700 flex items-center justify-center gap-1">
                                🇮🇩 ID
                            </button>
                            <button type="button" onclick="setLanguage('en', '🇬🇧', 'EN')" class="px-2 py-1.5 bg-white border border-gray-200 rounded-lg text-xs font-bold text-gray-700 flex items-center justify-center gap-1">
                                🇬🇧 EN
                            </button>
                            <button type="button" onclick="setLanguage('jw', 'ꦗ', 'JW')" class="px-2 py-1.5 bg-white border border-gray-200 rounded-lg text-xs font-bold text-gray-700 flex items-center justify-center gap-1">
                                ꦗ Jawa
                            </button>
                            <button type="button" onclick="setLanguage('ar', '🇸🇦', 'AR')" class="px-2 py-1.5 bg-white border border-gray-200 rounded-lg text-xs font-bold text-gray-700 flex items-center justify-center gap-1">
                                🇸🇦 Arab
                            </button>
                            <button type="button" onclick="setLanguage('zh-CN', '🇨🇳', 'ZH')" class="px-2 py-1.5 bg-white border border-gray-200 rounded-lg text-xs font-bold text-gray-700 flex items-center justify-center gap-1">
                                🇨🇳 China
                            </button>
                            <button type="button" onclick="setLanguage('ja', '🇯🇵', 'JA')" class="px-2 py-1.5 bg-white border border-gray-200 rounded-lg text-xs font-bold text-gray-700 flex items-center justify-center gap-1">
                                🇯🇵 Jepang
                            </button>
                        </div>
                    </div>

                    <button type="button" onclick="toggleA11yPanel()"
                        class="w-full text-center px-4 py-2.5 bg-tosca-50 text-tosca-700 hover:bg-tosca-100 rounded-lg font-bold text-sm flex items-center justify-center gap-2 border border-tosca-200 transition-colors">
                        <span>♿</span> Fitur Aksesibilitas & Disabilitas
                    </button>
                    <a href="{{ route('permohonan.lacak') }}"
                        class="block w-full text-center px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-lg font-semibold text-sm">
                        Lacak Status Permohonan
                    </a>
                    <a href="{{ route('permohonan.create') }}"
                        class="block w-full text-center px-4 py-3 bg-gradient-to-r from-tosca-500 to-tosca-600 text-white rounded-lg font-bold shadow-md hover:shadow-lg">
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
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 pb-8 border-b border-gray-100">
                <!-- Kolom 1: Identitas & Alamat -->
                <div class="space-y-3">
                    <div class="flex items-center gap-2.5">
                        <div class="w-9 h-9 bg-tosca-500 rounded-lg flex items-center justify-center text-white font-bold text-sm shrink-0">
                            <img src="{{ asset('assets/images/logo.jpeg') }}" alt="Logo PPID Dispora"
                                class="w-9 h-9 object-contain rounded-xl drop-shadow-md">
                        </div>
                        <div>
                            <div class="text-sm font-extrabold text-gray-900 leading-tight">PPID DISPORA JATIM</div>
                            <div class="text-[11px] text-tosca-700 font-semibold">Provinsi Jawa Timur</div>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 leading-relaxed">
                        Jl. Kayoon No. 56, Embong Kaliasin, Kec. Genteng, Kota Surabaya, Jawa Timur 60271
                    </p>
                    <p class="text-xs text-gray-500">
                        <strong class="text-gray-700">Jam Layanan:</strong> Sen–Kam 08.00–15.30 | Jum 08.00–14.30 WIB
                    </p>
                </div>

                <!-- Kolom 2: Layanan & Standar PPID -->
                <div class="space-y-2.5">
                    <h4 class="text-xs font-extrabold uppercase tracking-wider text-gray-900">Layanan & Standar</h4>
                    <ul class="space-y-1.5 text-xs text-gray-600">
                        <li><a href="{{ route('permohonan.create') }}" class="hover:text-tosca-600 transition-colors">Ajukan Permohonan Informasi</a></li>
                        <li><a href="{{ route('permohonan.lacak') }}" class="hover:text-tosca-600 transition-colors">Lacak Status (Verifikasi NIK)</a></li>
                        <li><a href="{{ route('keberatan.create') }}" class="hover:text-tosca-600 transition-colors">Pengajuan Keberatan</a></li>
                        <li><a href="{{ route('survei.create') }}" class="hover:text-tosca-600 transition-colors">Survei Kepuasan (IKM)</a></li>
                        <li><a href="{{ route('standar.prosedur') }}" class="hover:text-tosca-600 transition-colors">Prosedur, Waktu & Biaya (Gratis)</a></li>
                    </ul>
                </div>

                <!-- Kolom 3: Keterbukaan Informasi -->
                <div class="space-y-2.5">
                    <h4 class="text-xs font-extrabold uppercase tracking-wider text-gray-900">Keterbukaan Informasi</h4>
                    <ul class="space-y-1.5 text-xs text-gray-600">
                        <li><a href="{{ route('informasi.dip') }}" class="font-semibold text-tosca-700 hover:text-tosca-800 transition-colors">DIP Terpadu (Semua Informasi)</a></li>
                        <li><a href="{{ route('informasi.berkala') }}" class="hover:text-tosca-600 transition-colors">Informasi Berkala</a></li>
                        <li><a href="{{ route('informasi.serta-merta') }}" class="hover:text-tosca-600 transition-colors">Informasi Serta-Merta</a></li>
                        <li><a href="{{ route('informasi.setiap-saat') }}" class="hover:text-tosca-600 transition-colors">Informasi Setiap Saat</a></li>
                        <li><a href="{{ route('laporan.statistik') }}" class="hover:text-tosca-600 transition-colors">Statistik Pelayanan & IKM</a></li>
                    </ul>
                </div>

                <!-- Kolom 4: Pengaduan & Jejaring -->
                <div class="space-y-2.5">
                    <h4 class="text-xs font-extrabold uppercase tracking-wider text-gray-900">Pengaduan & Jejaring</h4>
                    <ul class="space-y-1.5 text-xs text-gray-600">
                        <li><a href="https://www.lapor.go.id/" target="_blank" rel="noopener" class="hover:text-red-600 font-semibold transition-colors">SP4N-LAPOR! Nasional &nearr;</a></li>
                        <li><a href="https://komisiinformasi.jatimprov.go.id/" target="_blank" rel="noopener" class="hover:text-tosca-600 transition-colors">Komisi Informasi Prov. Jatim &nearr;</a></li>
                        <li><a href="https://ppid.jatimprov.go.id/" target="_blank" rel="noopener" class="hover:text-tosca-600 transition-colors">PPID Utama Pemprov Jatim &nearr;</a></li>
                        <li><a href="{{ route('standar.faq') }}" class="hover:text-tosca-600 transition-colors">FAQ & Kebijakan Privasi</a></li>
                        <li><a href="{{ route('standar.kontak') }}" class="hover:text-tosca-600 transition-colors">Kontak & Peta Lokasi</a></li>
                        <li><a href="{{ route('sitemap') }}" class="hover:text-tosca-600 transition-colors">Peta Situs (Sitemap XML)</a></li>
                    </ul>
                </div>
            </div>

            <div class="pt-6 flex flex-col sm:flex-row justify-between items-center gap-3 text-xs text-gray-500">
                <p>&copy; {{ date('Y') }} PPID Dinas Kepemudaan dan Olahraga Provinsi Jawa Timur.</p>
                <p>Sesuai UU No. 14/2008 (KIP), Perki No. 1/2021, & UU No. 27/2022 (PDP).</p>
            </div>
        </div>
    </footer>

    <!-- Elemen Garis Panduan Membaca (Reading Ruler) -->
    <div id="reading-ruler"></div>

    <!-- Tombol Mengambang (Floating Action Button) Aksesibilitas Disabilitas -->
    <div class="fixed bottom-6 right-6 z-50 flex flex-col items-end gap-2">
        <!-- Floating Speech Bubble / Toast Alert Status -->
        <div id="speech-status-bubble" class="hidden bg-gray-900 text-white text-xs px-3 py-1.5 rounded-full shadow-lg flex items-center gap-2 animate-bounce">
            <span class="inline-block w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
            <span id="speech-status-text">Membacakan konten...</span>
            <button type="button" onclick="stopSpeech()" class="ml-1 text-gray-300 hover:text-white font-bold">&times;</button>
        </div>

        <button type="button" onclick="toggleA11yPanel()" id="btnOpenA11y"
            class="group relative flex items-center justify-center w-14 h-14 bg-gradient-to-tr from-tosca-600 via-tosca-500 to-emerald-500 text-white rounded-full shadow-2xl hover:scale-110 active:scale-95 transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-tosca-300"
            title="Menu Aksesibilitas & Ramah Disabilitas (Alt + A)"
            aria-label="Buka Menu Aksesibilitas dan Disabilitas">
            <!-- Icon Universal Accessibility -->
            <svg class="w-8 h-8 transition-transform group-hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
            <span class="absolute -top-1 -right-1 flex h-4 w-4">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-4 w-4 bg-amber-500 text-[9px] font-black text-white items-center justify-center">♿</span>
            </span>
        </button>
    </div>

    <!-- Modal / Offcanvas Panel Aksesibilitas Disabilitas -->
    <div id="a11y-backdrop" onclick="toggleA11yPanel()" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-[9998] hidden transition-opacity"></div>
    <div id="a11y-panel" class="fixed top-0 right-0 bottom-0 w-full sm:w-[420px] bg-white shadow-2xl z-[9999] transform translate-x-full transition-transform duration-300 flex flex-col overflow-hidden">
        <!-- Panel Header -->
        <div class="px-5 py-4 bg-gradient-to-r from-tosca-600 to-emerald-600 text-white flex items-center justify-between shadow">
            <div class="flex items-center gap-2.5">
                <div class="w-9 h-9 rounded-xl bg-white/20 flex items-center justify-center text-lg font-bold">
                    ♿
                </div>
                <div>
                    <h3 class="font-extrabold text-base leading-tight">Fitur Ramah Disabilitas</h3>
                    <p class="text-xs text-tosca-100">Standar WCAG 2.1 & Aksesibilitas Publik</p>
                </div>
            </div>
            <button type="button" onclick="toggleA11yPanel()" class="p-1.5 rounded-lg bg-white/10 hover:bg-white/25 text-white transition-colors" title="Tutup Panel">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Panel Body -->
        <div class="flex-1 overflow-y-auto p-5 space-y-6 text-gray-800">
            <!-- 1. Suara & Narasi Layar (Screen Reader) -->
            <div class="space-y-2">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-black uppercase tracking-wider text-tosca-700 flex items-center gap-1.5">
                        <span>🔊</span> Pembaca Layar Suara (Text-to-Speech)
                    </span>
                    <span id="badge-tts" class="text-[10px] px-2 py-0.5 rounded font-bold bg-gray-100 text-gray-500">Standby</span>
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <button type="button" onclick="startSpeech()" class="px-3 py-2.5 bg-tosca-50 hover:bg-tosca-100 text-tosca-800 font-bold rounded-xl text-xs flex items-center justify-center gap-2 border border-tosca-200 transition-all">
                        <span>▶️</span> Bacakan Halaman
                    </button>
                    <button type="button" onclick="stopSpeech()" class="px-3 py-2.5 bg-gray-50 hover:bg-red-50 text-gray-700 hover:text-red-700 font-bold rounded-xl text-xs flex items-center justify-center gap-2 border border-gray-200 hover:border-red-200 transition-all">
                        <span>⏹️</span> Hentikan Suara
                    </button>
                </div>
                <p class="text-[11px] text-gray-500 italic">
                    💡 Tip: Anda juga dapat menyeleksi/memblok teks manapun di halaman ini untuk mendengarkan bacaan suaranya secara spesifik.
                </p>
            </div>

            <!-- 2. Ukuran Huruf (Font Sizing) -->
            <div class="space-y-2">
                <span class="text-xs font-black uppercase tracking-wider text-tosca-700 flex items-center gap-1.5">
                    <span>🔍</span> Ukuran Teks (Zoom Font)
                </span>
                <div class="grid grid-cols-4 gap-2">
                    <button type="button" onclick="adjustFontSize(-1)" class="p-2.5 bg-gray-100 hover:bg-gray-200 rounded-xl text-xs font-bold text-center transition-colors">
                        A- (Kecil)
                    </button>
                    <button type="button" onclick="resetFontSize()" class="p-2.5 bg-gray-100 hover:bg-gray-200 rounded-xl text-xs font-bold text-center transition-colors">
                        Normal
                    </button>
                    <button type="button" onclick="adjustFontSize(1)" class="p-2.5 bg-gray-100 hover:bg-gray-200 rounded-xl text-xs font-bold text-center transition-colors">
                        A+ (Besar)
                    </button>
                    <button type="button" onclick="adjustFontSize(2)" class="p-2.5 bg-gray-100 hover:bg-gray-200 rounded-xl text-xs font-bold text-center transition-colors">
                        A++ (Maks)
                    </button>
                </div>
            </div>

            <!-- 3. Tampilan Visual & Warna -->
            <div class="space-y-2">
                <span class="text-xs font-black uppercase tracking-wider text-tosca-700 flex items-center gap-1.5">
                    <span>🎨</span> Warna & Kontras Layar
                </span>
                <div class="grid grid-cols-2 gap-2">
                    <button type="button" onclick="toggleHighContrast()" id="btnA11yContrast" class="p-3 bg-gray-50 hover:bg-gray-100 border border-gray-200 rounded-xl text-xs font-bold flex items-center gap-2 transition-all">
                        <span class="text-base">🌓</span>
                        <div class="text-left">
                            <div>Kontras Tinggi</div>
                            <div class="text-[10px] text-gray-500 font-normal">Hitam & Kuning WCAG</div>
                        </div>
                    </button>
                    <button type="button" onclick="toggleGrayscale()" id="btnA11yGrayscale" class="p-3 bg-gray-50 hover:bg-gray-100 border border-gray-200 rounded-xl text-xs font-bold flex items-center gap-2 transition-all">
                        <span class="text-base">🏁</span>
                        <div class="text-left">
                            <div>Monokrom</div>
                            <div class="text-[10px] text-gray-500 font-normal">Skala Abu-Abu</div>
                        </div>
                    </button>
                    <button type="button" onclick="toggleInvert()" id="btnA11yInvert" class="p-3 bg-gray-50 hover:bg-gray-100 border border-gray-200 rounded-xl text-xs font-bold flex items-center gap-2 transition-all">
                        <span class="text-base">🔄</span>
                        <div class="text-left">
                            <div>Balik Warna</div>
                            <div class="text-[10px] text-gray-500 font-normal">Invert Mode</div>
                        </div>
                    </button>
                    <button type="button" onclick="toggleDyslexicFont()" id="btnA11yDyslexic" class="p-3 bg-gray-50 hover:bg-gray-100 border border-gray-200 rounded-xl text-xs font-bold flex items-center gap-2 transition-all">
                        <span class="text-base">📖</span>
                        <div class="text-left">
                            <div>Font Disleksia</div>
                            <div class="text-[10px] text-gray-500 font-normal">Huruf Ramah Baca</div>
                        </div>
                    </button>
                </div>
            </div>

            <!-- 4. Alat Bantu Fokus & Membaca -->
            <div class="space-y-2">
                <span class="text-xs font-black uppercase tracking-wider text-tosca-700 flex items-center gap-1.5">
                    <span>📏</span> Alat Bantu Fokus & Navigasi
                </span>
                <div class="grid grid-cols-2 gap-2">
                    <button type="button" onclick="toggleReadingRuler()" id="btnA11yRuler" class="p-3 bg-gray-50 hover:bg-gray-100 border border-gray-200 rounded-xl text-xs font-bold flex items-center gap-2 transition-all">
                        <span class="text-base">📏</span>
                        <div class="text-left">
                            <div>Garis Panduan</div>
                            <div class="text-[10px] text-gray-500 font-normal">Fokus Per Baris</div>
                        </div>
                    </button>
                    <button type="button" onclick="toggleLargeSpacing()" id="btnA11ySpacing" class="p-3 bg-gray-50 hover:bg-gray-100 border border-gray-200 rounded-xl text-xs font-bold flex items-center gap-2 transition-all">
                        <span class="text-base">↔️</span>
                        <div class="text-left">
                            <div>Spasi Teks Lebar</div>
                            <div class="text-[10px] text-gray-500 font-normal">Jarak Baris Lega</div>
                        </div>
                    </button>
                    <button type="button" onclick="toggleHighlightLinks()" id="btnA11yHighlight" class="p-3 bg-gray-50 hover:bg-gray-100 border border-gray-200 rounded-xl text-xs font-bold flex items-center gap-2 transition-all">
                        <span class="text-base">🔗</span>
                        <div class="text-left">
                            <div>Sorot Tautan</div>
                            <div class="text-[10px] text-gray-500 font-normal">Tandai Link Aktif</div>
                        </div>
                    </button>
                    <button type="button" onclick="toggleBigCursor()" id="btnA11yCursor" class="p-3 bg-gray-50 hover:bg-gray-100 border border-gray-200 rounded-xl text-xs font-bold flex items-center gap-2 transition-all">
                        <span class="text-base">🖱️</span>
                        <div class="text-left">
                            <div>Kursor Besar</div>
                            <div class="text-[10px] text-gray-500 font-normal">Pointer Ekstra Jelas</div>
                        </div>
                    </button>
                </div>
            </div>

            <!-- 5. Bahasa & Terjemahan (Language Translation) -->
            <div class="space-y-2">
                <span class="text-xs font-black uppercase tracking-wider text-tosca-700 flex items-center gap-1.5">
                    <span>🌐</span> Pilihan Bahasa (Language Translation)
                </span>
                <div class="grid grid-cols-3 gap-2">
                    <button type="button" onclick="setLanguage('id', '🇮🇩', 'ID')" class="p-2.5 bg-gray-50 hover:bg-tosca-50 border border-gray-200 hover:border-tosca-300 rounded-xl text-xs font-bold text-center transition-all">
                        <div class="text-lg">🇮🇩</div>
                        <div class="text-[11px] mt-0.5 font-semibold">Indonesia</div>
                    </button>
                    <button type="button" onclick="setLanguage('en', '🇬🇧', 'EN')" class="p-2.5 bg-gray-50 hover:bg-tosca-50 border border-gray-200 hover:border-tosca-300 rounded-xl text-xs font-bold text-center transition-all">
                        <div class="text-lg">🇬🇧</div>
                        <div class="text-[11px] mt-0.5 font-semibold">English</div>
                    </button>
                    <button type="button" onclick="setLanguage('jw', 'ꦗ', 'JW')" class="p-2.5 bg-gray-50 hover:bg-tosca-50 border border-gray-200 hover:border-tosca-300 rounded-xl text-xs font-bold text-center transition-all">
                        <div class="text-lg">ꦗ</div>
                        <div class="text-[11px] mt-0.5 font-semibold">Basa Jawa</div>
                    </button>
                    <button type="button" onclick="setLanguage('ar', '🇸🇦', 'AR')" class="p-2.5 bg-gray-50 hover:bg-tosca-50 border border-gray-200 hover:border-tosca-300 rounded-xl text-xs font-bold text-center transition-all">
                        <div class="text-lg">🇸🇦</div>
                        <div class="text-[11px] mt-0.5 font-semibold">العربية</div>
                    </button>
                    <button type="button" onclick="setLanguage('zh-CN', '🇨🇳', 'ZH')" class="p-2.5 bg-gray-50 hover:bg-tosca-50 border border-gray-200 hover:border-tosca-300 rounded-xl text-xs font-bold text-center transition-all">
                        <div class="text-lg">🇨🇳</div>
                        <div class="text-[11px] mt-0.5 font-semibold">简体中文</div>
                    </button>
                    <button type="button" onclick="setLanguage('ja', '🇯🇵', 'JA')" class="p-2.5 bg-gray-50 hover:bg-tosca-50 border border-gray-200 hover:border-tosca-300 rounded-xl text-xs font-bold text-center transition-all">
                        <div class="text-lg">🇯🇵</div>
                        <div class="text-[11px] mt-0.5 font-semibold">日本語</div>
                    </button>
                </div>
            </div>

            <!-- 6. Opsi Tambahan -->
            <div class="space-y-2">
                <button type="button" onclick="toggleStopAnimations()" id="btnA11yAnimations" class="w-full p-3 bg-gray-50 hover:bg-gray-100 border border-gray-200 rounded-xl text-xs font-bold flex items-center justify-between transition-all">
                    <div class="flex items-center gap-2">
                        <span class="text-base">🛑</span>
                        <div class="text-left">
                            <div>Hentikan Efek Animasi & Kedip</div>
                            <div class="text-[10px] text-gray-500 font-normal">Ramah bagi penderita fotosensitif / vertigo</div>
                        </div>
                    </div>
                    <span id="badge-animations" class="text-[10px] font-bold text-gray-400">Nonaktif</span>
                </button>
            </div>
        </div>

        <!-- Panel Footer: Tombol Reset -->
        <div class="p-4 bg-gray-50 border-t border-gray-200 flex items-center justify-between">
            <span class="text-xs text-gray-500">Sesuai PermenPAN-RB & SPM</span>
            <button type="button" onclick="resetAllA11y()" class="px-4 py-2 bg-white hover:bg-red-50 text-red-600 hover:text-red-700 border border-gray-200 hover:border-red-300 font-bold text-xs rounded-xl transition-all shadow-sm flex items-center gap-1.5">
                <span>🔄</span> Reset Semua
            </button>
        </div>
    </div>

    <script>
        // ==========================================
        // FITUR AKSESIBILITAS & DISABILITAS LENGKAP
        // ==========================================

        // 1. Toggle Panel Widget Aksesibilitas
        function toggleA11yPanel() {
            const panel = document.getElementById('a11y-panel');
            const backdrop = document.getElementById('a11y-backdrop');
            if (panel && backdrop) {
                const isOpen = !panel.classList.contains('translate-x-full');
                if (isOpen) {
                    panel.classList.add('translate-x-full');
                    backdrop.classList.add('hidden');
                } else {
                    panel.classList.remove('translate-x-full');
                    backdrop.classList.remove('hidden');
                }
            }
        }

        // Pintasan Keyboard Alt + A untuk membuka Aksesibilitas
        window.addEventListener('keydown', function(e) {
            if (e.altKey && (e.key === 'a' || e.key === 'A')) {
                e.preventDefault();
                toggleA11yPanel();
            }
        });

        // 2. Pembaca Layar Suara (Text-to-Speech Web API)
        let currentUtterance = null;
        let isSpeaking = false;

        function updateTtsStatus(status, text) {
            const badge = document.getElementById('badge-tts');
            const bubble = document.getElementById('speech-status-bubble');
            const statusText = document.getElementById('speech-status-text');

            if (badge) {
                badge.textContent = status;
                badge.className = status === 'Berbunyi' 
                    ? 'text-[10px] px-2 py-0.5 rounded font-bold bg-emerald-100 text-emerald-800' 
                    : 'text-[10px] px-2 py-0.5 rounded font-bold bg-gray-100 text-gray-500';
            }

            if (bubble && statusText) {
                if (status === 'Berbunyi') {
                    bubble.classList.remove('hidden');
                    statusText.textContent = text || 'Membacakan konten...';
                } else {
                    bubble.classList.add('hidden');
                }
            }
        }

        function speakText(text) {
            if (!('speechSynthesis' in window)) {
                alert('Peramban Anda tidak mendukung fitur sintesis suara (Text-to-Speech).');
                return;
            }

            window.speechSynthesis.cancel();

            if (!text || text.trim() === '') {
                text = "Tidak ada teks yang dapat dibacakan.";
            }

            const cleanText = text.replace(/<[^>]*>?/gm, ' ').replace(/\s+/g, ' ').trim();
            currentUtterance = new SpeechSynthesisUtterance(cleanText);

            // Sesuaikan bahasa narasi suara dengan bahasa yang sedang dipilih
            const currentLang = localStorage.getItem('ppid_lang_code') || 'id';
            const langMap = {
                'id': 'id-ID',
                'en': 'en-US',
                'jw': 'id-ID',
                'ar': 'ar-SA',
                'zh-CN': 'zh-CN',
                'ja': 'ja-JP'
            };
            currentUtterance.lang = langMap[currentLang] || 'id-ID';
            currentUtterance.rate = 0.95; // Kecepatan nyaman untuk pendengar
            currentUtterance.pitch = 1.0;

            currentUtterance.onstart = function() {
                isSpeaking = true;
                updateTtsStatus('Berbunyi', 'Membacakan konten...');
            };

            currentUtterance.onend = function() {
                isSpeaking = false;
                updateTtsStatus('Standby');
            };

            currentUtterance.onerror = function() {
                isSpeaking = false;
                updateTtsStatus('Standby');
            };

            window.speechSynthesis.speak(currentUtterance);
        }

        function startSpeech() {
            // Prioritaskan membaca teks yang sedang diseleksi / diblok mouse
            const selectedText = window.getSelection().toString();
            if (selectedText && selectedText.trim().length > 0) {
                speakText(selectedText);
                return;
            }

            // Jika tidak ada seleksi, bacakan konten utama halaman
            const mainContent = document.querySelector('main') || document.body;
            speakText(mainContent.innerText);
        }

        function stopSpeech() {
            if ('speechSynthesis' in window) {
                window.speechSynthesis.cancel();
            }
            isSpeaking = false;
            updateTtsStatus('Standby');
        }

        // 3. Pengaturan Ukuran Huruf (Font Sizing)
        let currentFontSizeLevel = parseInt(localStorage.getItem('ppid_font_level') || '0');

        function applyFontSize(level) {
            currentFontSizeLevel = Math.max(-2, Math.min(3, level));
            localStorage.setItem('ppid_font_level', currentFontSizeLevel);
            const sizes = { '-2': '13px', '-1': '14.5px', '0': '16px', '1': '17.5px', '2': '19px', '3': '21px' };
            document.documentElement.style.fontSize = sizes[currentFontSizeLevel] || '16px';
        }

        function adjustFontSize(delta) {
            applyFontSize(currentFontSizeLevel + delta);
        }

        function resetFontSize() {
            applyFontSize(0);
        }

        // 4. Pengaturan Mode Kontras & Visual
        function updateButtonVisual(id, isActive) {
            const btn = document.getElementById(id);
            if (btn) {
                if (isActive) {
                    btn.classList.add('bg-tosca-100', 'border-tosca-400', 'text-tosca-900', 'shadow-sm');
                    btn.classList.remove('bg-gray-50', 'border-gray-200');
                } else {
                    btn.classList.remove('bg-tosca-100', 'border-tosca-400', 'text-tosca-900', 'shadow-sm');
                    btn.classList.add('bg-gray-50', 'border-gray-200');
                }
            }
        }

        function toggleHighContrast() {
            const isHighContrast = document.documentElement.classList.toggle('high-contrast');
            localStorage.setItem('ppid_high_contrast', isHighContrast ? 'true' : 'false');
            updateButtonVisual('btnA11yContrast', isHighContrast);
        }

        function toggleGrayscale() {
            const isGrayscale = document.documentElement.classList.toggle('grayscale-mode');
            localStorage.setItem('ppid_grayscale', isGrayscale ? 'true' : 'false');
            updateButtonVisual('btnA11yGrayscale', isGrayscale);
        }

        function toggleInvert() {
            const isInvert = document.documentElement.classList.toggle('invert-mode');
            localStorage.setItem('ppid_invert', isInvert ? 'true' : 'false');
            updateButtonVisual('btnA11yInvert', isInvert);
        }

        function toggleDyslexicFont() {
            const isDyslexic = document.documentElement.classList.toggle('dyslexic-font');
            localStorage.setItem('ppid_dyslexic', isDyslexic ? 'true' : 'false');
            updateButtonVisual('btnA11yDyslexic', isDyslexic);
        }

        function toggleLargeSpacing() {
            const isLargeSpacing = document.documentElement.classList.toggle('large-spacing');
            localStorage.setItem('ppid_large_spacing', isLargeSpacing ? 'true' : 'false');
            updateButtonVisual('btnA11ySpacing', isLargeSpacing);
        }

        function toggleHighlightLinks() {
            const isHighlight = document.documentElement.classList.toggle('highlight-links');
            localStorage.setItem('ppid_highlight_links', isHighlight ? 'true' : 'false');
            updateButtonVisual('btnA11yHighlight', isHighlight);
        }

        function toggleBigCursor() {
            const isBigCursor = document.documentElement.classList.toggle('big-cursor');
            localStorage.setItem('ppid_big_cursor', isBigCursor ? 'true' : 'false');
            updateButtonVisual('btnA11yCursor', isBigCursor);
        }

        function toggleStopAnimations() {
            const isStop = document.documentElement.classList.toggle('stop-animations');
            localStorage.setItem('ppid_stop_animations', isStop ? 'true' : 'false');
            const badge = document.getElementById('badge-animations');
            if (badge) {
                badge.textContent = isStop ? 'Aktif' : 'Nonaktif';
                badge.className = isStop ? 'text-[10px] font-bold text-red-600' : 'text-[10px] font-bold text-gray-400';
            }
        }

        // 5. Garis Panduan Membaca (Reading Ruler)
        let isRulerActive = false;
        function toggleReadingRuler() {
            const ruler = document.getElementById('reading-ruler');
            isRulerActive = !isRulerActive;
            localStorage.setItem('ppid_reading_ruler', isRulerActive ? 'true' : 'false');

            if (ruler) {
                ruler.style.display = isRulerActive ? 'block' : 'none';
            }
            updateButtonVisual('btnA11yRuler', isRulerActive);
        }

        window.addEventListener('mousemove', function(e) {
            if (isRulerActive) {
                const ruler = document.getElementById('reading-ruler');
                if (ruler) {
                    ruler.style.top = (e.clientY - 18) + 'px';
                }
            }
        });

        // 6. Reset Semua Pengaturan Aksesibilitas
        function resetAllA11y() {
            stopSpeech();
            resetFontSize();

            const classesToRemove = [
                'high-contrast',
                'grayscale-mode',
                'invert-mode',
                'dyslexic-font',
                'large-spacing',
                'highlight-links',
                'big-cursor',
                'stop-animations'
            ];
            classesToRemove.forEach(cls => document.documentElement.classList.remove(cls));

            const keysToRemove = [
                'ppid_high_contrast',
                'ppid_grayscale',
                'ppid_invert',
                'ppid_dyslexic',
                'ppid_large_spacing',
                'ppid_highlight_links',
                'ppid_big_cursor',
                'ppid_stop_animations',
                'ppid_reading_ruler',
                'ppid_font_level'
            ];
            keysToRemove.forEach(k => localStorage.removeItem(k));

            isRulerActive = false;
            const ruler = document.getElementById('reading-ruler');
            if (ruler) ruler.style.display = 'none';

            // Reset visual buttons
            ['btnA11yContrast', 'btnA11yGrayscale', 'btnA11yInvert', 'btnA11yDyslexic', 'btnA11ySpacing', 'btnA11yHighlight', 'btnA11yCursor', 'btnA11yRuler'].forEach(id => {
                updateButtonVisual(id, false);
            });

            const badge = document.getElementById('badge-animations');
            if (badge) {
                badge.textContent = 'Nonaktif';
                badge.className = 'text-[10px] font-bold text-gray-400';
            }
        }

        // Inisialisasi saat Halaman Dimuat
        document.addEventListener('DOMContentLoaded', function() {
            // Restore High Contrast
            if (localStorage.getItem('ppid_high_contrast') === 'true') {
                document.documentElement.classList.add('high-contrast');
                updateButtonVisual('btnA11yContrast', true);
            }

            // Restore Grayscale
            if (localStorage.getItem('ppid_grayscale') === 'true') {
                document.documentElement.classList.add('grayscale-mode');
                updateButtonVisual('btnA11yGrayscale', true);
            }

            // Restore Invert
            if (localStorage.getItem('ppid_invert') === 'true') {
                document.documentElement.classList.add('invert-mode');
                updateButtonVisual('btnA11yInvert', true);
            }

            // Restore Dyslexic Font
            if (localStorage.getItem('ppid_dyslexic') === 'true') {
                document.documentElement.classList.add('dyslexic-font');
                updateButtonVisual('btnA11yDyslexic', true);
            }

            // Restore Large Spacing
            if (localStorage.getItem('ppid_large_spacing') === 'true') {
                document.documentElement.classList.add('large-spacing');
                updateButtonVisual('btnA11ySpacing', true);
            }

            // Restore Highlight Links
            if (localStorage.getItem('ppid_highlight_links') === 'true') {
                document.documentElement.classList.add('highlight-links');
                updateButtonVisual('btnA11yHighlight', true);
            }

            // Restore Big Cursor
            if (localStorage.getItem('ppid_big_cursor') === 'true') {
                document.documentElement.classList.add('big-cursor');
                updateButtonVisual('btnA11yCursor', true);
            }

            // Restore Stop Animations
            if (localStorage.getItem('ppid_stop_animations') === 'true') {
                document.documentElement.classList.add('stop-animations');
                const badge = document.getElementById('badge-animations');
                if (badge) {
                    badge.textContent = 'Aktif';
                    badge.className = 'text-[10px] font-bold text-red-600';
                }
            }

            // Restore Reading Ruler
            if (localStorage.getItem('ppid_reading_ruler') === 'true') {
                isRulerActive = true;
                const ruler = document.getElementById('reading-ruler');
                if (ruler) ruler.style.display = 'block';
                updateButtonVisual('btnA11yRuler', true);
            }

            // Restore Font Size
            if (currentFontSizeLevel !== 0) {
                applyFontSize(currentFontSizeLevel);
            }

            // Restore Selected Language UI
            const savedLangCode = localStorage.getItem('ppid_lang_code') || 'id';
            const savedLangFlag = localStorage.getItem('ppid_lang_flag') || '🇮🇩';
            const savedLangLabel = localStorage.getItem('ppid_lang_label') || 'ID';
            updateLangUI(savedLangFlag, savedLangLabel);

            // Mobile menu listener
            const btn = document.getElementById('mobile-menu-button');
            const panel = document.getElementById('mobile-menu-panel');
            const iconMenu = document.getElementById('icon-menu');
            const iconClose = document.getElementById('icon-close');

            if (btn && panel) {
                btn.addEventListener('click', () => {
                    panel.classList.toggle('hidden');
                    iconMenu.classList.toggle('hidden');
                    iconClose.classList.toggle('hidden');
                });
            }
        });

        // ==========================================
        // FITUR MULTI-BAHASA (MULTI-LANGUAGE SWITCHER)
        // ==========================================
        function updateLangUI(flag, code) {
            const flagEl = document.getElementById('current-lang-flag');
            const codeEl = document.getElementById('current-lang-code');
            const mobileEl = document.getElementById('current-lang-mobile');

            if (flagEl) flagEl.textContent = flag;
            if (codeEl) codeEl.textContent = code;
            if (mobileEl) mobileEl.textContent = `${flag} ${code}`;
        }

        function eraseCookie(name) {
            document.cookie = name + '=; Max-Age=-99999999; path=/;';
            const host = window.location.hostname;
            document.cookie = name + `=; Max-Age=-99999999; domain=.${host}; path=/;`;
            document.cookie = name + `=; Max-Age=-99999999; domain=${host}; path=/;`;
        }

        function setLanguage(langCode, flag, code) {
            localStorage.setItem('ppid_lang_code', langCode);
            localStorage.setItem('ppid_lang_flag', flag);
            localStorage.setItem('ppid_lang_label', code);

            updateLangUI(flag, code);

            if (langCode === 'id') {
                eraseCookie('googtrans');
                const select = document.querySelector('.goog-te-combo');
                if (select) {
                    select.value = 'id';
                    select.dispatchEvent(new Event('change'));
                }
                window.location.reload();
                return;
            }

            const host = window.location.hostname;
            document.cookie = `googtrans=/id/${langCode}; path=/;`;
            document.cookie = `googtrans=/id/${langCode}; domain=.${host}; path=/;`;
            document.cookie = `googtrans=/id/${langCode}; domain=${host}; path=/;`;

            const select = document.querySelector('.goog-te-combo');
            if (select) {
                select.value = langCode;
                select.dispatchEvent(new Event('change'));
            } else {
                window.location.reload();
            }
        }

        // Inisialisasi Google Website Translator Resmi
        function googleTranslateElementInit() {
            if (window.google && window.google.translate) {
                new google.translate.TranslateElement({
                    pageLanguage: 'id',
                    includedLanguages: 'id,en,jw,ar,zh-CN,ja',
                    autoDisplay: false
                }, 'google_translate_element');
            }
        }
    </script>

    <!-- Kontainer Elemen Penerjemah (Tersembunyi di background) -->
    <div id="google_translate_element" class="hidden"></div>
    <script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit" async defer></script>
</body>

</html>
