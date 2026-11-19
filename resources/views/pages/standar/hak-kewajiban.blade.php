@extends('layouts.app')

@section('title', 'Hak & Kewajiban Pemohon dan Badan Publik - PPID Dispora Jatim')

@section('content')
    <div class="max-w-5xl mx-auto space-y-8">

        <div class="pb-6 border-b border-gray-200">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-tosca-100 text-tosca-800 mb-2">
                UU No. 14 Tahun 2008 tentang Keterbukaan Informasi Publik
            </span>
            <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-2">Hak & Kewajiban</h1>
            <p class="text-gray-500 text-sm">Ketentuan hak dan kewajiban Pemohon Informasi Publik serta Badan Publik dalam penyelenggaraan pelayanan keterbukaan informasi di PPID Dispora Provinsi Jawa Timur.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Hak Pemohon -->
            <div class="bg-white rounded-3xl p-6 md:p-8 border border-tosca-100 shadow-sm space-y-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-tosca-100 text-tosca-700 font-black flex items-center justify-center text-lg">✓</div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-900">Hak Pemohon Informasi Publik</h2>
                        <span class="text-xs text-tosca-600 font-semibold">Pasal 4 UU KIP</span>
                    </div>
                </div>
                <ul class="space-y-3 text-sm text-gray-700 leading-relaxed list-disc pl-5">
                    <li>Setiap orang berhak memperoleh Informasi Publik sesuai dengan ketentuan Undang-Undang KIP.</li>
                    <li>Setiap orang berhak <strong>melihat dan mengetahui</strong> Informasi Publik.</li>
                    <li>Menghadiri pertemuan publik yang terbuka untuk umum guna memperoleh Informasi Publik.</li>
                    <li>Mendapatkan salinan Informasi Publik melalui permohonan sesuai ketentuan hukum yang berlaku.</li>
                    <li>Menyebarluaskan Informasi Publik sesuai dengan peraturan perundang-undangan.</li>
                    <li>Mengajukan permintaan Informasi Publik disertai alasan permintaan tersebut.</li>
                    <li>Mengajukan gugatan ke pengadilan maupun keberatan/sengketa ke Komisi Informasi apabila dalam memperoleh Informasi Publik mendapat hambatan atau kegagalan.</li>
                </ul>
            </div>

            <!-- Kewajiban Pengguna Informasi -->
            <div class="bg-white rounded-3xl p-6 md:p-8 border border-amber-100 shadow-sm space-y-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-700 font-black flex items-center justify-center text-lg">!</div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-900">Kewajiban Pengguna Informasi Publik</h2>
                        <span class="text-xs text-amber-700 font-semibold">Pasal 5 UU KIP</span>
                    </div>
                </div>
                <ul class="space-y-3 text-sm text-gray-700 leading-relaxed list-disc pl-5">
                    <li>Pengguna Informasi Publik wajib menggunakan Informasi Publik sesuai dengan ketentuan peraturan perundang-undangan.</li>
                    <li>Pengguna Informasi Publik wajib <strong>mencantumkan sumber</strong> dari mana ia memperoleh Informasi Publik, baik yang digunakan untuk kepentingan sendiri maupun untuk keperluan publikasi sesuai peraturan yang berlaku.</li>
                    <li>Menyertakan identitas diri yang sah dan benar pada saat mengajukan permohonan informasi publik.</li>
                </ul>
            </div>

            <!-- Hak Badan Publik -->
            <div class="bg-white rounded-3xl p-6 md:p-8 border border-blue-100 shadow-sm space-y-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-700 font-black flex items-center justify-center text-lg">🏛️</div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-900">Hak Badan Publik (PPID)</h2>
                        <span class="text-xs text-blue-700 font-semibold">Pasal 6 UU KIP</span>
                    </div>
                </div>
                <ul class="space-y-3 text-sm text-gray-700 leading-relaxed list-disc pl-5">
                    <li>Badan Publik berhak <strong>menolak memberikan informasi yang dikecualikan</strong> sesuai dengan ketentuan peraturan perundang-undangan (berdasarkan Uji Konsekuensi).</li>
                    <li>Badan Publik berhak menolak memberikan Informasi Publik apabila tidak sesuai dengan ketentuan peraturan perundang-undangan.</li>
                    <li>Informasi Publik yang tidak dapat diberikan meliputi informasi yang dapat membahayakan negara, menghambat proses penegakan hukum, melanggar hak atas kekayaan intelektual, atau mengungkap rahasia pribadi.</li>
                </ul>
            </div>

            <!-- Kewajiban Badan Publik -->
            <div class="bg-white rounded-3xl p-6 md:p-8 border border-emerald-100 shadow-sm space-y-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-700 font-black flex items-center justify-center text-lg">📋</div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-900">Kewajiban Badan Publik (PPID)</h2>
                        <span class="text-xs text-emerald-700 font-semibold">Pasal 7 UU KIP</span>
                    </div>
                </div>
                <ul class="space-y-3 text-sm text-gray-700 leading-relaxed list-disc pl-5">
                    <li>Wajib menyediakan, memberikan, dan/atau menerbitkan Informasi Publik yang berada di bawah kewenangannya kepada Pemohon Informasi Publik, selain informasi yang dikecualikan.</li>
                    <li>Wajib menyediakan Informasi Publik yang <strong>akurat, benar, dan tidak menyesatkan</strong>.</li>
                    <li>Membangun dan mengembangkan sistem informasi dan dokumentasi untuk mengelola Informasi Publik secara baik dan efisien sehingga dapat diakses dengan mudah.</li>
                    <li>Membuat pertimbangan secara tertulis setiap kebijakan yang diambil untuk memenuhi hak setiap orang atas Informasi Publik.</li>
                </ul>
            </div>
        </div>
    </div>
@endsection
