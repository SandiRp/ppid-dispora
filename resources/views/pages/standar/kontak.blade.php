@extends('layouts.app')

@section('title', 'Kontak, Jam Layanan & Kanal Pengaduan - PPID Dispora Jatim')

@section('content')
    <div class="max-w-6xl mx-auto space-y-8">

        <div class="pb-6 border-b border-gray-200">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-tosca-100 text-tosca-800 mb-2">
                Meja Layanan Informasi Publik
            </span>
            <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-2">Kontak, Lokasi & Pengaduan</h1>
            <p class="text-gray-500 text-sm">Alamat resmi meja layanan tatap muka PPID Dinas Kepemudaan dan Olahraga Provinsi Jawa Timur serta kanal pengaduan resmi pemerintah.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Kartu Informasi Kontak & Jam Layanan -->
            <div class="bg-white rounded-3xl p-6 md:p-8 border border-gray-100 shadow-sm space-y-6">
                <div class="space-y-4">
                    <h2 class="text-lg font-bold text-gray-900">Alamat & Jam Operasional Meja Layanan</h2>

                    <div class="flex items-start gap-3">
                        <div class="w-9 h-9 rounded-xl bg-tosca-50 text-tosca-700 flex items-center justify-center shrink-0">📍</div>
                        <div class="text-sm text-gray-700">
                            <div class="font-bold text-gray-900">Dinas Kepemudaan dan Olahraga Provinsi Jawa Timur</div>
                            <p class="text-xs text-gray-600 mt-0.5 leading-relaxed">
                                Jl. Kayoon No. 56, Embong Kaliasin, Kec. Genteng, Kota Surabaya, Jawa Timur 60271
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="w-9 h-9 rounded-xl bg-tosca-50 text-tosca-700 flex items-center justify-center shrink-0">🕒</div>
                        <div class="text-xs text-gray-700 space-y-1">
                            <div class="font-bold text-sm text-gray-900">Jam Pelayanan Publik (Hari Kerja)</div>
                            <div><span class="font-semibold">Senin – Kamis:</span> 08.00 – 15.30 WIB</div>
                            <div><span class="font-semibold">Jumat:</span> 08.00 – 14.30 WIB</div>
                            <div class="text-gray-400 italic">Istirahat: 12.00 – 13.00 WIB (Sabtu, Minggu, & Hari Libur Nasional Tutup)</div>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="w-9 h-9 rounded-xl bg-tosca-50 text-tosca-700 flex items-center justify-center shrink-0">✉️</div>
                        <div class="text-xs text-gray-700">
                            <div class="font-bold text-sm text-gray-900">Email Resmi PPID</div>
                            <a href="mailto:disporajatim2024@gmail.com" class="text-tosca-700 font-semibold hover:underline">disporajatim2024@gmail.com</a>
                        </div>
                    </div>
                </div>

                <!-- Kanal Pengaduan Nasional & Sengketa -->
                <div class="pt-5 border-t border-gray-100 space-y-3">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-gray-500">Kanal Pengaduan & Jejaring Resmi</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                        <a href="https://www.lapor.go.id/" target="_blank" rel="noopener"
                            class="p-3.5 bg-red-50 hover:bg-red-100 border border-red-200 rounded-2xl transition-all">
                            <div class="font-extrabold text-red-800 flex items-center justify-between">
                                <span>SP4N-LAPOR!</span>
                                <span>&nearr;</span>
                            </div>
                            <div class="text-[11px] text-red-700 mt-1">Layanan Aspirasi & Pengaduan Online Rakyat</div>
                        </a>

                        <a href="https://ppid.jatimprov.go.id/" target="_blank" rel="noopener"
                            class="p-3.5 bg-tosca-50 hover:bg-tosca-100 border border-tosca-200 rounded-2xl transition-all">
                            <div class="font-extrabold text-tosca-900 flex items-center justify-between">
                                <span>PPID Utama Pemprov Jatim</span>
                                <span>&nearr;</span>
                            </div>
                            <div class="text-[11px] text-tosca-700 mt-1">Portal Utama Keterbukaan Pemprov Jatim</div>
                        </a>

                        <a href="https://komisiinformasi.jatimprov.go.id/" target="_blank" rel="noopener"
                            class="p-3.5 bg-blue-50 hover:bg-blue-100 border border-blue-200 rounded-2xl transition-all sm:col-span-2">
                            <div class="font-extrabold text-blue-900 flex items-center justify-between">
                                <span>Komisi Informasi Provinsi Jawa Timur</span>
                                <span>&nearr;</span>
                            </div>
                            <div class="text-[11px] text-blue-700 mt-1">Lembaga Penyelesaian Sengketa Informasi Publik Tingkat Provinsi</div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Peta Lokasi Google Maps -->
            <div class="bg-white rounded-3xl p-4 border border-gray-100 shadow-sm flex flex-col">
                <div class="px-2 pb-3 flex items-center justify-between">
                    <h2 class="text-sm font-bold text-gray-900">Peta Lokasi Kantor Dispora Jawa Timur</h2>
                    <a href="https://maps.google.com/?q=Dinas+Kepemudaan+dan+Olahraga+Provinsi+Jawa+Timur+Jl.+Kayoon+No.+56+Surabaya" target="_blank" rel="noopener"
                        class="text-xs font-semibold text-tosca-600 hover:underline">Buka di Google Maps &nearr;</a>
                </div>
                <div class="flex-1 min-h-[360px] rounded-2xl overflow-hidden border border-gray-200 bg-gray-100">
                    <iframe
                        title="Lokasi Dispora Jawa Timur"
                        src="https://www.google.com/maps?q=Dinas+Kepemudaan+dan+Olahraga+Provinsi+Jawa+Timur,+Jl.+Kayoon+No.+56,+Surabaya&output=embed"
                        class="w-full h-full min-h-[360px] border-0"
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
@endsection
