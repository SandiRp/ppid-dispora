@extends('layouts.admin')

@section('title', 'Catat Permohonan Offline (Meja Layanan) - Admin PPID')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-black text-gray-800">Catat Permohonan Meja Layanan (Offline)</h1>
            <p class="text-xs text-gray-500 mt-1">Gunakan formulir ini untuk mencatat pemohon yang datang langsung secara fisik, via surat, atau saluran telepon/tatap muka.</p>
        </div>
        <a href="{{ route('admin.permohonan.index') }}" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold rounded-xl transition-colors">
            &larr; Kembali ke Daftar
        </a>
    </div>

    @if ($errors->any())
        <div class="p-4 bg-red-50 border border-red-200 rounded-2xl text-xs text-red-700">
            <strong class="font-bold">Terdapat data yang belum lengkap:</strong>
            <ul class="list-disc pl-5 mt-1 space-y-0.5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 md:p-8">
        <form action="{{ route('admin.permohonan.store-offline') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="p-4 bg-blue-50 border border-blue-200 rounded-2xl flex items-center justify-between text-xs text-blue-800">
                <span>Petugas Pencatat: <strong>{{ auth()->user()->name }}</strong> ({{ strtoupper(auth()->user()->role ?? 'operator') }})</span>
                <span class="px-2.5 py-1 bg-blue-200/60 rounded-lg font-bold">Layanan Meja Langsung</span>
            </div>

            <!-- Kategori -->
            <div class="space-y-2">
                <label class="block text-xs font-bold text-gray-700 uppercase">Kategori Pemohon <span class="text-red-500">*</span></label>
                <div class="flex gap-4">
                    <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
                        <input type="radio" name="kategori" value="perorangan" {{ old('kategori', 'perorangan') == 'perorangan' ? 'checked' : '' }} class="text-tosca-600 focus:ring-tosca-500">
                        Perorangan
                    </label>
                    <label class="flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
                        <input type="radio" name="kategori" value="lembaga" {{ old('kategori') == 'lembaga' ? 'checked' : '' }} class="text-tosca-600 focus:ring-tosca-500">
                        Lembaga / Organisasi
                    </label>
                </div>
            </div>

            <!-- Data Diri Pemohon -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-gray-700 uppercase">Nama Lengkap Pemohon <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_lengkap" required value="{{ old('nama_lengkap') }}"
                        placeholder="Nama lengkap sesuai KTP"
                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-tosca-500 outline-none text-sm">
                </div>
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-gray-700 uppercase">NIK / No. Identitas <span class="text-red-500">*</span></label>
                    <input type="text" name="nik_identitas" required value="{{ old('nik_identitas') }}"
                        placeholder="16 Digit NIK KTP"
                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-tosca-500 outline-none text-sm font-mono">
                </div>
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-gray-700 uppercase">Alamat Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" required value="{{ old('email') }}"
                        placeholder="email@contoh.com (untuk bukti tanda terima)"
                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-tosca-500 outline-none text-sm">
                </div>
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-gray-700 uppercase">Nomor Telepon / WhatsApp <span class="text-red-500">*</span></label>
                    <input type="text" name="nomor_telepon" required value="{{ old('nomor_telepon') }}"
                        placeholder="08xxxxxxxxxx"
                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-tosca-500 outline-none text-sm font-mono">
                </div>
            </div>

            <!-- Fasilitas Disabilitas Offline -->
            <div class="p-4 bg-blue-50/70 border border-blue-200 rounded-xl space-y-3">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_disabilitas" value="1" {{ old('is_disabilitas') ? 'checked' : '' }}
                        onchange="document.getElementById('disabilitas_offline_box').classList.toggle('hidden', !this.checked)"
                        class="w-4 h-4 text-tosca-600 rounded">
                    <span class="text-xs font-bold text-blue-900">♿ Pemohon Adalah Penyandang Disabilitas (Layanan Prioritas Meja Layanan)</span>
                </label>

                <div id="disabilitas_offline_box" class="{{ old('is_disabilitas') ? '' : 'hidden' }} grid grid-cols-1 md:grid-cols-2 gap-3 pt-2 border-t border-blue-200/60">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Ragam Disabilitas</label>
                        <select name="ragam_disabilitas" class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg text-xs">
                            <option value="">-- Pilih Ragam Disabilitas --</option>
                            <option value="Disabilitas Netra (Tunanetra / Low Vision)">Disabilitas Netra (Tunanetra / Low Vision)</option>
                            <option value="Disabilitas Rungu / Wicara">Disabilitas Rungu / Wicara</option>
                            <option value="Disabilitas Fisik / Motorik">Disabilitas Fisik / Motorik</option>
                            <option value="Disabilitas Intelektual">Disabilitas Intelektual</option>
                            <option value="Disabilitas Ganda">Disabilitas Ganda</option>
                            <option value="Lainnya">Lainnya / Lansia Rentan</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Format Jawaban Khusus</label>
                        <select name="format_jawaban_khusus" class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg text-xs">
                            <option value="">-- Format Jawaban --</option>
                            <option value="Dokumen Digital Terbuka (Screen Reader Ready)">Dokumen Digital Terbuka (Screen Reader Ready)</option>
                            <option value="Rekaman Audio / Suara">Rekaman Audio / Suara</option>
                            <option value="Dokumen Cetak Huruf Besar / Braille">Dokumen Cetak Huruf Besar / Braille</option>
                            <option value="Pendampingan Langsung Petugas Meja Layanan">Pendampingan Langsung Petugas Meja Layanan</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Rincian & Tujuan -->
            <div class="space-y-4">
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-gray-700 uppercase">Rincian Informasi yang Diminta <span class="text-red-500">*</span></label>
                    <textarea name="rincian_informasi" required rows="3"
                        placeholder="Tuliskan secara jelas rincian dokumen atau informasi yang dibutuhkan pemohon..."
                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-tosca-500 outline-none text-sm">{{ old('rincian_informasi') }}</textarea>
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-gray-700 uppercase">Tujuan Penggunaan Informasi <span class="text-red-500">*</span></label>
                    <textarea name="tujuan_penggunaan" required rows="2"
                        placeholder="Jelaskan alasan atau tujuan pemohon memanfaatkan informasi ini..."
                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-tosca-500 outline-none text-sm">{{ old('tujuan_penggunaan') }}</textarea>
                </div>
            </div>

            <!-- Upload Berkas KTP Fisik yang Difotokopi / Scan -->
            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-gray-700 uppercase">Scan / Foto Identitas KTP Pemohon <span class="text-red-500">*</span></label>
                <input type="file" name="file_pendukung" required accept=".pdf,.jpg,.jpeg,.png"
                    class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs file:mr-3 file:py-1.5 file:px-3 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-tosca-600 file:text-white cursor-pointer">
                <p class="text-xs text-gray-400">Lampirkan scan kartu identitas pemohon. Maksimal 5MB (PDF/JPG/PNG).</p>
            </div>

            <div class="pt-4 border-t border-gray-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.permohonan.index') }}" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold rounded-xl transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 bg-tosca-600 hover:bg-tosca-700 text-white font-bold text-sm rounded-xl shadow-md transition-all">
                    Simpan & Terbitkan No. Registrasi
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
