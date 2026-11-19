<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tanggapan Atasan PPID atas Keberatan Informasi</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: #f8fafc; color: #334155; margin: 0; padding: 24px; }
        .container { max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); }
        .header { background: linear-gradient(135deg, #0f766e 0%, #14b8a6 100%); color: #ffffff; padding: 26px 24px; text-align: center; }
        .header h1 { margin: 0 0 6px 0; font-size: 20px; font-weight: 700; }
        .body { padding: 28px 24px; }
        .pill { display: inline-block; padding: 6px 16px; border-radius: 9999px; font-weight: 800; font-size: 13px; text-transform: uppercase; margin: 10px 0 16px 0; }
        .pill-selesai { background: #dcfce7; color: #166534; }
        .pill-ditolak { background: #fee2e2; color: #991b1b; }
        .table { width: 100%; border-collapse: collapse; margin-top: 14px; }
        .table td { padding: 9px 4px; border-bottom: 1px solid #f1f5f9; font-size: 13px; vertical-align: top; }
        .table td.label { width: 36%; color: #64748b; font-weight: 600; }
        .table td.value { color: #1e293b; font-weight: 600; }
        .response-box { background: #f0fdfa; border-left: 4px solid #0f766e; padding: 14px; border-radius: 6px; margin-top: 16px; line-height: 1.6; font-size: 14px; }
        .footer { background: #f8fafc; padding: 18px 24px; text-align: center; font-size: 12px; color: #94a3b8; border-top: 1px solid #e2e8f0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>PPID DISPORA JAWA TIMUR</h1>
            <p>Pemberitahuan Tanggapan Atasan PPID atas Keberatan</p>
        </div>
        <div class="body">
            <p>Halo <strong>{{ $keberatan->nama_pemohon }}</strong>,</p>
            <p>Pengajuan keberatan Anda dengan nomor registrasi <strong>{{ $keberatan->nomor_keberatan }}</strong> telah ditanggapi oleh Atasan PPID:</p>

            <div style="text-align: center;">
                <div class="pill pill-{{ $keberatan->status }}">Status: {{ ucfirst($keberatan->status) }}</div>
            </div>

            <table class="table">
                <tr>
                    <td class="label">Nomor Keberatan</td>
                    <td class="value">{{ $keberatan->nomor_keberatan }}</td>
                </tr>
                <tr>
                    <td class="label">Alasan Keberatan</td>
                    <td class="value">{{ $keberatan->alasan_keberatan }}</td>
                </tr>
                <tr>
                    <td class="label">Waktu Tanggapan</td>
                    <td class="value">{{ now()->format('d M Y, H:i') }} WIB</td>
                </tr>
            </table>

            <div class="response-box">
                <strong style="color: #0f766e; display: block; margin-bottom: 6px;">Keputusan / Tanggapan Resmi Atasan PPID:</strong>
                <div style="white-space: pre-wrap; color: #1e293b;">{{ $keberatan->tanggapan_atasan_ppid ?? 'Tanggapan telah diproses oleh atasan PPID.' }}</div>
            </div>
        </div>
        <div class="footer">
            Sistem Layanan PPID Dinas Kepemudaan dan Olahraga Provinsi Jawa Timur
        </div>
    </div>
</body>
</html>
