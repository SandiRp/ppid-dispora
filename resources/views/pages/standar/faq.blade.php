@extends('layouts.app')

@section('title', 'Tanya Jawab (FAQ) & Kebijakan Privasi - PPID Dispora Jatim')

@section('content')
    <div class="max-w-4xl mx-auto space-y-8">

        <div class="pb-6 border-b border-gray-200">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-tosca-100 text-tosca-800 mb-2">
                Pusat Bantuan & Perlindungan Data Pribadi
            </span>
            <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-2">Tanya Jawab Umum (FAQ)</h1>
            <p class="text-gray-500 text-sm">Jawaban atas pertanyaan yang paling sering diajukan masyarakat mengenai layanan keterbukaan informasi PPID Dispora Jatim.</p>
        </div>

        <!-- Daftar FAQ Accordion -->
        <div class="space-y-4">
            @php
                $faqs = [
                    [
                        'q' => 'Apa saja syarat untuk mengajukan permohonan informasi publik?',
                        'a' => 'Pemohon wajib mengisi formulir permohonan secara lengkap, menyertakan Nomor Induk Kependudukan (NIK)/identitas yang sah, alamat email aktif, nomor WhatsApp/telepon, rincian informasi yang dibutuhkan, tujuan penggunaan, serta melampirkan hasil pindai (scan/foto) KTP bagi pemohon perorangan atau surat pengantar + akta bagi lembaga/badan hukum.'
                    ],
                    [
                        'q' => 'Berapa biaya yang dikenakan untuk mengajukan permohonan informasi?',
                        'a' => 'Pelayanan permohonan dan penyediaan informasi publik secara digital/elektronik di PPID Dispora Jatim adalah GRATIS (Rp 0,-). Biaya hanya dikenakan apabila pemohon meminta salinan cetak/fotokopi fisik atau pengiriman pos secara wajar sesuai tarif resmi.'
                    ],
                    [
                        'q' => 'Berapa lama permohonan informasi saya diproses?',
                        'a' => 'Sesuai Pasal 22 UU KIP, PPID memberikan tanggapan tertulis maksimal 10 (sepuluh) hari kerja sejak permohonan diterima secara lengkap, dan dapat diperpanjang paling lama 7 (tujuh) hari kerja berikutnya dengan pemberitahuan alasan perpanjangan kepada pemohon.'
                    ],
                    [
                        'q' => 'Mengapa saya harus memasukkan Nomor Registrasi DAN NIK saat melacak status?',
                        'a' => 'Penerapan verifikasi ganda (Nomor Registrasi + NIK Pemohon) bertujuan melindungi privasi pemohon dan memastikan dokumen jawaban resmi hanya dapat dilihat serta diunduh oleh pemohon yang bersangkutan sesuai amanat UU No. 27 Tahun 2022 tentang Perlindungan Data Pribadi (UU PDP).'
                    ],
                    [
                        'q' => 'Apakah tersedia layanan khusus bagi penyandang disabilitas?',
                        'a' => 'Ya. Selain fitur aksesibilitas digital di website (pembaca layar suara Bahasa Indonesia, mode kontras tinggi WCAG AAA, font ramah disleksia, pengatur ukuran teks, dsb.), pemohon dapat mencentang opsi "Layanan Ramah Disabilitas" pada formulir permohonan untuk mendapatkan layanan prioritas serta pilihan format jawaban khusus seperti audio, huruf besar/braille, atau pendampingan langsung petugas.'
                    ],
                    [
                        'q' => 'Apa yang harus dilakukan jika permohonan saya ditolak atau melewati batas waktu?',
                        'a' => 'Anda berhak mengajukan Keberatan secara tertulis kepada Atasan PPID melalui menu Pengajuan Keberatan dalam jangka waktu 30 hari kerja. Atasan PPID wajib menanggapi keberatan Anda maksimal dalam 30 hari kerja.'
                    ],
                ];
            @endphp

            @foreach ($faqs as $idx => $faq)
                <details class="group bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden" {{ $idx === 0 ? 'open' : '' }}>
                    <summary class="flex items-center justify-between p-5 cursor-pointer font-bold text-gray-900 text-sm hover:bg-tosca-50/40 transition-colors list-none">
                        <span>{{ $idx + 1 }}. {{ $faq['q'] }}</span>
                        <svg class="w-5 h-5 text-tosca-600 transition-transform group-open:rotate-180 shrink-0 ml-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </summary>
                    <div class="px-5 pb-5 pt-1 text-xs md:text-sm text-gray-600 leading-relaxed border-t border-gray-50">
                        {{ $faq['a'] }}
                    </div>
                </details>
            @endforeach
        </div>

        <!-- Kebijakan Privasi & Perlindungan Data Pribadi -->
        <div class="bg-white rounded-3xl p-6 md:p-8 border border-tosca-200 shadow-sm space-y-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-tosca-100 text-tosca-700 font-bold flex items-center justify-center">🔒</div>
                <div>
                    <h2 class="text-lg font-bold text-gray-900">Kebijakan Privasi & Perlindungan Data Pemohon</h2>
                    <span class="text-xs text-tosca-600 font-semibold">Kepatuhan UU No. 27 Tahun 2022 tentang Pelindungan Data Pribadi (UU PDP)</span>
                </div>
            </div>
            <div class="text-xs md:text-sm text-gray-700 space-y-2 leading-relaxed">
                <p>1. <strong>Tujuan Pengumpulan Data:</strong> Data pribadi berupa Nama, NIK, Email, Nomor Telepon, dan scan dokumen identitas (KTP) dikumpulkan semata-mata untuk kepentingan registrasi resmi dan verifikasi keabsahan pemohon informasi publik sesuai Perki No. 1 Tahun 2021.</p>
                <p>2. <strong>Penyimpanan Privat Terproteksi:</strong> Seluruh berkas identitas KTP pemohon dan dokumen jawaban disimpan pada direktori server privat (non-publik) yang tidak dapat diakses dari URL bebas tanpa autentikasi petugas atau verifikasi ganda Nomor Registrasi dan NIK.</p>
                <p>3. <strong>Kerahasiaan Identitas:</strong> PPID Dispora Jawa Timur dilarang memperjualbelikan atau membagikan data pribadi pemohon kepada pihak ketiga di luar kepentingan administrasi keterbukaan informasi dan penyelesaian sengketa di Komisi Informasi.</p>
            </div>
        </div>
    </div>
@endsection
