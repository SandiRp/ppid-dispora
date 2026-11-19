<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembaruan Status Permohonan Informasi</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: #f8fafc;
            color: #334155;
            margin: 0;
            padding: 24px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
        }
        .header {
            background: linear-gradient(135deg, #0f766e 0%, #14b8a6 100%);
            color: #ffffff;
            padding: 28px 24px;
            text-align: center;
        }
        .header h1 {
            margin: 0 0 8px 0;
            font-size: 22px;
            font-weight: 700;
        }
        .header p {
            margin: 0;
            font-size: 14px;
            opacity: 0.9;
        }
        .body {
            padding: 28px 24px;
        }
        .status-pill {
            display: inline-block;
            padding: 8px 18px;
            border-radius: 9999px;
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 10px 0 20px 0;
        }
        .status-menunggu { background: #fef3c7; color: #92400e; border: 1px solid #fde68a; }
        .status-diproses { background: #dbeafe; color: #1e40af; border: 1px solid #bfdbfe; }
        .status-selesai  { background: #dcfce7; color: #166534; border: 1px solid #bbf7d0; }
        .status-ditolak  { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 16px;
        }
        .table td {
            padding: 10px 0;
            border-bottom: 1px solid #f1f5f9;
            font-size: 14px;
            vertical-align: top;
        }
        .table td.label {
            width: 38%;
            color: #64748b;
            font-weight: 500;
        }
        .table td.value {
            color: #1e293b;
            font-weight: 600;
        }
        .notes-box {
            background: #f1f5f9;
            border-left: 4px solid #0f766e;
            padding: 14px 18px;
            border-radius: 6px;
            margin-top: 16px;
            font-size: 14px;
            line-height: 1.5;
        }
        .btn-track {
            display: inline-block;
            margin-top: 24px;
            background: #0f766e;
            color: #ffffff !important;
            text-decoration: none;
            padding: 12px 28px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
        }
        .footer {
            background: #f8fafc;
            padding: 20px 24px;
            text-align: center;
            font-size: 12px;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>PPID DISPORA JAWA TIMUR</h1>
            <p>Pemberitahuan Status Permohonan Informasi</p>
        </div>
        <div class="body">
            <p>Halo <strong>{{ $permohonan->nama_lengkap }}</strong>,</p>
            <p>Status permohonan informasi Anda dengan nomor registrasi <strong>{{ $permohonan->nomor_registrasi }}</strong> telah diperbarui oleh Admin:</p>

            <div style="text-align: center;">
                <div class="status-pill status-{{ $permohonan->status }}">
                    Status: {{ ucfirst($permohonan->status) }}
                </div>
            </div>

            <table class="table">
                <tr>
                    <td class="label">Nomor Registrasi</td>
                    <td class="value">{{ $permohonan->nomor_registrasi }}</td>
                </tr>
                <tr>
                    <td class="label">Nama Pemohon</td>
                    <td class="value">{{ $permohonan->nama_lengkap }}</td>
                </tr>
                <tr>
                    <td class="label">Rincian Informasi</td>
                    <td class="value">{{ $permohonan->rincian_informasi }}</td>
                </tr>
                <tr>
                    <td class="label">Waktu Pembaruan</td>
                    <td class="value">{{ now()->format('d M Y, H:i') }} WIB</td>
                </tr>
            </table>

            @if ($permohonan->alasan_penolakan)
                <div style="background: #fef2f2; border-left: 4px solid #ef4444; padding: 14px 18px; border-radius: 6px; margin-top: 16px; font-size: 14px; line-height: 1.5; color: #991b1b;">
                    <strong>Dasar Alasan Penolakan Resmi:</strong><br>
                    <p style="margin: 8px 0 0 0; white-space: pre-line;">{{ $permohonan->alasan_penolakan }}</p>
                    <div style="margin-top: 10px; font-size: 12px; color: #b91c1c;">
                        Apabila Anda berkeberatan atas penolakan ini, Anda berhak mengajukan keberatan kepada Atasan PPID melalui portal resmi kami selambat-lambatnya 30 hari kerja.
                    </div>
                </div>
            @endif

            @if ($permohonan->file_jawaban)
                <div style="background: #ecfdf5; border-left: 4px solid #10b981; padding: 14px 18px; border-radius: 6px; margin-top: 16px; font-size: 14px; line-height: 1.5; color: #065f46;">
                    <strong>Berkas Informasi / Jawaban Resmi Telah Diunggah:</strong><br>
                    <p style="margin: 6px 0 0 0;">Petugas PPID telah melampirkan berkas informasi yang Anda minta. Anda dapat mengunduhnya melalui halaman pelacakan status permohonan.</p>
                </div>
            @endif

            @if ($permohonan->catatan_admin)
                <div class="notes-box">
                    <strong>Catatan / Keterangan dari Petugas PPID:</strong><br>
                    <p style="margin: 8px 0 0 0; white-space: pre-line;">{{ $permohonan->catatan_admin }}</p>
                </div>
            @endif

            @if ($permohonan->status == 'selesai')
                <div style="background: #f0fdfa; border: 1px solid #99f6e4; padding: 18px; border-radius: 8px; margin-top: 18px; text-align: center;">
                    <strong style="color: #0f766e; font-size: 15px;">Bagaimana Penilaian Anda Terhadap Layanan Kami?</strong>
                    <p style="margin: 8px 0 14px 0; font-size: 13px; color: #115e59;">Bantu PPID Dispora Jatim meningkatkan mutu pelayanan publik dengan mengisi Survei Kepuasan Masyarakat (IKM) secara online.</p>
                    <a href="{{ route('survei.create', ['nomor' => $permohonan->nomor_registrasi]) }}"
                       style="display: inline-block; padding: 10px 22px; background: #0f766e; color: #ffffff; text-decoration: none; border-radius: 8px; font-weight: 700; font-size: 13px;">
                        Isi Survei Kepuasan (IKM) &rarr;
                    </a>
                </div>
            @endif

            <div style="text-align: center;">
                <a href="{{ route('permohonan.lacak', ['nomor' => $permohonan->nomor_registrasi]) }}" class="btn-track" target="_blank">
                    Lihat Rincian di Portal PPID
                </a>
            </div>
        </div>
        <div class="footer">
            Email ini dikirim secara otomatis oleh Sistem PPID Dinas Kepemudaan dan Olahraga Provinsi Jawa Timur.<br>
            Jl. Kayoon No.56, Embong Kaliasin, Kec. Genteng, Surabaya, Jawa Timur 60271
        </div>
    </div>
</body>
</html>
