@extends('layouts.admin')

@section('title', 'Admin - Kelola Permohonan Informasi')

@section('content')
    <div class="max-w-7xl mx-auto space-y-6">

        <!-- Header Halaman & Aksi Cepat -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-6 border-b border-gray-200">
            <div>
                <h1 class="text-3xl font-black text-gray-900 mb-1">Kelola Permohonan Informasi</h1>
                <p class="text-gray-500 text-sm">Panel operasional PPID Dispora Jatim untuk memproses permohonan data dan memantau kepatuhan SLA 10+7 hari kerja.</p>
            </div>
            <div class="flex items-center gap-3 flex-wrap">
                <!-- Tombol Ekspor CSV -->
                <a href="{{ route('admin.permohonan.export', request()->query()) }}"
                    class="px-4 py-2.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border border-emerald-300 font-bold text-xs rounded-xl shadow-sm transition-all flex items-center gap-2">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Ekspor CSV (Excel)
                </a>

                <!-- Tombol Catat Offline -->
                <a href="{{ route('admin.permohonan.create-offline') }}"
                    class="px-4 py-2.5 bg-tosca-600 hover:bg-tosca-700 text-white font-bold text-xs rounded-xl shadow-md transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    + Catat Offline (Meja Layanan)
                </a>
            </div>
        </div>

        @if (session('error'))
            <div class="p-4 bg-red-50 border border-red-200 rounded-2xl text-xs text-red-700 font-bold">
                {{ session('error') }}
            </div>
        @endif

        <!-- Filter & Bar Pencarian -->
        <div class="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm">
            <form action="{{ route('admin.permohonan.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
                <div class="lg:col-span-2">
                    <input type="text" name="q" value="{{ request('q') }}"
                        placeholder="Cari No. Reg, Nama, NIK, atau Rincian..."
                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:bg-white focus:ring-2 focus:ring-tosca-500 outline-none">
                </div>

                <div>
                    <select name="status" class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:bg-white focus:ring-2 focus:ring-tosca-500 outline-none">
                        <option value="">-- Semua Status --</option>
                        <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                        <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Sedang Diproses</option>
                        <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>

                <div>
                    <select name="tipe" class="w-full px-3 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:bg-white focus:ring-2 focus:ring-tosca-500 outline-none">
                        <option value="">-- Semua Tipe Layanan --</option>
                        <option value="online" {{ request('tipe') == 'online' ? 'selected' : '' }}>Online (Website)</option>
                        <option value="offline" {{ request('tipe') == 'offline' ? 'selected' : '' }}>Offline (Meja Layanan)</option>
                    </select>
                </div>

                <div class="flex items-center gap-2">
                    <button type="submit"
                        class="w-full py-2.5 bg-gray-800 hover:bg-gray-900 text-white font-bold text-xs rounded-xl transition-colors">
                        Filter Data
                    </button>
                    @if (request()->hasAny(['q', 'status', 'tipe', 'kategori']))
                        <a href="{{ route('admin.permohonan.index') }}"
                            class="px-3 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-600 text-xs font-bold rounded-xl transition-colors" title="Reset Filter">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Tabel Daftar Permohonan -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-600">
                    <thead class="bg-gray-50 text-gray-800 border-b border-gray-200 uppercase text-xs tracking-wider">
                        <tr>
                            <th class="py-4 px-5 font-semibold text-center w-12">No</th>
                            <th class="py-4 px-5 font-semibold">No. Registrasi & SLA</th>
                            <th class="py-4 px-5 font-semibold">Pemohon</th>
                            <th class="py-4 px-5 font-semibold">Rincian Permohonan</th>
                            <th class="py-4 px-5 font-semibold text-center">Status</th>
                            <th class="py-4 px-5 font-semibold text-center">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">

                        @forelse ($permohonans as $index => $item)
                            <tr class="hover:bg-tosca-50/50 transition-colors">
                                <td class="py-4 px-5 text-center text-gray-500 font-mono text-xs">
                                    {{ $permohonans->firstItem() + $index }}
                                </td>

                                <td class="py-4 px-5 whitespace-nowrap">
                                    <div class="font-bold text-tosca-700 font-mono text-sm">{{ $item->nomor_registrasi ?? 'BELUM ADA' }}</div>
                                    <span class="text-xs text-gray-500">{{ $item->created_at->format('d M Y, H:i') }} WIB</span>

                                    <!-- Badge Tipe Layanan -->
                                    <div class="mt-1 flex flex-wrap gap-1">
                                        @if ($item->tipe_permohonan === 'offline')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-purple-100 text-purple-700">
                                                Meja Layanan
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold bg-gray-100 text-gray-600">
                                                Online
                                            </span>
                                        @endif

                                        @if ($item->is_disabilitas)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-blue-100 text-blue-800 border border-blue-300"
                                                title="Disabilitas: {{ $item->ragam_disabilitas }} | Format: {{ $item->format_jawaban_khusus }} | Catatan: {{ $item->kebutuhan_khusus }}">
                                                ♿ Disabilitas
                                            </span>
                                        @endif

                                        @if ($item->perpanjangan_sla)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-amber-100 text-amber-800 border border-amber-300" title="Batas waktu diperpanjang 7 hari kerja">
                                                +7 Hari Kerja
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Indikator SLA -->
                                    @php $sla = $item->sla_info; @endphp
                                    <div class="mt-2">
                                        @if ($sla['status_sla'] === 'completed')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-gray-100 text-gray-600">
                                                ✓ Selesai
                                            </span>
                                        @elseif ($sla['status_sla'] === 'expired')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold bg-red-100 text-red-700 animate-pulse">
                                                ⚠️ {{ $sla['label'] }}
                                            </span>
                                        @elseif ($sla['status_sla'] === 'warning')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold bg-amber-100 text-amber-800">
                                                ⏱️ {{ $sla['label'] }}
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-medium bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                ⏱️ {{ $sla['label'] }}
                                            </span>
                                        @endif
                                    </div>
                                </td>

                                <td class="py-4 px-5">
                                    <div class="font-bold text-gray-900">{{ $item->nama_lengkap }}</div>
                                    <div class="text-xs text-gray-500 font-mono">{{ $item->email }}</div>
                                    <div class="text-xs text-gray-500 font-mono">{{ $item->nomor_telepon }}</div>
                                    <span class="inline-block mt-1 px-2 py-0.5 bg-gray-100 text-gray-600 rounded text-[10px] font-bold uppercase">
                                        {{ $item->kategori }}
                                    </span>

                                    @if ($item->is_disabilitas)
                                        <div class="mt-2 p-2 bg-blue-50 border border-blue-200 rounded-lg text-xs text-blue-900">
                                            <div class="font-bold flex items-center gap-1">
                                                <span>♿</span>
                                                <span>{{ $item->ragam_disabilitas }}</span>
                                            </div>
                                            <div class="text-[11px] text-blue-700 mt-0.5">
                                                Format: <span class="font-semibold">{{ $item->format_jawaban_khusus ?: 'Standar' }}</span>
                                            </div>
                                            @if ($item->kebutuhan_khusus)
                                                <div class="text-[10px] text-blue-600 italic mt-0.5">
                                                    "{{ $item->kebutuhan_khusus }}"
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                </td>

                                <td class="py-4 px-5 max-w-xs">
                                    <div class="text-xs text-gray-800 line-clamp-2" title="{{ $item->rincian_informasi }}">
                                        {{ $item->rincian_informasi }}
                                    </div>
                                    <div class="text-[11px] text-gray-400 mt-1 italic line-clamp-1" title="{{ $item->tujuan_penggunaan }}">
                                        Tujuan: {{ $item->tujuan_penggunaan }}
                                    </div>

                                    @if ($item->file_jawaban)
                                        <div class="mt-2 text-xs">
                                            <span class="font-bold text-emerald-700">File Jawaban:</span>
                                            <a href="{{ route('permohonan.download-jawaban', $item->id) }}" target="_blank" class="text-tosca-700 underline font-semibold">
                                                Unduh Dokumen
                                            </a>
                                        </div>
                                    @endif

                                    @if ($item->alasan_penolakan)
                                        <div class="mt-1 p-2 bg-red-50 border border-red-200 rounded text-xs text-red-900">
                                            <span class="font-bold block text-[11px]">Alasan Penolakan:</span>
                                            <span class="line-clamp-2">{{ $item->alasan_penolakan }}</span>
                                        </div>
                                    @endif

                                    @if ($item->catatan_admin)
                                        <div class="mt-1 p-2 bg-amber-50 border border-amber-200 rounded text-xs text-amber-900">
                                            <span class="font-bold block text-[11px]">Catatan Admin:</span>
                                            <span class="line-clamp-2">{{ $item->catatan_admin }}</span>
                                        </div>
                                    @endif
                                </td>

                                <td class="py-4 px-5 text-center whitespace-nowrap">
                                    @if ($item->status == 'menunggu')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800 border border-yellow-200">Menunggu</span>
                                    @elseif($item->status == 'diproses')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-800 border border-blue-200">Diproses</span>
                                    @elseif($item->status == 'selesai')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800 border border-green-200">Selesai</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-red-100 text-red-800 border border-red-200">Ditolak</span>
                                    @endif
                                </td>

                                <td class="py-4 px-5 text-center space-y-2 min-w-[190px]">
                                    @if ($item->file_pendukung)
                                        <a href="{{ route('admin.permohonan.berkas', $item->id) }}" target="_blank"
                                            class="inline-flex items-center justify-center w-full px-3 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold rounded-lg border border-gray-300 transition-colors">
                                            <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                                            </svg>
                                            Cek Berkas KTP
                                        </a>
                                    @endif

                                    <!-- Tombol Update Status & Catatan -->
                                    <button type="button"
                                        class="btn-open-modal inline-flex items-center justify-center w-full px-3 py-1.5 bg-tosca-50 hover:bg-tosca-100 text-tosca-700 text-xs font-bold rounded-lg border border-tosca-300 transition-colors"
                                        data-id="{{ $item->id }}"
                                        data-nomor="{{ $item->nomor_registrasi }}"
                                        data-status="{{ $item->status }}"
                                        data-catatan="{{ e($item->catatan_admin ?? '') }}"
                                        data-alasan="{{ e($item->alasan_penolakan ?? '') }}">
                                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Tanggapi Permohonan
                                    </button>

                                    <!-- Tombol Perpanjangan Waktu SLA (Pasal 22 UU KIP) -->
                                    @if (!in_array($item->status, ['selesai', 'ditolak']) && !$item->perpanjangan_sla)
                                        <button type="button"
                                            class="btn-open-perpanjang inline-flex items-center justify-center w-full px-3 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-800 text-xs font-bold rounded-lg border border-amber-300 transition-colors"
                                            data-id="{{ $item->id }}"
                                            data-nomor="{{ $item->nomor_registrasi }}">
                                            <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            Perpanjang SLA (7 Hari)
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center text-gray-500">
                                    <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                    </svg>
                                    Tidak ada data permohonan yang sesuai kriteria filter.
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>

            <!-- Paginasi -->
            @if ($permohonans->hasPages())
                <div class="p-4 border-t border-gray-100">
                    {{ $permohonans->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Modal Update Status & Catatan Tanggapan -->
    <div id="updateModal" class="fixed inset-0 z-50 hidden bg-gray-900/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-lg w-full p-6 md:p-8 shadow-2xl relative">
            <div class="flex items-center justify-between pb-4 border-b border-gray-100">
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Perbarui Status Permohonan</h3>
                    <p class="text-xs text-gray-500" id="modalNomorRegistrasi">No. Reg: -</p>
                </div>
                <button type="button" onclick="closeUpdateModal()" class="text-gray-400 hover:text-gray-600 p-1.5 rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <form id="updateForm" method="POST" action="" enctype="multipart/form-data" class="space-y-4 pt-4">
                @csrf
                @method('PUT')

                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Pilih Status Baru <span class="text-red-500">*</span></label>
                    <select name="status" id="modalStatusSelect" required onchange="toggleFormFields(this.value)"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-tosca-500 outline-none text-sm transition-all">
                        <option value="menunggu">Menunggu</option>
                        <option value="diproses">Diproses</option>
                        <option value="selesai">Selesai</option>
                        <option value="ditolak">Ditolak</option>
                    </select>
                </div>

                <div id="boxAlasanTolak" class="space-y-2 hidden">
                    <label class="block text-sm font-semibold text-red-600">Alasan Penolakan Resmi <span class="text-red-500">*</span></label>
                    <textarea name="alasan_penolakan" id="modalAlasanTolak" rows="3"
                        placeholder="Sebutkan dasar pertimbangan penolakan sesuai Pasal 17 UU No. 14 Tahun 2008..."
                        class="w-full px-4 py-3 bg-red-50 border border-red-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-red-500 outline-none text-sm text-red-900 transition-all"></textarea>
                    <p class="text-xs text-red-500">Wajib diisi jika status Ditolak. Keterangan ini akan dikirimkan ke email pemohon.</p>
                </div>

                <div id="boxFileJawaban" class="space-y-2 hidden p-4 bg-emerald-50 border border-emerald-200 rounded-xl">
                    <label class="block text-sm font-bold text-emerald-900">Unggah Berkas Informasi / Surat Jawaban Resmi</label>
                    <input type="file" name="file_jawaban" accept=".pdf,.zip,.rar,.doc,.docx,.xls,.xlsx"
                        class="w-full px-3 py-2 bg-white border border-emerald-300 rounded-lg text-xs file:mr-3 file:py-1 file:px-3 file:rounded file:border-0 file:text-xs file:font-semibold file:bg-emerald-600 file:text-white cursor-pointer">
                    <p class="text-xs text-emerald-700">Pemohon dapat mengunduh berkas jawaban ini langsung di halaman lacak status.</p>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Catatan / Keterangan Tambahan untuk Pemohon</label>
                    <textarea name="catatan_admin" id="modalCatatan" rows="3"
                        placeholder="Tuliskan keterangan tindak lanjut atau pesan kepada pemohon..."
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-tosca-500 outline-none text-sm transition-all"></textarea>
                    <p class="text-xs text-gray-400">Pemberitahuan ini akan otomatis dikirimkan ke email pemohon.</p>
                </div>

                <div class="flex items-center justify-end gap-3 pt-3 border-t border-gray-100">
                    <button type="button" onclick="closeUpdateModal()"
                        class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold text-sm rounded-xl transition-colors">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-6 py-2.5 bg-tosca-600 hover:bg-tosca-700 text-white font-bold text-sm rounded-xl shadow-md transition-all">
                        Simpan & Kirim Email
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Perpanjangan SLA (7 Hari Kerja) -->
    <div id="perpanjangModal" class="fixed inset-0 z-50 hidden bg-gray-900/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-lg w-full p-6 md:p-8 shadow-2xl relative">
            <div class="flex items-center justify-between pb-4 border-b border-gray-100">
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Perpanjangan Batas Waktu SLA</h3>
                    <p class="text-xs text-amber-700 font-semibold mt-0.5" id="perpanjangNomorReg">No. Reg: -</p>
                </div>
                <button type="button" onclick="closePerpanjangModal()" class="text-gray-400 hover:text-gray-600 p-1.5 rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <form id="perpanjangForm" method="POST" action="" class="space-y-4 pt-4">
                @csrf
                <div class="p-3 bg-amber-50 border border-amber-200 rounded-xl text-xs text-amber-900">
                    <strong>Ketentuan UU No. 14 Tahun 2008 Pasal 22 ayat (8):</strong><br>
                    Badan publik dapat memperpanjang waktu pelayanan informasi paling lambat <strong>7 (tujuh) hari kerja</strong> dengan menyampaikan alasan tertulis kepada pemohon.
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Alasan Resmi Perpanjangan Waktu <span class="text-red-500">*</span></label>
                    <textarea name="alasan_perpanjangan" required rows="4"
                        placeholder="Contoh: Dokumen sedang dikoordinasikan dengan bidang teknis terkait karena memerlukan penelaahan dan kompilasi data arsip..."
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-amber-500 outline-none text-sm transition-all"></textarea>
                    <p class="text-xs text-gray-400">Alasan ini akan otomatis dikirimkan ke email pemohon melalui surat pemberitahuan resmi.</p>
                </div>

                <div class="flex items-center justify-end gap-3 pt-3 border-t border-gray-100">
                    <button type="button" onclick="closePerpanjangModal()"
                        class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold text-sm rounded-xl transition-colors">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-6 py-2.5 bg-amber-600 hover:bg-amber-700 text-white font-bold text-sm rounded-xl shadow-md transition-all">
                        Perpanjang 7 Hari Kerja
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function toggleFormFields(status) {
            const boxTolak = document.getElementById('boxAlasanTolak');
            const boxFile = document.getElementById('boxFileJawaban');
            const alasanInput = document.getElementById('modalAlasanTolak');

            if (status === 'ditolak') {
                boxTolak.classList.remove('hidden');
                alasanInput.setAttribute('required', 'required');
            } else {
                boxTolak.classList.add('hidden');
                alasanInput.removeAttribute('required');
            }

            if (status === 'selesai') {
                boxFile.classList.remove('hidden');
            } else {
                boxFile.classList.add('hidden');
            }
        }

        function openUpdateModal(id, nomor, status, catatan, alasan) {
            const form = document.getElementById('updateForm');
            form.action = "{{ url('admin/permohonan') }}/" + id + "/status";

            document.getElementById('modalNomorRegistrasi').innerText = 'No. Reg: ' + (nomor || ('ID #' + id));
            document.getElementById('modalStatusSelect').value = status;
            document.getElementById('modalCatatan').value = catatan || '';
            document.getElementById('modalAlasanTolak').value = alasan || '';

            toggleFormFields(status);
            document.getElementById('updateModal').classList.remove('hidden');
        }

        function closeUpdateModal() {
            document.getElementById('updateModal').classList.add('hidden');
        }

        function openPerpanjangModal(id, nomor) {
            const form = document.getElementById('perpanjangForm');
            form.action = "{{ url('admin/permohonan') }}/" + id + "/perpanjang-sla";
            document.getElementById('perpanjangNomorReg').innerText = 'No. Reg: ' + (nomor || ('ID #' + id));
            document.getElementById('perpanjangModal').classList.remove('hidden');
        }

        function closePerpanjangModal() {
            document.getElementById('perpanjangModal').classList.add('hidden');
        }

        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll('.btn-open-modal').forEach(function(button) {
                button.addEventListener('click', function() {
                    openUpdateModal(
                        this.dataset.id,
                        this.dataset.nomor,
                        this.dataset.status,
                        this.dataset.catatan,
                        this.dataset.alasan
                    );
                });
            });

            document.querySelectorAll('.btn-open-perpanjang').forEach(function(button) {
                button.addEventListener('click', function() {
                    openPerpanjangModal(this.dataset.id, this.dataset.nomor);
                });
            });

            @if (session('success'))
                Swal.fire({
                    title: "Berhasil!",
                    text: @json(session('success')),
                    icon: "success",
                    confirmButtonText: "Tutup",
                    confirmButtonColor: "#14b8a6",
                    timer: 3500
                });
            @endif
        });
    </script>
@endsection
