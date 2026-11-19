<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukti Pengajuan Permohonan Informasi</title>
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
        .badge {
            display: inline-block;
            background: #f0fdfa;
            color: #0f766e;
            border: 1px solid #99f6e4;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 18px;
            font-weight: 700;
            letter-spacing: 1px;
            margin: 12px 0 20px 0;
        }
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
            <p>Konfirmasi Penerimaan Permohonan Informasi Publik</p>
        </div>
        <div class="body">
            <p>Halo <strong>{{ $permohonan->nama_lengkap }}</strong>,</p>
            <p>Permohonan informasi publik Anda telah berhasil terdaftar ke dalam sistem kami. Simpan Nomor Registrasi berikut untuk memantau proses penyelesaian informasi:</p>

            <div style="text-align: center;">
                <div class="badge">{{ $permohonan->nomor_registrasi }}</div>
            </div>

            <table class="table">
                <tr>
                    <td class="label">Kategori Pemohon</td>
                    <td class="value">{{ ucfirst($permohonan->kategori) }}</td>
                </tr>
                <tr>
                    <td class="label">Tanggal Pengajuan</td>
                    <td class="value">{{ $permohonan->created_at->format('d M Y, H:i') }} WIB</td>
                </tr>
                <tr>
                    <td class="label">Nomor Telepon/WA</td>
                    <td class="value">{{ $permohonan->nomor_telepon ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Rincian Informasi</td>
                    <td class="value">{{ $permohonan->rincian_informasi }}</td>
                </tr>
                <tr>
                    <td class="label">Tujuan Penggunaan</td>
                    <td class="value">{{ $permohonan->tujuan_penggunaan }}</td>
                </tr>
                <tr>
                    <td class="label">Status Saat Ini</td>
                    <td class="value"><span style="color: #d97706;">Menunggu Verifikasi</span></td>
                </tr>
            </table>

            <div style="text-align: center;">
                <a href="{{ route('permohonan.lacak', ['nomor' => $permohonan->nomor_registrasi]) }}" class="btn-track" target="_blank">
                    Lacak Status Permohonan
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
