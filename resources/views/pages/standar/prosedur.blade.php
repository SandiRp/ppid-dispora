@extends('layouts.app')

@section('title', 'Standar Prosedur, Waktu & Biaya Layanan - PPID Dispora Jatim')

@section('content')
    <div class="max-w-5xl mx-auto space-y-8">

        <div class="pb-6 border-b border-gray-200">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-tosca-100 text-tosca-800 mb-2">
                Standar Pelayanan Informasi Publik
            </span>
            <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-2">Prosedur, Waktu & Biaya Layanan</h1>
            <p class="text-gray-500 text-sm">Tata cara pengajuan permohonan informasi publik, pengajuan keberatan, penyelesaian sengketa, standar jangka waktu, dan biaya layanan sesuai UU No. 14 Tahun 2008 & Perki No. 1 Tahun 2021.</p>
        </div>

        <!-- 1. Maklumat Biaya / Tarif Layanan (GRATIS) -->
        <div class="bg-gradient-to-r from-emerald-600 to-tosca-600 text-white rounded-3xl p-6 md:p-8 shadow-lg flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="space-y-2">
                <span class="inline-block px-3 py-1 bg-white/20 rounded-full text-xs font-bold uppercase tracking-wider">Maklumat Biaya / Tarif Pelayanan</span>
                <h2 class="text-2xl md:text-3xl font-black">GRATIS (Rp 0,-)</h2>
                <p class="text-sm text-emerald-50 max-w-2xl leading-relaxed">
                    PPID Dinas Kepemudaan dan Olahraga Provinsi Jawa Timur <strong>tidak memungut biaya apa pun</strong> atas pelayanan permohonan dan penyediaan informasi publik dalam bentuk digital/elektronik. Apabila pemohon menghendaki penggandaan/fotokopi salinan dokumen fisik atau pengiriman pos, biaya penggandaan/pengiriman ditanggung secara wajar oleh pemohon sesuai ketentuan standar biaya yang berlaku.
                </p>
            </div>
            <div class="shrink-0 bg-white/15 backdrop-blur-sm p-5 rounded-2xl text-center border border-white/20">
                <div class="text-3xl font-black">Rp 0</div>
                <div class="text-xs text-emerald-100 font-semibold mt-1">Tanpa Pungutan Liar</div>
            </div>
        </div>

        <!-- 2. Alur Permohonan Informasi Publik -->
        <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-gray-100 space-y-6">
            <div>
                <h2 class="text-xl font-bold text-gray-900">A. Mekanisme & Tata Cara Permohonan Informasi</h2>
                <p class="text-xs text-gray-500 mt-1">Pemohon dapat mengajukan permintaan informasi secara daring (online) melalui website ini maupun luring (datang langsung ke Meja Layanan PPID).</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="p-4 bg-tosca-50/70 border border-tosca-100 rounded-2xl space-y-2">
                    <div class="w-8 h-8 rounded-full bg-tosca-600 text-white font-black text-sm flex items-center justify-center">1</div>
                    <h3 class="font-bold text-sm text-gray-900">Pengajuan Permohonan</h3>
                    <p class="text-xs text-gray-600 leading-relaxed">Pemohon mengisi formulir online atau meja layanan dengan melampirkan identitas diri (KTP/SIM/Paspor atau Akta Lembaga).</p>
                </div>
                <div class="p-4 bg-tosca-50/70 border border-tosca-100 rounded-2xl space-y-2">
                    <div class="w-8 h-8 rounded-full bg-tosca-600 text-white font-black text-sm flex items-center justify-center">2</div>
                    <h3 class="font-bold text-sm text-gray-900">Registrasi & Verifikasi</h3>
                    <p class="text-xs text-gray-600 leading-relaxed">Sistem menerbitkan <strong>Nomor Registrasi</strong> resmi. Petugas PPID memverifikasi kelengkapan berkas & klasifikasi informasi.</p>
                </div>
                <div class="p-4 bg-tosca-50/70 border border-tosca-100 rounded-2xl space-y-2">
                    <div class="w-8 h-8 rounded-full bg-tosca-600 text-white font-black text-sm flex items-center justify-center">3</div>
                    <h3 class="font-bold text-sm text-gray-900">Pemberitahuan Tertulis</h3>
                    <p class="text-xs text-gray-600 leading-relaxed">Maksimal <strong>10 hari kerja</strong> sejak permohonan diterima lengkap, PPID menyampaikan pemberitahuan status (dapat diperpanjang +7 hari kerja dengan alasan tertulis).</p>
                </div>
                <div class="p-4 bg-tosca-50/70 border border-tosca-100 rounded-2xl space-y-2">
                    <div class="w-8 h-8 rounded-full bg-emerald-600 text-white font-black text-sm flex items-center justify-center">4</div>
                    <h3 class="font-bold text-sm text-gray-900">Penyerahan Informasi</h3>
                    <p class="text-xs text-gray-600 leading-relaxed">Berkas jawaban dapat diunduh melalui menu Lacak Status (verifikasi ganda NIK + No. Registrasi) atau diambil langsung di kantor.</p>
                </div>
            </div>

            <div class="flex flex-wrap gap-3 pt-2">
                <a href="{{ route('permohonan.create') }}" class="px-5 py-2.5 bg-tosca-600 hover:bg-tosca-700 text-white text-xs font-bold rounded-xl shadow transition-all">
                    Ajukan Permohonan Online &rarr;
                </a>
                <a href="{{ route('permohonan.lacak') }}" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-800 text-xs font-bold rounded-xl transition-all">
                    Lacak Status Permohonan
                </a>
            </div>
        </div>

        <!-- 3. Standar Jangka Waktu Penyelesaian (SLA) -->
        <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-gray-100 space-y-4">
            <h2 class="text-xl font-bold text-gray-900">B. Standar Jangka Waktu Pelayanan (UU No. 14/2008)</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm border border-gray-200 rounded-xl overflow-hidden">
                    <thead class="bg-gray-50 text-gray-800 text-xs uppercase">
                        <tr>
                            <th class="py-3 px-4 border-b">Tahapan Pelayanan</th>
                            <th class="py-3 px-4 border-b">Batas Waktu Maksimal</th>
                            <th class="py-3 px-4 border-b">Dasar Hukum</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-xs text-gray-700">
                        <tr>
                            <td class="py-3 px-4 font-semibold">Tanggapan Awal Permohonan Informasi</td>
                            <td class="py-3 px-4 font-bold text-tosca-700">10 Hari Kerja</td>
                            <td class="py-3 px-4">Pasal 22 ayat (7) UU KIP</td>
                        </tr>
                        <tr>
                            <td class="py-3 px-4 font-semibold">Perpanjangan Waktu Penyampaian Jawaban</td>
                            <td class="py-3 px-4 font-bold text-amber-700">+7 Hari Kerja (Total 17 Hari Kerja)</td>
                            <td class="py-3 px-4">Pasal 22 ayat (8) UU KIP</td>
                        </tr>
                        <tr>
                            <td class="py-3 px-4 font-semibold">Batas Pengajuan Keberatan oleh Pemohon</td>
                            <td class="py-3 px-4 font-bold text-blue-700">30 Hari Kerja setelah alasan ditemukan</td>
                            <td class="py-3 px-4">Pasal 35 ayat (2) UU KIP</td>
                        </tr>
                        <tr>
                            <td class="py-3 px-4 font-semibold">Tanggapan Tertulis Atasan PPID atas Keberatan</td>
                            <td class="py-3 px-4 font-bold text-red-700">30 Hari Kerja sejak keberatan dicatat</td>
                            <td class="py-3 px-4">Pasal 36 ayat (1) UU KIP</td>
                        </tr>
                        <tr>
                            <td class="py-3 px-4 font-semibold">Pengajuan Sengketa ke Komisi Informasi (KI)</td>
                            <td class="py-3 px-4 font-bold text-gray-900">14 Hari Kerja setelah tanggapan Atasan PPID diterima</td>
                            <td class="py-3 px-4">Pasal 37 ayat (2) UU KIP</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- 4. Tata Cara Pengajuan Keberatan & Sengketa -->
        <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-gray-100 space-y-4">
            <h2 class="text-xl font-bold text-gray-900">C. Prosedur Pengajuan Keberatan & Penyelesaian Sengketa</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-xs text-gray-700 leading-relaxed">
                <div class="p-5 bg-red-50/60 border border-red-100 rounded-2xl space-y-2">
                    <h3 class="font-bold text-sm text-red-900">1. Keberatan kepada Atasan PPID</h3>
                    <p>Pemohon berhak mengajukan keberatan secara tertulis kepada Atasan PPID (Kepala Dinas Kepemudaan dan Olahraga Prov. Jatim) apabila:</p>
                    <ul class="list-disc pl-5 space-y-1">
                        <li>Permohonan informasi ditolak tanpa alasan yang sah;</li>
                        <li>Informasi berkala tidak disediakan;</li>
                        <li>Permintaan informasi tidak ditanggapi melewati batas waktu;</li>
                        <li>Informasi diberikan tidak sesuai yang diminta; atau</li>
                        <li>Pengenaan biaya penyalinan dinilai tidak wajar.</li>
                    </ul>
                    <div class="pt-2">
                        <a href="{{ route('keberatan.create') }}" class="inline-block px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl transition-colors">
                            Ajukan Keberatan Online &rarr;
                        </a>
                    </div>
                </div>
                <div class="p-5 bg-gray-50 border border-gray-200 rounded-2xl space-y-2">
                    <h3 class="font-bold text-sm text-gray-900">2. Penyelesaian Sengketa ke Komisi Informasi</h3>
                    <p>Jika dalam jangka waktu <strong>30 hari kerja</strong> Atasan PPID tidak memberikan tanggapan atau pemohon tidak puas terhadap tanggapan tertulis Atasan PPID, pemohon berhak mengajukan permohonan penyelesaian sengketa informasi publik kepada:</p>
                    <div class="p-3 bg-white border border-gray-200 rounded-xl mt-2 space-y-1">
                        <div class="font-bold text-gray-900">Komisi Informasi Provinsi Jawa Timur</div>
                        <div>Jl. Kusuma Bangsa No. 60, Surabaya, Jawa Timur</div>
                        <a href="https://komisiinformasi.jatimprov.go.id" target="_blank" rel="noopener" class="text-tosca-600 font-semibold hover:underline inline-block mt-1">
                            komisiinformasi.jatimprov.go.id &nearr;
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
