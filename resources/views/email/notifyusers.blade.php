<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fix Asset ATMI</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .email-container {
            background-color: white;
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        /* Updated Header */
        .email-header {
            background-color: #007cba;
            padding: 30px;
            text-align: center;
            color: white;
        }

        .email-header img {
            max-width: 180px;
            height: auto;
            margin-bottom: 10px;
            border-radius: 4px;
        }

        .email-header h1 {
            margin: 10px 0;
            font-size: 22px;
        }

        .email-body {
            padding: 20px;
            text-align: left;
        }

        h1 {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }

        p {
            font-size: 16px;
            color: #666;
            line-height: 1.5;
            margin: 10px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        .table-header {
            background-color: #f5f5f5;
            font-weight: bold;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4184f3;
            color: white;
            text-decoration: none;
            font-size: 16px;
            border-radius: 4px;
            margin-top: 20px;
            text-align: center;
        }

        .btn:hover {
            background-color: #357ae8;
        }

        .email-footer {
            background-color: #f7f7f7; /* Light footer background */
            padding: 15px;
            text-align: center;
            font-size: 12px;
            color: #888;
        }

        .email-footer a {
            color: #007cba;
            text-decoration: none;
        }

      

        .contact-info {
            font-size: 14px;
            color: #555; /* Slightly darker for better visibility */
            margin-top: 10px;
        }

        small {
            display: block; /* Small text in its own line */
            margin-top: 10px;
            color: #555; /* Slightly darker for better visibility */
        }

        .contact-info {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
        }

        @media (max-width: 600px) {
            .email-body {
                padding: 15px;
            }

            h1 {
                font-size: 20px;
            }

            p {
                font-size: 14px;
            }

            .btn {
                padding: 8px 16px;
                font-size: 14px;
            }

            .email-header img {
                max-width: 150px;
            }

            .email-footer {
                flex-direction: column;
                font-size: 12px;
            }

            .email-footer a {
                display: block;
                margin: 5px 0;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <img src="{{ asset('fixasetlogormv.png') }}" alt="Company Logo">
            <h1 style="color: #f0f0f0;">Fixed Asset ATMI</h1>
        </div>
        <div class="email-body">
            <h1>Halo!</h1>
            <p>Pengajuan Fix Asset Menunggu Tindakan Anda:</p>

            <table>
                <tr>
                    <td class="table-header">Diajukan oleh:</td>
                    <td><strong>{{$permintaan->user->userdetail->nama_lengkap}}</strong></td>
                </tr>
                <tr>
                    <td class="table-header">Diajukan Tanggal:</td>
                    <td><strong>{{ \Carbon\Carbon::parse($permintaan->created_at)->translatedFormat('d F Y H:i') }} WIB</strong></td>
                </tr>
                <tr>
                    <td class="table-header">Jenis Ajuan:</td>
                    <td><strong>FIX ASSET</strong></td>
                </tr>
                <tr>
                    <td class="table-header">Deskripsi Ajuan:</td>
                    <td><strong>{{$permintaan->deskripsi_permintaan}}</strong></td>
                </tr>
                <tr>
                    <td class="table-header">Status Permohonan:</td>
                    <td><strong>{{$permintaan->status_permohonan}}</strong></td>
                </tr>
                <tr>
                    <td class="table-header">STATUS</td>
                    @if($permintaan->status == 'disetujui')
                        <td><span class="badge badge-success">Disetujui</span></td>
                    @elseif($permintaan->status == 'ditolak')
                        <td><span class="badge badge-danger">Ditolak</span></td>
                    @elseif($permintaan->status == null || $permintaan->status == 'menunggu' )
                        <td><span class="badge badge-warning">Pending Approval</span></td>
                    @elseif($permintaan->status == 'delayed')
                        <td><span class="badge badge-info">Pending Delay</span></td>
                
                    @endif
                    
                    

                </tr>
                @if($permintaan->delay_id != null)
                <tr>
                    <td class="table-header">Alasan Delay:</td>
                    <td><small>{{$permintaan->catatan}}</small></td>
                </tr>
                <tr>
                    <td class="table-header">Waktu Delay:</td>
                    <td><small>Sampai dengan {{$permintaan->delay_timestamp}}</small></td>
                </tr>
                @endif
                @if($permintaan->status == 'tolak')

                <tr>
                    <td class="table-header">Alasan Penolakan:</td>
                    <td><small><strong>[Alasan Penolakan]</strong></small></td>
                </tr>
                <tr>
                    <td class="table-header">Ditolak oleh:</td>
                    <td><small><strong>[Official FixAsset]</strong></small></td>
                </tr>
                @endif
            </table>

            <a href="#" class="btn">Lihat Sekarang</a>

            <p>Salam Hangat.</p>
            <p>IT ATMI YKBS</p>
        </div>
        <div class="email-footer">
            <div class="contact-info">
                <p>Email: <a href="mailto:itatmicorp@gmail.com">itatmicorp@gmail.com</a></p>
                <p>Staff Email: <a href="mailto:daniel@atmi.co.id">daniel@atmi.co.id</a></p>
                <p>No. Telp: +(62) 271-714466</p>
            </div>
        </div>
    </div>
</body>
</html>
