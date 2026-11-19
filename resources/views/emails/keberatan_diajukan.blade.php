<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukti Pengajuan Keberatan Informasi Publik</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: #f8fafc; color: #334155; margin: 0; padding: 24px; }
        .container { max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); }
        .header { background: linear-gradient(135deg, #b91c1c 0%, #dc2626 100%); color: #ffffff; padding: 26px 24px; text-align: center; }
        .header h1 { margin: 0 0 6px 0; font-size: 20px; font-weight: 700; }
        .body { padding: 28px 24px; }
        .badge { display: inline-block; background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; padding: 8px 16px; border-radius: 8px; font-size: 17px; font-weight: 800; margin: 10px 0 20px 0; }
        .table { width: 100%; border-collapse: collapse; margin-top: 14px; }
        .table td { padding: 9px 4px; border-bottom: 1px solid #f1f5f9; font-size: 13px; vertical-align: top; }
        .table td.label { width: 36%; color: #64748b; font-weight: 600; }
        .table td.value { color: #1e293b; font-weight: 600; }
        .box { background: #f8fafc; border: 1px solid #e2e8f0; padding: 10px; border-radius: 6px; margin-top: 4px; font-weight: normal; }
        .footer { background: #f8fafc; padding: 18px 24px; text-align: center; font-size: 12px; color: #94a3b8; border-top: 1px solid #e2e8f0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>PPID DISPORA JAWA TIMUR</h1>
            <p>Bukti Pengajuan Keberatan Informasi Publik</p>
        </div>
        <div class="body">
            <p>Halo <strong>{{ $keberatan->nama_pemohon }}</strong>,</p>
            <p>Pengajuan keberatan Anda atas tindak lanjut permohonan informasi telah berhasil didaftarkan dan akan segera diperiksa oleh <strong>Atasan PPID</strong> sesuai ketentuan perundang-undangan.</p>

            <div style="text-align: center;">
                <div class="badge">{{ $keberatan->nomor_keberatan }}</div>
            </div>

            <table class="table">
                <tr>
                    <td class="label">Terkait Permohonan</td>
                    <td class="value">{{ $keberatan->permohonan->nomor_registrasi ?? ('ID #' . $keberatan->permohonan_id) }}</td>
                </tr>
                <tr>
                    <td class="label">Alasan Keberatan</td>
                    <td class="value">{{ $keberatan->alasan_keberatan }}</td>
                </tr>
                <tr>
                    <td class="label">Keterangan / Dalil</td>
                    <td class="value">
                        <div class="box">{{ $keberatan->keterangan_keberatan }}</div>
                    </td>
                </tr>
                <tr>
                    <td class="label">Tanggal Pengajuan</td>
                    <td class="value">{{ $keberatan->created_at->format('d M Y, H:i') }} WIB</td>
                </tr>
                <tr>
                    <td class="label">Tenggat Waktu Respons</td>
                    <td class="value">Maksimal 30 hari kerja sejak diterima</td>
                </tr>
            </table>
        </div>
        <div class="footer">
            Sistem Layanan PPID Dinas Kepemudaan dan Olahraga Provinsi Jawa Timur
        </div>
    </div>
</body>
</html>
