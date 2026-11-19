@extends('layouts.app')

@section('title', 'Survei Kepuasan Masyarakat (IKM) - PPID Dispora Jatim')

@section('content')
    <div class="max-w-3xl mx-auto space-y-8">

        <div class="text-center pb-4">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 mb-3">
                Penilaian Pelayanan Publik
            </span>
            <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-2">Survei Kepuasan Masyarakat (IKM)</h1>
            <p class="text-gray-500 max-w-xl mx-auto">Bantu kami meningkatkan kualitas layanan informasi publik dengan memberikan penilaian objektif sesuai Permenpan RB No. 14 Tahun 2017.</p>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 md:p-10">
            <form action="{{ route('survei.store') }}" method="POST" class="space-y-8">
                @csrf

                @if ($permohonan)
                    <input type="hidden" name="permohonan_id" value="{{ $permohonan->id }}">
                    <div class="p-4 bg-tosca-50 border border-tosca-200 rounded-2xl flex items-center justify-between text-xs">
                        <div>
                            <span class="text-gray-500 block">Survei terkait permohonan:</span>
                            <span class="font-bold text-tosca-800 font-mono text-sm">{{ $permohonan->nomor_registrasi }}</span>
                        </div>
                        <span class="px-2.5 py-1 bg-white rounded-lg font-semibold text-tosca-700 border border-tosca-200">
                            {{ $permohonan->nama_lengkap }}
                        </span>
                    </div>
                @endif

                <!-- Data Responden -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-gray-700 uppercase">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" name="nama_responden" required value="{{ old('nama_responden', $permohonan->nama_lengkap ?? '') }}"
                            placeholder="Nama Anda"
                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-tosca-500 outline-none text-sm">
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-gray-700 uppercase">Alamat Email (Opsional)</label>
                        <input type="email" name="email_responden" value="{{ old('email_responden', $permohonan->email ?? '') }}"
                            placeholder="email@contoh.com"
                            class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-tosca-500 outline-none text-sm">
                    </div>
                </div>

                <!-- 9 Unsur Pertanyaan IKM -->
                <div class="space-y-6 pt-4 border-t border-gray-100">
                    <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-tosca-600 text-white flex items-center justify-center text-xs font-bold">1</span>
                        Unsur Penilaian Pelayanan
                    </h3>

                    @php
                        $pertanyaan = [
                            ['field' => 'kesesuaian_persyaratan', 'label' => '1. Kesesuaian Persyaratan Pelayanan', 'desc' => 'Bagaimana kemudahan persyaratan administrasi permohonan informasi publik?'],
                            ['field' => 'kemudahan_prosedur', 'label' => '2. Kemudahan Prosedur Pelayanan', 'desc' => 'Bagaimana alur dan tata cara pengajuan serta pelacakan permohonan?'],
                            ['field' => 'kecepatan_waktu', 'label' => '3. Kecepatan Waktu Pelayanan', 'desc' => 'Bagaimana ketepatan waktu respon petugas sesuai batas 10 hari kerja?'],
                            ['field' => 'kewajaran_biaya', 'label' => '4. Kewajaran Biaya / Tarif', 'desc' => 'Layanan PPID Dispora Jatim adalah gratis (tidak dipungut biaya). Apakah pelayanan bebas dari pungutan liar?'],
                            ['field' => 'kesesuaian_produk', 'label' => '5. Kesesuaian Produk Pelayanan', 'desc' => 'Apakah informasi atau jawaban yang diberikan sesuai dengan yang Anda minta?'],
                            ['field' => 'kompetensi_petugas', 'label' => '6. Kompetensi Petugas Pelayanan', 'desc' => 'Bagaimana pengetahuan, pemahaman, dan keahlian petugas PPID dalam melayani?'],
                            ['field' => 'kesopanan_petugas', 'label' => '7. Kesopanan dan Keramahan Petugas', 'desc' => 'Bagaimana sikap, kesopanan, dan keramahan petugas dalam berkomunikasi?'],
                            ['field' => 'kualitas_sarana', 'label' => '8. Kualitas Sarana & Prasarana', 'desc' => 'Bagaimana kenyamanan portal website / sistem elektronik PPID Dispora?'],
                            ['field' => 'penanganan_pengaduan', 'label' => '9. Penanganan Pengaduan & Keberatan', 'desc' => 'Bagaimana responsifitas petugas dalam menangani kendala atau konsultasi Anda?'],
                        ];
                    @endphp

                    @foreach ($pertanyaan as $item)
                        <div class="p-4 bg-gray-50 rounded-2xl space-y-3">
                            <div>
                                <h4 class="text-sm font-bold text-gray-800">{{ $item['label'] }}</h4>
                                <p class="text-xs text-gray-500 mt-0.5">{{ $item['desc'] }}</p>
                            </div>
                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 text-xs">
                                <label class="flex items-center gap-2 p-2.5 bg-white border border-gray-200 rounded-xl cursor-pointer hover:border-tosca-500 transition-colors">
                                    <input type="radio" name="{{ $item['field'] }}" value="1" required class="text-tosca-600 focus:ring-tosca-500">
                                    <span class="font-medium text-gray-700">1 - Tidak Baik</span>
                                </label>
                                <label class="flex items-center gap-2 p-2.5 bg-white border border-gray-200 rounded-xl cursor-pointer hover:border-tosca-500 transition-colors">
                                    <input type="radio" name="{{ $item['field'] }}" value="2" required class="text-tosca-600 focus:ring-tosca-500">
                                    <span class="font-medium text-gray-700">2 - Kurang Baik</span>
                                </label>
                                <label class="flex items-center gap-2 p-2.5 bg-white border border-gray-200 rounded-xl cursor-pointer hover:border-tosca-500 transition-colors">
                                    <input type="radio" name="{{ $item['field'] }}" value="3" required class="text-tosca-600 focus:ring-tosca-500">
                                    <span class="font-medium text-gray-700">3 - Baik</span>
                                </label>
                                <label class="flex items-center gap-2 p-2.5 bg-white border border-gray-200 rounded-xl cursor-pointer hover:border-tosca-500 transition-colors">
                                    <input type="radio" name="{{ $item['field'] }}" value="4" required class="text-tosca-600 focus:ring-tosca-500">
                                    <span class="font-bold text-tosca-700">4 - Sangat Baik</span>
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Saran & Masukan -->
                <div class="space-y-2 pt-4 border-t border-gray-100">
                    <label class="block text-sm font-semibold text-gray-700">Kritik, Saran, & Masukan Tambahan (Opsional)</label>
                    <textarea name="saran_masukan" rows="3"
                        placeholder="Tuliskan masukan Anda untuk peningkatan pelayanan PPID ke depan..."
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-tosca-500 outline-none text-sm"></textarea>
                </div>

                <div class="pt-4 flex justify-end">
                    <button type="submit"
                        class="px-8 py-3.5 bg-tosca-600 hover:bg-tosca-700 text-white font-bold rounded-xl shadow-lg shadow-tosca-500/30 transform hover:-translate-y-0.5 transition-all">
                        Kirim Penilaian Survei
                    </button>
                </div>
            </form>
        </div>

    </div>
@endsection
