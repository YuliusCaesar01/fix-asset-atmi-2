<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Serah Terima Aset Tetap</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
        @page {
            size: legal; /* Sets paper size to Legal */
            margin: 0cm; /* Adjust margins if needed */
        }
        }
        body {
            background-color: white;
            color: black;
        }
        #toble {
            border: 1px solid black;
            border-collapse: collapse;
        }
        #teble {
            border: 1px solid black;
            border-collapse: collapse;
        }
        th, td {
            padding: 4px;
            text-align: left;
        }
    </style>
     <script>
        // Function to trigger print dialog
        function autoPrint() {
            window.print();
        }

        // Trigger the print dialog when the page loads
        window.onload = autoPrint;
    </script>
</head>
<body class="font-sans">
    @php
    use App\Models\User;
    $datadirmanaset = User::where('role_id', 18)->first();
    if($pfa->id_institusi == 1){
       $tipe = $pfa->tipe->nama_tipe_yayasan;
       $kelompok = $pfa->kelompok->nama_kelompok_yayasan;
       $jenis = $pfa->jenis->nama_jenis_yayasan;
       $ruang = $pfa->ruang->nama_ruang_yayasan;
    }elseif($pfa->id_institusi == 2){
       $tipe = $pfa->tipe->nama_tipe_mikael;
       $kelompok = $pfa->kelompok->nama_kelompok_mikael;
       $jenis = $pfa->jenis->nama_jenis_mikael;
       $ruang = $pfa->ruang->nama_ruang_mikael;

    }else{
        $tipe = $pfa->tipe->nama_tipe_politeknik;
       $kelompok = $pfa->kelompok->nama_kelompok_politeknik;
       $jenis = $pfa->jenis->nama_jenis_politeknik;
       $ruang = $pfa->ruang->nama_ruang_politeknik;

    }
    @endphp

    <div class="max-w-3xl mx-auto p-6">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-lg font-bold uppercase">Yayasan Karya Bakti Surakarta</h1>
            <p class="text-sm">Jl. Mojo No. 1 , Karangasem, Laweyan, Surakarta 57145</p>
            <p class="text-sm">Telepon: (0271) 714466 * Email : ykbs@yayasankaryabakti.org</p>
            <hr class="border-t border-gray-700 my-4">
        </div>
        <div id="teble" >

        <!-- Title Section -->
        <div class="text-center mb-5">
            <br>
            <h1 class="text-2xl font-bold">BERITA ACARA SERAH TERIMA ASET TETAP</h1>
        </div>
       </div>
        <!-- Table Info -->
        <div class="mb-8">
            <table id="toble" class="w-full text-sm">
                <tr>
                    <td>Nomor</td>
                    <td>: &nbsp;&nbsp;&nbsp; {{ str_pad($bast->id_bast, 2, '0', STR_PAD_LEFT) . '/' . $bast->BAST . '/' . $bast->bulan . '/' . $bast->tahun}}</td>
                    <td>Dari</td>
                    <td>: &nbsp;&nbsp;&nbsp; Dir Manajemen Aset</td>
                </tr>
                <tr>
                    <td>Tanggal</td>
                    <td>: &nbsp;&nbsp;&nbsp; {{ strftime('%d %B %Y', strtotime($pfa->valid_dirmanageraset_timestamp)) }}</td>
                    <td>Kepada</td>
                    <td>: &nbsp;&nbsp;&nbsp;  {{ ucfirst($pfa->user->username) }}</td>
                </tr>
                <tr>
                    <td>Hal</td>
                    <td>: &nbsp;&nbsp;&nbsp; Serah terima {{ $jenis }}</td>
                </tr>
            </table>
        </div>

        <!-- Content -->
        <div class="mb-8">
            <p class="mb-4">Bersama ini dilaksanakan serah terima aset tetap berupa:</p>
            <table class="w-full text-sm mb-6">
                <tr>
                    <td style="text-align: left; ">Jenis aset</td>
                    <td >: {{ $jenis }} </td>
                </tr>
                <tr>
                    <td style="text-align: left; ;">Merk</td>
                    <td>: {{ ucfirst($pfa->merk_barang) }}</td>
                </tr>
                <tr>
                    <td style="text-align: left; ">Spesifikasi</td>
                    <td>: {{ ucfirst($pfa->deskripsi_permintaan) }}</td>
                </tr>
                <tr>
                    <td style="text-align: left;">Peruntukan</td>
                    <td>: {{ ucfirst($pfa->alasan_permintaan) }} </td>
                </tr>
                <tr>
                    <td style="text-align: left;">Pengguna</td>
                    <td>: {{ ucfirst($pfa->user->username) }}</td>
                </tr>
                <tr>
                    <td style="text-align: left; ">Sifat</td>
                    <td>: {{ ucfirst($tipe) }}</td>
                </tr>
            </table>
            
            <!-- Footer Notes -->
            <div>
                <p>Hal-hal terkait aset:</p>
                <ol class="list-decimal pl-5">
                    <li>Aset tetap harap dipergunakan sesuai dengan peruntukan dan dirawat sebagaimana mestinya sampai dengan selesai usia pakai selesai untuk dapat diperbaharui kembali.</li>
                    <li>Kerusakan sebelum mencapai usia pakai selesai akan dilakukan perbaikan ataupun penggantian sesuai dengan rekomendasi ahli.</li>
                </ol>
            </div>
            <p class="mt-4">Demikian Berita Acara Serah Terima Aset tetap ditandatangani untuk dapat dipahami dan dipergunakan sebagai dokumentasi Aset Tetap.</p>
<br><br>
<br>
<br>
            <!-- Signature Section -->
            <div class="flex justify-between mt-12">
                <div class="text-center mx-6"> <!-- Adjusted margin -->
                    <p>{{ $datadirmanaset->userdetail->nama_lengkap }}</p>
                    <p>{{ $datadirmanaset->username }}</p>
                </div>
                <div class="text-center mx-6"> <!-- Adjusted margin -->
                    <p>{{ ucfirst($pfa->user->userdetail->nama_lengkap) }}</p>
                    <p>{{ ucfirst($pfa->user->username) }}</p>
                </div>
            </div>

        </div>
    </div>
</body>
</html>
