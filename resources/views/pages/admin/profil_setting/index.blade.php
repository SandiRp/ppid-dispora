@extends('layouts.admin')

@section('title', 'Kelola Halaman Profil (CMS) - Admin PPID')

@section('content')
<div class="max-w-5xl mx-auto space-y-8">

    <div class="pb-4 border-b border-gray-200">
        <h1 class="text-3xl font-black text-gray-900 mb-1">Kelola Halaman Profil (CMS)</h1>
        <p class="text-gray-500 text-sm">Sesuaikan narasi profil, visi misi, maklumat layanan, dan bagan struktur organisasi tanpa mengubah kode program.</p>
    </div>

    @if (session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-bold rounded-2xl">
            {{ session('success') }}
        </div>
    @endif

    <div class="space-y-6">
        <!-- 1. Profil PPID Singkat -->
        <div class="bg-white rounded-3xl p-6 md:p-8 border border-gray-100 shadow-sm space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                <div class="flex items-center gap-3">
                    <span class="w-8 h-8 rounded-xl bg-tosca-100 text-tosca-700 flex items-center justify-center font-bold text-sm">1</span>
                    <h2 class="text-base font-bold text-gray-900">Halaman Profil PPID</h2>
                </div>
                <a href="{{ route('profil.ppid') }}" target="_blank" class="text-xs text-tosca-600 hover:underline font-semibold">
                    Lihat di Web &rarr;
                </a>
            </div>

            @php $profil = $settings['profil_ppid'] ?? null; @endphp
            <form action="{{ route('admin.profil-setting.update', 'profil_ppid') }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div class="space-y-1">
                    <label class="block text-xs font-bold text-gray-700 uppercase">Judul Halaman</label>
                    <input type="text" name="judul" value="{{ old('judul', $profil->judul ?? 'Profil PPID Dispora Jatim') }}" required
                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-tosca-500 outline-none">
                </div>
                <div class="space-y-1">
                    <label class="block text-xs font-bold text-gray-700 uppercase">Teks Narasi Profil</label>
                    <textarea name="konten" rows="5" placeholder="Tuliskan gambaran umum dan dasar hukum PPID Dispora Jatim..."
                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-tosca-500 outline-none">{{ old('konten', $profil->konten ?? '') }}</textarea>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="px-5 py-2.5 bg-tosca-600 hover:bg-tosca-700 text-white font-bold text-xs rounded-xl shadow transition-all">
                        Simpan Profil
                    </button>
                </div>
            </form>
        </div>

        <!-- 2. Visi & Misi -->
        <div class="bg-white rounded-3xl p-6 md:p-8 border border-gray-100 shadow-sm space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                <div class="flex items-center gap-3">
                    <span class="w-8 h-8 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-sm">2</span>
                    <h2 class="text-base font-bold text-gray-900">Visi & Misi</h2>
                </div>
                <a href="{{ route('profil.visi-misi') }}" target="_blank" class="text-xs text-blue-600 hover:underline font-semibold">
                    Lihat di Web &rarr;
                </a>
            </div>

            @php $visiMisi = $settings['visi_misi'] ?? null; @endphp
            <form action="{{ route('admin.profil-setting.update', 'visi_misi') }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div class="space-y-1">
                    <label class="block text-xs font-bold text-gray-700 uppercase">Judul</label>
                    <input type="text" name="judul" value="{{ old('judul', $visiMisi->judul ?? 'Visi dan Misi PPID Dispora Provinsi Jawa Timur') }}" required
                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-tosca-500 outline-none">
                </div>
                <div class="space-y-1">
                    <label class="block text-xs font-bold text-gray-700 uppercase">Konten Visi & Misi</label>
                    <textarea name="konten" rows="6" placeholder="Tuliskan rumusan Visi dan butir-butir Misi..."
                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-tosca-500 outline-none">{{ old('konten', $visiMisi->konten ?? '') }}</textarea>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="px-5 py-2.5 bg-tosca-600 hover:bg-tosca-700 text-white font-bold text-xs rounded-xl shadow transition-all">
                        Simpan Visi & Misi
                    </button>
                </div>
            </form>
        </div>

        <!-- 3. Maklumat Layanan -->
        <div class="bg-white rounded-3xl p-6 md:p-8 border border-gray-100 shadow-sm space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                <div class="flex items-center gap-3">
                    <span class="w-8 h-8 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center font-bold text-sm">3</span>
                    <h2 class="text-base font-bold text-gray-900">Maklumat Pelayanan Informasi</h2>
                </div>
                <a href="{{ route('profil.maklumat') }}" target="_blank" class="text-xs text-amber-600 hover:underline font-semibold">
                    Lihat di Web &rarr;
                </a>
            </div>

            @php $maklumat = $settings['maklumat'] ?? null; @endphp
            <form action="{{ route('admin.profil-setting.update', 'maklumat') }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div class="space-y-1">
                    <label class="block text-xs font-bold text-gray-700 uppercase">Pernyataan Maklumat</label>
                    <input type="text" name="judul" value="{{ old('judul', $maklumat->judul ?? 'Maklumat Pelayanan Informasi Publik Dispora Jawa Timur') }}" required
                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-tosca-500 outline-none">
                </div>
                <div class="space-y-1">
                    <label class="block text-xs font-bold text-gray-700 uppercase">Teks Komitmen Maklumat</label>
                    <textarea name="konten" rows="4" placeholder="Tuliskan komitmen pelayanan publik..."
                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-tosca-500 outline-none">{{ old('konten', $maklumat->konten ?? '') }}</textarea>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="px-5 py-2.5 bg-tosca-600 hover:bg-tosca-700 text-white font-bold text-xs rounded-xl shadow transition-all">
                        Simpan Maklumat
                    </button>
                </div>
            </form>
        </div>

        <!-- 4. Bagan Struktur Organisasi -->
        <div class="bg-white rounded-3xl p-6 md:p-8 border border-gray-100 shadow-sm space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                <div class="flex items-center gap-3">
                    <span class="w-8 h-8 rounded-xl bg-purple-100 text-purple-700 flex items-center justify-center font-bold text-sm">4</span>
                    <h2 class="text-base font-bold text-gray-900">Bagan Struktur Organisasi PPID</h2>
                </div>
                <a href="{{ route('profil.struktur') }}" target="_blank" class="text-xs text-purple-600 hover:underline font-semibold">
                    Lihat di Web &rarr;
                </a>
            </div>

            @php $struktur = $settings['struktur'] ?? null; @endphp
            <form action="{{ route('admin.profil-setting.update', 'struktur') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')
                <div class="space-y-1">
                    <label class="block text-xs font-bold text-gray-700 uppercase">Judul / Keterangan Bagan</label>
                    <input type="text" name="judul" value="{{ old('judul', $struktur->judul ?? 'Struktur Organisasi PPID Dinas Kepemudaan dan Olahraga Jawa Timur') }}" required
                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:bg-white focus:ring-2 focus:ring-tosca-500 outline-none">
                </div>

                @if ($struktur && $struktur->gambar)
                    <div class="p-3 bg-gray-50 rounded-2xl border border-gray-200 max-w-md">
                        <span class="text-xs text-gray-500 block mb-2 font-semibold">Gambar Bagan Saat Ini:</span>
                        <img src="{{ asset('storage/' . $struktur->gambar) }}" alt="Bagan Struktur" class="max-h-48 rounded-xl object-contain bg-white p-2">
                    </div>
                @endif

                <div class="space-y-1">
                    <label class="block text-xs font-bold text-gray-700 uppercase">Unggah File Bagan Baru (JPG/PNG/WEBP, Maks. 5MB)</label>
                    <input type="file" name="gambar" accept=".jpg,.jpeg,.png,.webp"
                        class="w-full px-2 py-1.5 bg-gray-50 border border-gray-200 rounded-xl text-xs file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-purple-100 file:text-purple-700 hover:file:bg-purple-200 cursor-pointer">
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-5 py-2.5 bg-tosca-600 hover:bg-tosca-700 text-white font-bold text-xs rounded-xl shadow transition-all">
                        Simpan Bagan Struktur
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
