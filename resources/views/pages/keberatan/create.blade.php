@extends('layouts.app')

@section('title', 'Pengajuan Keberatan Informasi Publik - PPID Dispora Jatim')

@section('content')
    <div class="max-w-4xl mx-auto space-y-8">

        <div class="text-center pb-4">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800 mb-3">
                Layanan Keberatan Resmi
            </span>
            <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-2">Formulir Keberatan Informasi Publik</h1>
            <p class="text-gray-500 max-w-xl mx-auto">Sampaikan keberatan Anda kepada Atasan PPID sesuai amanat Undang-Undang Keterbukaan Informasi Publik (UU No. 14 Tahun 2008).</p>
        </div>

        @if (session('error'))
            <div class="bg-red-50 border border-red-200 rounded-2xl p-5 flex items-start gap-4">
                <div class="p-2 bg-red-100 text-red-600 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <div>
                    <h4 class="font-bold text-red-900 text-sm">Gagal Mengajukan Keberatan</h4>
                    <p class="text-xs text-red-700 mt-0.5">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 md:p-10 relative overflow-hidden">
            <form action="{{ route('keberatan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Informasi Terkait Permohonan -->
                <div class="p-5 bg-gray-50 border border-gray-200 rounded-2xl space-y-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wider flex items-center gap-2">
                            <svg class="w-4 h-4 text-tosca-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Permohonan yang Dikeberatkan
                        </h3>
                        @if ($permohonan)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                                Terverifikasi Aman
                            </span>
                        @endif
                    </div>

                    @if ($permohonan)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm">
                            <div>
                                <span class="text-xs text-gray-500 block">Nomor Registrasi:</span>
                                <span class="font-bold text-tosca-700 font-mono">{{ $permohonan->nomor_registrasi }}</span>
                            </div>
                            <div>
                                <span class="text-xs text-gray-500 block">Tanggal Permohonan:</span>
                                <span class="font-semibold text-gray-800">{{ $permohonan->created_at->format('d M Y') }}</span>
                            </div>
                            <div class="md:col-span-2">
                                <span class="text-xs text-gray-500 block">Rincian Informasi:</span>
                                <p class="text-gray-700 text-xs bg-white p-3 rounded-xl border border-gray-200 mt-1">{{ $permohonan->rincian_informasi }}</p>
                            </div>
                        </div>
                    @else
                        <!-- Form Verifikasi Ganda jika belum lolos verifikasi session -->
                        <div class="space-y-3">
                            <p class="text-xs text-gray-500">Demi melindungi kerahasiaan data (UU PDP), masukkan Nomor Registrasi dan NIK yang terdaftar pada permohonan yang bersangkutan.</p>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="space-y-1">
                                    <label class="block text-xs font-bold text-gray-700 uppercase">Nomor Registrasi <span class="text-red-500">*</span></label>
                                    <input type="text" name="nomor_registrasi" required value="{{ old('nomor_registrasi', $nomor) }}"
                                        placeholder="Contoh: PPID-202611-0001"
                                        class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm font-mono focus:ring-2 focus:ring-tosca-500 outline-none">
                                </div>
                                <div class="space-y-1">
                                    <label class="block text-xs font-bold text-gray-700 uppercase">NIK Pemohon Terdaftar <span class="text-red-500">*</span></label>
                                    <input type="password" name="nik_pemohon" required autocomplete="off"
                                        placeholder="16 Digit NIK saat mendaftar"
                                        class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-tosca-500 outline-none">
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Identitas Pemohon Keberatan -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Nama Pemohon Keberatan <span class="text-red-500">*</span></label>
                        <input type="text" name="nama_pemohon" required value="{{ old('nama_pemohon', $permohonan->nama_lengkap ?? '') }}"
                            placeholder="Nama Lengkap"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-tosca-500 outline-none text-sm">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Alamat Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" required value="{{ old('email', $permohonan->email ?? '') }}"
                            placeholder="email@contoh.com"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-tosca-500 outline-none text-sm">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Nomor Telepon / WhatsApp <span class="text-red-500">*</span></label>
                        <input type="text" name="nomor_telepon" required value="{{ old('nomor_telepon', $permohonan->nomor_telepon ?? '') }}"
                            placeholder="08xxxxxxxxxx"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-tosca-500 outline-none text-sm">
                    </div>
                </div>

                <!-- Alasan Keberatan (Berdasarkan Pasal 35 UU 14/2008) -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Alasan Pengajuan Keberatan <span class="text-red-500">*</span></label>
                    <select name="alasan_keberatan" required
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-tosca-500 outline-none text-sm">
                        <option value="">-- Pilih Salah Satu Alasan Keberatan --</option>
                        <option value="Penolakan atas permohonan informasi tidak beralasan">Penolakan atas permohonan informasi tidak beralasan / tanpa dasar hukum</option>
                        <option value="Informasi berkala tidak disediakan">Tidak disediakannya informasi berkala</option>
                        <option value="Permohonan informasi tidak ditanggapi">Permohonan informasi tidak ditanggapi sebagaimana mestinya</option>
                        <option value="Permohonan informasi ditanggapi tidak sebagaimana yang diminta">Permohonan informasi ditanggapi tidak sebagaimana yang diminta</option>
                        <option value="Permohonan informasi tidak dipenuhi">Permohonan informasi tidak dipenuhi oleh Badan Publik</option>
                        <option value="Biaya yang dikenakan tidak wajar">Pengenaan biaya yang tidak wajar</option>
                        <option value="Penyampaian informasi melebihi waktu yang diatur UU">Penyampaian informasi yang melebihi batas waktu (SLA 10+7 hari kerja)</option>
                    </select>
                </div>

                <!-- Penjelasan Keberatan -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Keterangan / Dalil Alasan Keberatan <span class="text-red-500">*</span></label>
                    <textarea name="keterangan_keberatan" required rows="4"
                        placeholder="Jelaskan secara runtut fakta, dalil, serta alasan mengapa Anda mengajukan keberatan ini kepada Atasan PPID..."
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-tosca-500 outline-none text-sm">{{ old('keterangan_keberatan') }}</textarea>
                </div>

                <!-- Berkas Pendukung (Opsional) -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Berkas Pendukung Tambahan (Opsional)</label>
                    <input type="file" name="file_pendukung" accept=".pdf,.jpg,.jpeg,.png"
                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm file:mr-4 file:py-1.5 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-red-100 file:text-red-700 hover:file:bg-red-200 cursor-pointer">
                    <p class="text-xs text-gray-400">Format: PDF/JPG/PNG, maksimal 5MB.</p>
                </div>

                <div class="pt-4 border-t border-gray-100 flex items-center justify-between">
                    <a href="{{ route('permohonan.lacak') }}" class="text-xs text-gray-500 hover:text-gray-700 underline">
                        &larr; Kembali ke Lacak Status
                    </a>
                    <button type="submit"
                        class="px-8 py-3.5 bg-gradient-to-r from-red-600 to-rose-700 hover:from-red-700 hover:to-rose-800 text-white font-bold rounded-xl shadow-lg shadow-red-500/30 transform hover:-translate-y-0.5 transition-all">
                        Kirim Pengajuan Keberatan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
