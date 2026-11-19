<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permohonan Informasi Baru Masuk</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: #f1f5f9;
            color: #334155;
            margin: 0;
            padding: 24px;
        }
        .container {
            max-width: 620px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid #cbd5e1;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.08);
        }
        .header {
            background: linear-gradient(135deg, #047857 0%, #0d9488 100%);
            color: #ffffff;
            padding: 26px 24px;
            text-align: center;
        }
        .header h1 {
            margin: 0 0 6px 0;
            font-size: 20px;
            font-weight: 700;
        }
        .header p {
            margin: 0;
            font-size: 13px;
            opacity: 0.95;
        }
        .body {
            padding: 28px 24px;
        }
        .reg-pill {
            display: inline-block;
            background: #ecfdf5;
            color: #065f46;
            border: 1px solid #a7f3d0;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 800;
            letter-spacing: 0.5px;
            margin: 10px 0 20px 0;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 14px;
        }
        .table td {
            padding: 10px 8px;
            border-bottom: 1px solid #f1f5f9;
            font-size: 13px;
            vertical-align: top;
        }
        .table td.label {
            width: 32%;
            color: #64748b;
            font-weight: 600;
        }
        .table td.value {
            color: #1e293b;
        }
        .content-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 12px;
            margin-top: 4px;
            white-space: pre-wrap;
            line-height: 1.5;
            color: #1e293b;
            font-size: 13px;
        }
        .btn-action {
            display: inline-block;
            margin-top: 24px;
            background: #0d9488;
            color: #ffffff !important;
            text-decoration: none;
            padding: 12px 28px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 14px;
        }
        .footer {
            background: #f8fafc;
            padding: 18px 24px;
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
            <h1>NOTIFIKASI PERMOHONAN INFORMASI MASUK</h1>
            <p>Sistem PPID Dinas Kepemudaan dan Olahraga Provinsi Jawa Timur</p>
        </div>
        <div class="body">
            <p>Halo <strong>Tim Admin PPID Dispora Jatim</strong>,</p>
            <p>Terdapat permohonan informasi publik baru yang diajukan oleh masyarakat melalui website. Berikut ringkasan datanya:</p>

            <div style="text-align: center;">
                <div class="reg-pill">{{ $permohonan->nomor_registrasi }}</div>
            </div>

            <table class="table">
                <tr>
                    <td class="label">Nama Pemohon</td>
                    <td class="value"><strong>{{ $permohonan->nama_lengkap }}</strong> ({{ ucfirst($permohonan->kategori) }})</td>
                </tr>
                <tr>
                    <td class="label">NIK / Identitas</td>
                    <td class="value">{{ $permohonan->nik_identitas }}</td>
                </tr>
                <tr>
                    <td class="label">Email Pemohon</td>
                    <td class="value"><a href="mailto:{{ $permohonan->email }}">{{ $permohonan->email }}</a></td>
                </tr>
                <tr>
                    <td class="label">Nomor Telp/WA</td>
                    <td class="value"><strong>{{ $permohonan->nomor_telepon ?? '-' }}</strong></td>
                </tr>
                <tr>
                    <td class="label">Tanggal Masuk</td>
                    <td class="value">{{ $permohonan->created_at->format('d M Y, H:i') }} WIB</td>
                </tr>
                <tr>
                    <td class="label">Rincian Informasi</td>
                    <td class="value">
                        <div class="content-box">{{ $permohonan->rincian_informasi }}</div>
                    </td>
                </tr>
                <tr>
                    <td class="label">Tujuan Penggunaan</td>
                    <td class="value">
                        <div class="content-box">{{ $permohonan->tujuan_penggunaan }}</div>
                    </td>
                </tr>
            </table>

            <div style="text-align: center;">
                <a href="{{ route('admin.permohonan.index') }}" class="btn-action" target="_blank">
                    Buka Panel Admin Permohonan &rarr;
                </a>
            </div>
        </div>
        <div class="footer">
            Pemberitahuan otomatis ke: <strong>disporajatim2024@gmail.com</strong><br>
            Sistem Layanan PPID Dinas Kepemudaan dan Olahraga Provinsi Jawa Timur
        </div>
    </div>
</body>
</html>
