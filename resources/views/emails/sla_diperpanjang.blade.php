<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemberitahuan Perpanjangan Waktu Pelayanan</title>
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
            background: linear-gradient(135deg, #d97706 0%, #f59e0b 100%);
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
            background: #fef3c7;
            color: #92400e;
            padding: 6px 14px;
            border-radius: 9999px;
            font-size: 13px;
            font-weight: 700;
            border: 1px solid #fde68a;
            margin-bottom: 18px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin: 16px 0;
        }
        .table td {
            padding: 10px 12px;
            font-size: 14px;
            border-bottom: 1px solid #f1f5f9;
        }
        .table td.label {
            font-weight: 600;
            color: #64748b;
            width: 38%;
        }
        .table td.value {
            color: #1e293b;
            font-weight: 500;
        }
        .alert-box {
            background: #fffbeb;
            border-left: 4px solid #f59e0b;
            padding: 14px 18px;
            border-radius: 6px;
            margin: 18px 0;
            font-size: 14px;
            line-height: 1.5;
            color: #78350f;
        }
        .btn-track {
            display: inline-block;
            background: #0f766e;
            color: #ffffff;
            text-decoration: none;
            padding: 12px 28px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 14px;
            margin-top: 14px;
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
            <p>Pemberitahuan Perpanjangan Waktu Pelayanan</p>
        </div>
        <div class="body">
            <p>Halo <strong>{{ $permohonan->nama_lengkap }}</strong>,</p>
            <p>Sehubungan dengan permohonan informasi publik yang Anda ajukan dengan nomor registrasi <strong>{{ $permohonan->nomor_registrasi }}</strong>, PPID Dispora Jatim memberitahukan perpanjangan batas waktu layanan sesuai amanat Pasal 22 ayat (8) Undang-Undang No. 14 Tahun 2008:</p>

            <div style="text-align: center;">
                <span class="badge">Perpanjangan Waktu: 7 Hari Kerja Tambahan</span>
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
            </table>

            <div class="alert-box">
                <strong>Alasan Resmi Perpanjangan Waktu Pelayanan:</strong><br>
                <p style="margin: 8px 0 0 0; white-space: pre-line;">{{ $permohonan->alasan_perpanjangan }}</p>
            </div>

            <p style="font-size: 13px; color: #475569;">
                Petugas PPID sedang mengoordinasikan permohonan Anda dengan unit kerja terkait untuk menyiapkan tanggapan dan dokumen yang dibutuhkan secara lengkap dan akurat.
            </p>

            <div style="text-align: center;">
                <a href="{{ route('permohonan.lacak', ['nomor' => $permohonan->nomor_registrasi]) }}" class="btn-track" target="_blank">
                    Pantau Perkembangan Status
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
