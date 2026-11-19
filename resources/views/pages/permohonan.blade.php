@extends('layouts.app')

@section('title', 'Ajukan Permohonan Informasi - PPID Dispora Jatim')

@section('content')
    <div class="max-w-4xl mx-auto space-y-8">

        <div class="text-center pb-6">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Formulir Permohonan Informasi</h1>
            <p class="text-gray-500">Silakan lengkapi data di bawah ini dengan benar untuk mengajukan permohonan informasi
                publik.</p>
        </div>

        @if (session('success'))
            <div class="bg-gradient-to-r from-emerald-500 to-teal-600 text-white p-6 md:p-8 rounded-3xl shadow-lg space-y-4">
                <div class="flex items-start gap-4">
                    <div class="p-3 bg-white/20 rounded-2xl">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <div class="space-y-1">
                        <h3 class="text-xl font-bold">Permohonan Berhasil Dikirim!</h3>
                        <p class="text-emerald-50 text-sm">Permohonan Anda telah tercatat ke dalam sistem PPID Dispora Jatim. Silakan simpan nomor registrasi di bawah untuk melacak status.</p>
                    </div>
                </div>

                @if (session('nomor_registrasi'))
                    <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div>
                            <div class="text-xs uppercase tracking-wider text-emerald-100 font-semibold">Nomor Registrasi Anda</div>
                            <div class="text-2xl font-black tracking-widest text-white">{{ session('nomor_registrasi') }}</div>
                            <div class="text-xs text-emerald-100 mt-1">Gunakan Nomor Registrasi ini bersama NIK Anda untuk melacak status.</div>
                        </div>
                        <a href="{{ route('permohonan.lacak') }}"
                            class="inline-flex items-center justify-center px-5 py-2.5 bg-white text-teal-800 hover:bg-emerald-50 font-bold text-sm rounded-xl shadow transition-colors">
                            Lacak Status Sekarang &rarr;
                        </a>
                    </div>
                @endif
            </div>
        @endif

        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 md:p-10 relative overflow-hidden">

            <div
                class="absolute top-0 right-0 w-64 h-64 bg-tosca-50 rounded-full mix-blend-multiply filter blur-3xl opacity-50 pointer-events-none">
            </div>

            <form action="{{ route('permohonan.store') }}" method="POST" enctype="multipart/form-data"
                class="space-y-6 relative z-10">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Kategori Pemohon <span
                                class="text-red-500">*</span></label>
                        <select name="kategori" required
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-tosca-500 outline-none transition-all">
                            <option value="perorangan" {{ old('kategori') == 'perorangan' ? 'selected' : '' }}>Perorangan</option>
                            <option value="lembaga" {{ old('kategori') == 'lembaga' ? 'selected' : '' }}>Lembaga / Organisasi</option>
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">NIK / Nomor Identitas <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="nik_identitas" required value="{{ old('nik_identitas') }}" placeholder="Masukkan NIK Anda"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-tosca-500 outline-none transition-all">
                        @error('nik_identitas')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Nama Lengkap <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="nama_lengkap" required value="{{ old('nama_lengkap') }}" placeholder="Nama sesuai identitas"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-tosca-500 outline-none transition-all">
                        @error('nama_lengkap')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Alamat Email <span
                                class="text-red-500">*</span></label>
                        <input type="email" name="email" required value="{{ old('email') }}" placeholder="email@contoh.com"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-tosca-500 outline-none transition-all">
                        @error('email')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="space-y-2 md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700">Nomor Telepon / WhatsApp <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="nomor_telepon" required value="{{ old('nomor_telepon') }}" placeholder="Contoh: 081234567890"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-tosca-500 outline-none transition-all">
                        @error('nomor_telepon')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Bagian Fasilitas Ramah Disabilitas -->
                <div class="p-5 bg-gradient-to-br from-blue-50/70 to-indigo-50/70 border border-blue-200/80 rounded-2xl space-y-4">
                    <div class="flex items-start gap-3">
                        <div class="flex items-center h-6">
                            <input type="checkbox" id="is_disabilitas" name="is_disabilitas" value="1" {{ old('is_disabilitas') ? 'checked' : '' }}
                                onchange="toggleDisabilitasFields(this.checked)"
                                class="w-5 h-5 text-tosca-600 border-gray-300 rounded focus:ring-tosca-500 cursor-pointer">
                        </div>
                        <div class="flex-1">
                            <label for="is_disabilitas" class="text-sm font-bold text-gray-800 flex items-center gap-2 cursor-pointer">
                                <span>♿ Layanan Ramah Disabilitas & Kebutuhan Khusus</span>
                                <span class="text-xs bg-blue-100 text-blue-800 font-semibold px-2 py-0.5 rounded-full">Prioritas SPM</span>
                            </label>
                            <p class="text-xs text-gray-600 mt-0.5">
                                Beri tanda centang jika pemohon adalah penyandang disabilitas atau memerlukan format informasi / pendampingan khusus dari PPID Dispora Jatim.
                            </p>
                        </div>
                    </div>

                    <div id="disabilitas_options" class="{{ old('is_disabilitas') ? '' : 'hidden' }} pt-3 border-t border-blue-200/60 space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Ragam Disabilitas</label>
                                <select name="ragam_disabilitas" class="w-full px-3 py-2 bg-white border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-400 outline-none">
                                    <option value="">-- Pilih Ragam Disabilitas --</option>
                                    <option value="Disabilitas Netra (Tunanetra / Low Vision)" {{ old('ragam_disabilitas') == 'Disabilitas Netra (Tunanetra / Low Vision)' ? 'selected' : '' }}>Disabilitas Netra (Tunanetra / Low Vision)</option>
                                    <option value="Disabilitas Rungu / Wicara" {{ old('ragam_disabilitas') == 'Disabilitas Rungu / Wicara' ? 'selected' : '' }}>Disabilitas Rungu / Wicara</option>
                                    <option value="Disabilitas Fisik / Motorik" {{ old('ragam_disabilitas') == 'Disabilitas Fisik / Motorik' ? 'selected' : '' }}>Disabilitas Fisik / Motorik</option>
                                    <option value="Disabilitas Intelektual" {{ old('ragam_disabilitas') == 'Disabilitas Intelektual' ? 'selected' : '' }}>Disabilitas Intelektual</option>
                                    <option value="Disabilitas Ganda" {{ old('ragam_disabilitas') == 'Disabilitas Ganda' ? 'selected' : '' }}>Disabilitas Ganda</option>
                                    <option value="Lainnya" {{ old('ragam_disabilitas') == 'Lainnya' ? 'selected' : '' }}>Lainnya / Lansia Rentan</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Format Jawaban yang Diharapkan</label>
                                <select name="format_jawaban_khusus" class="w-full px-3 py-2 bg-white border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-400 outline-none">
                                    <option value="">-- Format Jawaban Khusus --</option>
                                    <option value="Dokumen Digital Terbuka (Screen Reader Ready)" {{ old('format_jawaban_khusus') == 'Dokumen Digital Terbuka (Screen Reader Ready)' ? 'selected' : '' }}>Dokumen Digital Terbuka (Screen Reader Ready)</option>
                                    <option value="Rekaman Audio / Suara" {{ old('format_jawaban_khusus') == 'Rekaman Audio / Suara' ? 'selected' : '' }}>Rekaman Audio / Suara</option>
                                    <option value="Dokumen Cetak Huruf Besar / Braille" {{ old('format_jawaban_khusus') == 'Dokumen Cetak Huruf Besar / Braille' ? 'selected' : '' }}>Dokumen Cetak Huruf Besar / Braille</option>
                                    <option value="Pendampingan Langsung Petugas Meja Layanan" {{ old('format_jawaban_khusus') == 'Pendampingan Langsung Petugas Meja Layanan' ? 'selected' : '' }}>Pendampingan Langsung Petugas Meja Layanan</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Kebutuhan Fasilitas / Pendampingan Tambahan</label>
                            <input type="text" name="kebutuhan_khusus" value="{{ old('kebutuhan_khusus') }}" placeholder="Contoh: Memerlukan penerjemah bahasa isyarat / akses kursi roda saat pengambilan berkas"
                                class="w-full px-3 py-2 bg-white border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-blue-400 outline-none">
                        </div>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Rincian Informasi yang Dibutuhkan <span
                            class="text-red-500">*</span></label>
                    <textarea name="rincian_informasi" required rows="3" placeholder="Jelaskan secara spesifik..."
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-tosca-500 outline-none transition-all resize-none">{{ old('rincian_informasi') }}</textarea>
                    @error('rincian_informasi')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Tujuan Penggunaan Informasi <span
                            class="text-red-500">*</span></label>
                    <textarea name="tujuan_penggunaan" required rows="2" placeholder="Contoh: Untuk keperluan penelitian..."
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-tosca-500 outline-none transition-all resize-none">{{ old('tujuan_penggunaan') }}</textarea>
                    @error('tujuan_penggunaan')
                        <span class="text-red-500 text-xs">{{ $message }}</span>
                    @enderror
                </div>

                <div class="space-y-2 p-5 bg-tosca-50 border border-tosca-100 rounded-xl border-dashed">
                    <label class="block text-sm font-semibold text-tosca-800">Dokumen Pendukung (KTP/Surat Tugas) <span
                            class="text-red-500">*</span></label>
                    <input type="file" name="file_pendukung" required accept=".pdf,.jpg,.jpeg,.png"
                        class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-tosca-600 file:text-white hover:file:bg-tosca-700 transition-all cursor-pointer">
                    <p class="text-xs text-tosca-600 mt-1">*Format yang diizinkan: PDF, JPG, PNG. Maksimal ukuran file: 5MB.
                    </p>
                    @error('file_pendukung')
                        <span class="text-red-500 text-xs font-bold">{{ $message }}</span>
                    @enderror
                </div>

                <div class="pt-4 border-t border-gray-100 flex justify-end">
                    <button type="submit"
                        class="px-8 py-3 bg-gradient-to-r from-tosca-500 to-tosca-600 hover:from-tosca-600 hover:to-tosca-700 text-white font-bold rounded-xl shadow-lg shadow-tosca-500/30 transform hover:-translate-y-1 transition-all flex items-center gap-2">
                        Kirim Permohonan
                    </button>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function toggleDisabilitasFields(isChecked) {
            const container = document.getElementById('disabilitas_options');
            if (container) {
                if (isChecked) {
                    container.classList.remove('hidden');
                } else {
                    container.classList.add('hidden');
                }
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            // Mengecek apakah ada session 'success' dari Controller
            @if (session('success'))
                Swal.fire({
                    title: "Berhasil!",
                    text: @json(session('success')),
                    icon: "success",
                    confirmButtonText: "Tutup",
                    confirmButtonColor: "#14b8a6", // Warna tosca-500 kita
                    background: "#ffffff",
                    backdrop: `
                        rgba(0,0,123,0.1)
                    `
                });
            @endif
        });
    </script>
@endsection
