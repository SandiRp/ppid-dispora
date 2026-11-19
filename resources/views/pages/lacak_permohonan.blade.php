@extends('layouts.app')

@section('title', 'Lacak Status Permohonan Informasi - PPID Dispora Jatim')

@section('content')
    <div class="max-w-4xl mx-auto space-y-8">

        <div class="text-center pb-4">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-tosca-100 text-tosca-800 mb-3">
                Layanan Publik Terbuka
            </span>
            <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-2">Lacak Permohonan Informasi</h1>
            <p class="text-gray-500 max-w-xl mx-auto">Pantau perkembangan tindak lanjut permohonan informasi publik Anda secara transparan dan aman sesuai regulasi kerahasiaan data.</p>
        </div>

        <!-- Form Pencarian Verifikasi Ganda (Metode POST Aman Tanpa NIK di URL) -->
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 md:p-8">
            <div class="mb-4">
                <h2 class="text-base font-bold text-gray-800 flex items-center gap-2">
                    <svg class="w-5 h-5 text-tosca-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                    Verifikasi Keamanan Akses Permohonan
                </h2>
                <p class="text-xs text-gray-500 mt-0.5">Untuk melindungi kerahasiaan informasi pemohon (UU PDP), masukkan Nomor Registrasi bersama NIK yang didaftarkan.</p>
            </div>

            <form action="{{ route('permohonan.lacak.post') }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">1. Nomor Registrasi <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                                </svg>
                            </div>
                            <input type="text" name="nomor" value="{{ $nomor ?? old('nomor') }}" required
                                placeholder="Contoh: PPID-202611-0001"
                                class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-tosca-500 outline-none text-sm font-mono text-gray-800">
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">2. NIK Pemohon <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                                </svg>
                            </div>
                            <input type="password" name="nik" id="nikInput" required autocomplete="off"
                                placeholder="Masukkan 16 digit NIK terdaftar"
                                class="w-full pl-10 pr-12 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-tosca-500 outline-none text-sm text-gray-800">
                            <button type="button" onclick="toggleNikVisibility()" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none" title="Lihat/Sembunyikan NIK">
                                <svg id="eyeIcon" class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between pt-2">
                    <span class="text-xs text-gray-400 italic">Data NIK Anda diproses terenkripsi dan tidak disimpan di riwayat URL.</span>
                    <button type="submit"
                        class="px-8 py-3 bg-tosca-600 hover:bg-tosca-700 text-white font-bold rounded-xl shadow-md transition-all flex items-center justify-center gap-2 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                        Verifikasi & Buka Status
                    </button>
                </div>
            </form>
        </div>

        <!-- Hasil Pencarian -->
        @if ($authError)
            <div class="bg-red-50 border border-red-200 rounded-2xl p-6 text-center">
                <div class="w-12 h-12 bg-red-100 text-red-600 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m0 0v.01M12 9v2m0-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-base font-bold text-red-900 mb-1">Verifikasi Identitas Gagal</h3>
                <p class="text-xs text-red-700 max-w-lg mx-auto">{{ $authError }}</p>
            </div>
        @endif

        @if ($permohonan)
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-gray-900 to-gray-800 text-white p-6 md:p-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <span class="text-xs uppercase tracking-wider text-gray-400 font-medium">Nomor Registrasi Terverifikasi</span>
                        <h2 class="text-2xl font-black tracking-wider text-tosca-400">{{ $permohonan->nomor_registrasi ?? '-' }}</h2>
                        <p class="text-xs text-gray-300 mt-1">Diajukan pada: {{ $permohonan->created_at->translatedFormat('d F Y, H:i') }} WIB</p>
                    </div>
                    <div class="flex items-center gap-3">
                        @if ($permohonan->status == 'menunggu')
                            <span class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-bold bg-amber-400/20 text-amber-300 border border-amber-400/30">
                                <span class="w-2 h-2 rounded-full bg-amber-400 mr-2 animate-pulse"></span> Menunggu Verifikasi
                            </span>
                        @elseif ($permohonan->status == 'diproses')
                            <span class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-bold bg-blue-400/20 text-blue-300 border border-blue-400/30">
                                <span class="w-2 h-2 rounded-full bg-blue-400 mr-2 animate-pulse"></span> Sedang Diproses
                            </span>
                        @elseif ($permohonan->status == 'selesai')
                            <span class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-bold bg-emerald-400/20 text-emerald-300 border border-emerald-400/30">
                                <span class="w-2 h-2 rounded-full bg-emerald-400 mr-2"></span> Selesai
                            </span>
                        @else
                            <span class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-bold bg-red-400/20 text-red-300 border border-red-400/30">
                                <span class="w-2 h-2 rounded-full bg-red-400 mr-2"></span> Ditolak
                            </span>
                        @endif

                        <a href="{{ route('permohonan.lacak', ['reset' => 1]) }}"
                            class="inline-flex items-center px-3 py-2 bg-white/10 hover:bg-white/20 text-white rounded-xl text-xs font-semibold border border-white/20 transition-colors"
                            title="Tutup hasil lacak ini untuk melindungi privasi">
                            Keluar
                        </a>
                    </div>
                </div>

                <div class="p-6 md:p-8 space-y-6">
                    <!-- Progress Tracker -->
                    <div>
                        <h3 class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-4">Progres Layanan</h3>
                        <div class="grid grid-cols-3 gap-2">
                            <div class="text-center p-3 rounded-xl border {{ in_array($permohonan->status, ['menunggu', 'diproses', 'selesai', 'ditolak']) ? 'bg-tosca-50 border-tosca-300 text-tosca-900 font-bold' : 'bg-gray-50 border-gray-200 text-gray-400' }}">
                                <div class="text-xs">1. Masuk</div>
                            </div>
                            <div class="text-center p-3 rounded-xl border {{ in_array($permohonan->status, ['diproses', 'selesai']) ? 'bg-tosca-50 border-tosca-300 text-tosca-900 font-bold' : ($permohonan->status == 'ditolak' ? 'bg-red-50 border-red-200 text-red-700' : 'bg-gray-50 border-gray-200 text-gray-400') }}">
                                <div class="text-xs">2. Verifikasi/Proses</div>
                            </div>
                            <div class="text-center p-3 rounded-xl border {{ $permohonan->status == 'selesai' ? 'bg-emerald-50 border-emerald-300 text-emerald-900 font-bold' : ($permohonan->status == 'ditolak' ? 'bg-red-50 border-red-300 text-red-800 font-bold' : 'bg-gray-50 border-gray-200 text-gray-400') }}">
                                <div class="text-xs">3. {{ $permohonan->status == 'ditolak' ? 'Ditolak' : 'Tanggapan Diberikan' }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Timeline Riwayat Status Permohonan -->
                    <div class="pt-4 border-t border-gray-100">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-3">Timeline Riwayat Status</h3>
                        <ol class="relative border-s-2 border-tosca-200 ml-3 space-y-4">
                            <li class="ms-5">
                                <span class="absolute flex items-center justify-center w-3.5 h-3.5 bg-tosca-500 rounded-full -start-[9px] ring-4 ring-white"></span>
                                <div class="text-xs font-bold text-gray-900">1. Permohonan Diterima & Terdaftar</div>
                                <time class="block text-[11px] text-gray-500 mt-0.5">{{ $permohonan->created_at->translatedFormat('d F Y, H:i') }} WIB</time>
                                <p class="text-xs text-gray-600 mt-0.5">
                                    Nomor Registrasi: <span class="font-mono font-semibold">{{ $permohonan->nomor_registrasi }}</span>
                                    &bull; Kanal: <span class="font-semibold">{{ strtoupper($permohonan->tipe_permohonan ?? 'ONLINE') }}</span>
                                </p>
                            </li>

                            @if ($permohonan->perpanjangan_sla)
                                <li class="ms-5">
                                    <span class="absolute flex items-center justify-center w-3.5 h-3.5 bg-amber-500 rounded-full -start-[9px] ring-4 ring-white"></span>
                                    <div class="text-xs font-bold text-amber-800">2. Perpanjangan Waktu SLA (+7 Hari Kerja)</div>
                                    <time class="block text-[11px] text-gray-500 mt-0.5">
                                        {{ $permohonan->tanggal_perpanjangan ? $permohonan->tanggal_perpanjangan->translatedFormat('d F Y, H:i') . ' WIB' : '-' }}
                                    </time>
                                    @if ($permohonan->alasan_perpanjangan)
                                        <p class="text-xs text-amber-800 bg-amber-50 border border-amber-200 rounded-lg p-2 mt-1">
                                            Alasan: {{ $permohonan->alasan_perpanjangan }}
                                        </p>
                                    @endif
                                </li>
                            @endif

                            <li class="ms-5">
                                @php $permSla = $permohonan->sla_info; @endphp
                                <span class="absolute flex items-center justify-center w-3.5 h-3.5 {{ $permohonan->status === 'selesai' ? 'bg-emerald-500' : ($permohonan->status === 'ditolak' ? 'bg-red-500' : 'bg-blue-500') }} rounded-full -start-[9px] ring-4 ring-white"></span>
                                <div class="text-xs font-bold text-gray-900">
                                    {{ $permohonan->perpanjangan_sla ? '3.' : '2.' }} Status Layanan & Batas Waktu (SLA)
                                </div>
                                <time class="block text-[11px] text-gray-500 mt-0.5">
                                    {{ $permohonan->tanggal_respon ? $permohonan->tanggal_respon->translatedFormat('d F Y, H:i') . ' WIB' : 'Sedang dalam masa pelayanan' }}
                                </time>
                                <div class="mt-1 flex flex-wrap items-center gap-2">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-gray-100 text-gray-800 capitalize">
                                        Status: {{ $permohonan->status }}
                                    </span>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-semibold {{ $permSla['status_sla'] === 'expired' ? 'bg-red-100 text-red-700' : ($permSla['status_sla'] === 'warning' ? 'bg-amber-100 text-amber-800' : 'bg-emerald-50 text-emerald-700') }}">
                                        ⏱️ {{ $permSla['label'] }}
                                    </span>
                                </div>
                            </li>
                        </ol>
                    </div>

                    <!-- Data Permohonan -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-4 border-t border-gray-100 text-sm">
                        <div>
                            <span class="text-xs text-gray-400 block">Nama Pemohon</span>
                            <span class="font-semibold text-gray-800">{{ $permohonan->nama_lengkap }}</span>
                        </div>
                        <div>
                            <span class="text-xs text-gray-400 block">Kategori</span>
                            <span class="font-semibold text-gray-800 capitalize">{{ $permohonan->kategori }}</span>
                        </div>

                        @if ($permohonan->is_disabilitas)
                            <div class="md:col-span-2 p-3 bg-blue-50 border border-blue-200 rounded-xl text-xs text-blue-900 flex items-center justify-between">
                                <div>
                                    <span class="font-bold flex items-center gap-1.5">
                                        <span>♿</span> Layanan Ramah Disabilitas (Prioritas SPM)
                                    </span>
                                    <p class="text-blue-700 text-[11px] mt-0.5">
                                        Ragam: <span class="font-semibold">{{ $permohonan->ragam_disabilitas }}</span> | 
                                        Format Jawaban: <span class="font-semibold">{{ $permohonan->format_jawaban_khusus ?: 'Standar' }}</span>
                                    </p>
                                </div>
                                <span class="px-2 py-1 bg-blue-200/80 text-blue-900 rounded-lg text-[10px] font-bold">Terverifikasi</span>
                            </div>
                        @endif
                        <div class="md:col-span-2">
                            <span class="text-xs text-gray-400 block">Rincian Informasi</span>
                            <p class="text-gray-700 mt-1 whitespace-pre-line bg-gray-50 p-3 rounded-xl">{{ $permohonan->rincian_informasi }}</p>
                        </div>
                        <div class="md:col-span-2">
                            <span class="text-xs text-gray-400 block">Tujuan Penggunaan</span>
                            <p class="text-gray-700 mt-1 whitespace-pre-line bg-gray-50 p-3 rounded-xl">{{ $permohonan->tujuan_penggunaan }}</p>
                        </div>

                        <!-- Unduh Berkas Jawaban Resmi (Aman Tanpa Query String NIK) -->
                        @if ($permohonan->file_jawaban)
                            <div class="md:col-span-2 bg-emerald-50 border border-emerald-200 rounded-2xl p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                <div>
                                    <div class="flex items-center gap-2 text-emerald-900 font-bold text-sm mb-1">
                                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        Berkas Informasi / Jawaban Resmi Tersedia
                                    </div>
                                    <p class="text-xs text-emerald-700">Petugas PPID telah melampirkan berkas jawaban resmi atas permohonan informasi Anda.</p>
                                </div>
                                <a href="{{ route('permohonan.download-jawaban', $permohonan->id) }}"
                                    class="inline-flex items-center justify-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl shadow transition-all">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                    </svg>
                                    Unduh Berkas Jawaban
                                </a>
                            </div>
                        @endif

                        @if ($permohonan->alasan_penolakan)
                            <div class="md:col-span-2 bg-red-50 border border-red-200 rounded-2xl p-4 space-y-2">
                                <div class="flex items-center gap-2 text-red-900 font-bold text-sm">
                                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                    </svg>
                                    Dasar Alasan Penolakan Permohonan Informasi
                                </div>
                                <p class="text-xs text-red-800 whitespace-pre-line bg-white/70 p-3 rounded-xl border border-red-200">{{ $permohonan->alasan_penolakan }}</p>
                                <div class="pt-2 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs text-red-700">
                                    <span>Merasa penolakan ini tidak tepat? Anda berhak mengajukan keberatan kepada Atasan PPID.</span>
                                    <a href="{{ route('keberatan.create', ['nomor' => $permohonan->nomor_registrasi]) }}"
                                        class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl transition-all shadow-sm">
                                        Ajukan Keberatan &rarr;
                                    </a>
                                </div>
                            </div>
                        @endif

                        @if ($permohonan->catatan_admin)
                            <div class="md:col-span-2 bg-amber-50 border border-amber-200 rounded-2xl p-4">
                                <div class="flex items-center gap-2 text-amber-900 font-bold text-sm mb-1">
                                    <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Catatan / Tanggapan Petugas PPID
                                </div>
                                <p class="text-sm text-amber-800 whitespace-pre-line">{{ $permohonan->catatan_admin }}</p>
                            </div>
                        @endif

                        <!-- Ajakan Survei Kepuasan (IKM) jika permohonan sudah selesai -->
                        @if ($permohonan->status == 'selesai')
                            <div class="md:col-span-2 bg-teal-50 border border-teal-200 rounded-2xl p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                <div>
                                    <div class="font-bold text-teal-900 text-sm">Bagaimana penilaian Anda terhadap layanan kami?</div>
                                    <div class="text-xs text-teal-700">Bantu PPID Dispora Jatim meningkatkan mutu pelayanan dengan mengisi survei 2 menit.</div>
                                </div>
                                <a href="{{ route('survei.create', ['nomor' => $permohonan->nomor_registrasi]) }}"
                                    class="inline-flex items-center justify-center px-4 py-2 bg-teal-700 hover:bg-teal-800 text-white text-xs font-bold rounded-xl shadow transition-colors">
                                    Isi Survei IKM &rarr;
                                </a>
                            </div>
                        @endif

                        <!-- Tombol Alternatif Ajukan Keberatan jika permohonan terlambat / belum selesai -->
                        @if (!in_array($permohonan->status, ['ditolak']))
                            <div class="md:col-span-2 pt-2 border-t border-gray-100 flex justify-end">
                                <a href="{{ route('keberatan.create', ['nomor' => $permohonan->nomor_registrasi]) }}"
                                    class="text-xs text-red-600 hover:text-red-700 font-semibold flex items-center gap-1 hover:underline">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                    </svg>
                                    Ada kendala atau keterlambatan pelayanan? Ajukan Keberatan ke Atasan PPID &rarr;
                                </a>
                            </div>
                        @endif

                        <!-- Riwayat Pengajuan Keberatan Terkait -->
                        @if ($permohonan->keberatans && $permohonan->keberatans->count() > 0)
                            <div class="md:col-span-2 pt-4 border-t border-gray-200 space-y-3">
                                <h3 class="text-xs font-bold uppercase tracking-wider text-red-700 flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Riwayat Pengajuan Keberatan Terkait ({{ $permohonan->keberatans->count() }})
                                </h3>
                                <div class="space-y-3">
                                    @foreach ($permohonan->keberatans as $keb)
                                        @php $kebSla = $keb->sla_info; @endphp
                                        <div class="p-4 bg-gray-50 border border-gray-200 rounded-2xl space-y-2">
                                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                                                <div>
                                                    <span class="font-mono font-bold text-xs text-red-700">{{ $keb->nomor_keberatan }}</span>
                                                    <span class="text-[11px] text-gray-500 ml-2">&bull; Diajukan {{ $keb->created_at->translatedFormat('d F Y, H:i') }} WIB</span>
                                                </div>
                                                <div class="flex flex-wrap items-center gap-1.5">
                                                    <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold uppercase {{ $keb->status === 'selesai' ? 'bg-green-100 text-green-800' : ($keb->status === 'ditolak' ? 'bg-red-100 text-red-800' : ($keb->status === 'diproses' ? 'bg-blue-100 text-blue-800' : 'bg-yellow-100 text-yellow-800')) }}">
                                                        {{ $keb->status === 'selesai' ? 'Dikabulkan / Selesai' : ($keb->status === 'ditolak' ? 'Ditolak' : ($keb->status === 'diproses' ? 'Sedang Ditinjau' : 'Menunggu Tindak Lanjut')) }}
                                                    </span>
                                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold {{ $kebSla['status_sla'] === 'expired' ? 'bg-red-100 text-red-700' : ($kebSla['status_sla'] === 'warning' ? 'bg-amber-100 text-amber-800' : 'bg-gray-200 text-gray-700') }}">
                                                        SLA 30 Hari: {{ $kebSla['label'] }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="text-xs text-gray-700">
                                                <span class="font-semibold">Alasan:</span> {{ $keb->alasan_keberatan }}
                                            </div>
                                            @if ($keb->tanggapan_atasan_ppid)
                                                <div class="p-3 bg-emerald-50 border border-emerald-200 rounded-xl text-xs text-emerald-900">
                                                    <div class="font-bold mb-1">
                                                        Tanggapan Resmi Atasan PPID
                                                        @if ($keb->tanggal_tanggapan)
                                                            <span class="font-normal text-[11px] text-emerald-700">({{ $keb->tanggal_tanggapan->translatedFormat('d F Y, H:i') }} WIB)</span>
                                                        @endif
                                                    </div>
                                                    <p class="whitespace-pre-line">{{ $keb->tanggapan_atasan_ppid }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif

    </div>

    <script>
        function toggleNikVisibility() {
            const nikInput = document.getElementById('nikInput');
            if (nikInput.type === 'password') {
                nikInput.type = 'text';
            } else {
                nikInput.type = 'password';
            }
        }
    </script>
@endsection
