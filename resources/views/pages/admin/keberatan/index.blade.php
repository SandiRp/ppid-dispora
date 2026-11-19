@extends('layouts.admin')

@section('title', 'Kelola Keberatan Informasi - Admin PPID')

@section('content')
    <div class="max-w-7xl mx-auto space-y-6">

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-6 border-b border-gray-200">
            <div>
                <h1 class="text-3xl font-black text-gray-900 mb-1">Pengajuan Keberatan Informasi</h1>
                <p class="text-gray-500 text-sm">Daftar pengajuan keberatan masyarakat untuk ditindaklanjuti secara resmi oleh Atasan PPID.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.keberatan.export', request()->query()) }}"
                    class="px-4 py-2.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border border-emerald-300 font-bold text-xs rounded-xl shadow-sm transition-all flex items-center gap-2">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Ekspor CSV (Excel)
                </a>
                <div class="px-4 py-2 bg-red-50 border border-red-200 text-red-700 font-semibold rounded-xl text-xs">
                    Total: {{ $keberatans->total() }} Keberatan
                </div>
            </div>
        </div>

        <!-- Filter & Search Bar -->
        <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm">
            <form action="{{ route('admin.keberatan.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <div class="sm:col-span-2">
                    <input type="text" name="q" value="{{ request('q') }}"
                        placeholder="Cari No. Keberatan, Pemohon, Email, atau No. Registrasi Permohonan..."
                        class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-xs focus:bg-white focus:ring-2 focus:ring-red-500 outline-none">
                </div>
                <div class="flex items-center gap-2">
                    <button type="submit" class="w-full py-2 bg-gray-800 hover:bg-gray-900 text-white font-bold text-xs rounded-xl transition-colors">
                        Cari Keberatan
                    </button>
                    @if (request()->hasAny(['q', 'status']))
                        <a href="{{ route('admin.keberatan.index') }}" class="px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 text-xs font-bold rounded-xl transition-colors">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-600">
                    <thead class="bg-gray-50 text-gray-800 border-b border-gray-200 uppercase text-xs tracking-wider">
                        <tr>
                            <th class="py-4 px-6 font-semibold text-center w-16">No</th>
                            <th class="py-4 px-6 font-semibold">No. Keberatan & Waktu</th>
                            <th class="py-4 px-6 font-semibold">Terkait Permohonan</th>
                            <th class="py-4 px-6 font-semibold">Alasan & Dalil</th>
                            <th class="py-4 px-6 font-semibold text-center">Status</th>
                            <th class="py-4 px-6 font-semibold text-center">Aksi / Tanggapan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($keberatans as $index => $item)
                            <tr class="hover:bg-red-50/30 transition-colors">
                                <td class="py-4 px-6 text-center text-gray-500">{{ $keberatans->firstItem() + $index }}</td>

                                <td class="py-4 px-6 whitespace-nowrap">
                                    <div class="font-bold text-red-700 font-mono">{{ $item->nomor_keberatan }}</div>
                                    <div class="text-xs text-gray-500">{{ $item->created_at->format('d M Y, H:i') }} WIB</div>
                                    <div class="text-xs text-gray-700 font-semibold mt-1">{{ $item->nama_pemohon }}</div>
                                    <div class="text-xs text-gray-400">{{ $item->email }} | {{ $item->nomor_telepon ?? '-' }}</div>
                                </td>

                                <td class="py-4 px-6 whitespace-nowrap">
                                    <div class="text-xs font-semibold text-gray-700">No. Reg:</div>
                                    <div class="font-mono text-xs text-tosca-700 font-bold">{{ $item->permohonan->nomor_registrasi ?? ('ID #' . $item->permohonan_id) }}</div>
                                    <div class="text-xs text-gray-500 mt-1 max-w-[200px] truncate" title="{{ $item->permohonan->rincian_informasi ?? '' }}">
                                        {{ $item->permohonan->rincian_informasi ?? '-' }}
                                    </div>
                                </td>

                                <td class="py-4 px-6 min-w-[280px] max-w-[360px] align-top">
                                    <div class="font-bold text-xs text-red-700 mb-1">{{ $item->alasan_keberatan }}</div>
                                    <div class="p-2.5 bg-gray-50 border border-gray-200 rounded-lg text-xs text-gray-700 whitespace-pre-wrap break-words max-h-28 overflow-y-auto">
                                        {{ $item->keterangan_keberatan }}
                                    </div>

                                    @if ($item->tanggapan_atasan_ppid)
                                        <div class="mt-2 p-2 bg-emerald-50 border border-emerald-200 rounded-lg text-xs text-emerald-900">
                                            <span class="font-bold block mb-0.5">Tanggapan Atasan PPID:</span>
                                            <span class="whitespace-pre-wrap break-words">{{ $item->tanggapan_atasan_ppid }}</span>
                                        </div>
                                    @endif
                                </td>

                                <td class="py-4 px-6 text-center whitespace-nowrap">
                                    @if ($item->status == 'menunggu')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 border border-yellow-200">
                                            Menunggu Tindak Lanjut
                                        </span>
                                    @elseif ($item->status == 'diproses')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 border border-blue-200">
                                            Sedang Ditinjau
                                        </span>
                                    @elseif ($item->status == 'selesai')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                            Dikabulkan / Selesai
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 border border-red-200">
                                            Keberatan Ditolak
                                        </span>
                                    @endif

                                    <!-- Indikator SLA 30 Hari Kerja (Pasal 36 UU KIP) -->
                                    @php $sla = $item->sla_info; @endphp
                                    <div class="mt-2">
                                        @if ($sla['status_sla'] === 'completed')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-gray-100 text-gray-600">
                                                ✓ Selesai ({{ $item->tanggal_tanggapan ? $item->tanggal_tanggapan->format('d/m/Y') : '-' }})
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

                                <td class="py-4 px-6 text-center space-y-2 min-w-[170px]">
                                    @if ($item->file_pendukung)
                                        <a href="{{ route('admin.keberatan.berkas', $item->id) }}" target="_blank"
                                            class="inline-flex items-center justify-center w-full px-3 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold rounded border border-gray-300 transition-colors">
                                            <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                                            </svg>
                                            Lihat Bukti
                                        </a>
                                    @endif

                                    @if (auth()->user()->role === 'superadmin')
                                        <button type="button"
                                            class="btn-open-tanggapan inline-flex items-center justify-center w-full px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded shadow transition-all"
                                            data-id="{{ $item->id }}"
                                            data-nomor="{{ $item->nomor_keberatan }}"
                                            data-status="{{ $item->status }}"
                                            data-tanggapan="{{ e($item->tanggapan_atasan_ppid ?? '') }}">
                                            Beri Tanggapan
                                        </button>
                                    @else
                                        <span class="inline-flex items-center justify-center w-full px-2 py-1.5 bg-gray-100 text-gray-400 text-[11px] font-semibold rounded border border-gray-200 cursor-not-allowed" title="Hanya Super Admin / Atasan PPID yang berwenang menanggapi keberatan">
                                            Khusus Atasan PPID
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center text-gray-500">Belum ada pengajuan keberatan yang masuk.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($keberatans->hasPages())
                <div class="p-4 border-t border-gray-100">
                    {{ $keberatans->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Modal Tanggapan Atasan PPID -->
    <div id="tanggapanModal" class="fixed inset-0 z-50 hidden bg-gray-900/60 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-lg w-full p-6 md:p-8 shadow-2xl relative">
            <div class="flex items-center justify-between pb-4 border-b border-gray-100">
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Tanggapan Atasan PPID</h3>
                    <p class="text-xs text-gray-500" id="modalKeberatanNomor">No. Keberatan: -</p>
                </div>
                <button type="button" onclick="closeTanggapanModal()" class="text-gray-400 hover:text-gray-600 p-1.5 rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <form id="tanggapanForm" method="POST" action="" class="space-y-4 pt-4">
                @csrf
                @method('PUT')

                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Status Penyelesaian Keberatan <span class="text-red-500">*</span></label>
                    <select name="status" id="modalKeberatanStatus" required
                        class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-red-500 outline-none text-sm font-medium">
                        <option value="diproses">⚙️ Sedang Diproses / Ditinjau</option>
                        <option value="selesai">✅ Selesai (Keberatan Dikabulkan/Dipenuhi)</option>
                        <option value="ditolak">❌ Ditolak (Keberatan Tidak Diterima)</option>
                    </select>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Tanggapan & Pertimbangan Atasan PPID <span class="text-red-500">*</span></label>
                    <textarea name="tanggapan_atasan_ppid" id="modalKeberatanTeks" required rows="5"
                        placeholder="Tuliskan keputusan, pertimbangan hukum, dan petunjuk penyelesaian resmi dari Atasan PPID..."
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-red-500 outline-none text-sm"></textarea>
                    <p class="text-xs text-gray-400">Tanggapan ini akan otomatis dikirimkan ke email pemohon keberatan.</p>
                </div>

                <div class="flex items-center justify-end gap-3 pt-3 border-t border-gray-100">
                    <button type="button" onclick="closeTanggapanModal()"
                        class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold text-sm rounded-xl transition-colors">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-6 py-2.5 bg-red-600 hover:bg-red-700 text-white font-bold text-sm rounded-xl shadow-md transition-all">
                        Simpan & Kirim Tanggapan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function openTanggapanModal(id, nomor, status, tanggapan) {
            const form = document.getElementById('tanggapanForm');
            form.action = "{{ url('admin/keberatan') }}/" + id + "/tanggapan";

            document.getElementById('modalKeberatanNomor').innerText = 'No. Keberatan: ' + nomor;
            document.getElementById('modalKeberatanStatus').value = status || 'diproses';
            document.getElementById('modalKeberatanTeks').value = tanggapan || '';

            document.getElementById('tanggapanModal').classList.remove('hidden');
        }

        function closeTanggapanModal() {
            document.getElementById('tanggapanModal').classList.add('hidden');
        }

        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll('.btn-open-tanggapan').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    openTanggapanModal(
                        this.dataset.id,
                        this.dataset.nomor,
                        this.dataset.status,
                        this.dataset.tanggapan
                    );
                });
            });

            @if (session('success'))
                Swal.fire({
                    title: "Berhasil!",
                    text: @json(session('success')),
                    icon: "success",
                    confirmButtonText: "Tutup",
                    confirmButtonColor: "#dc2626",
                    timer: 3500
                });
            @endif
        });
    </script>
@endsection
