<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Permintaan Aktiva Tetap</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .form-header {
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .form-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .form-table, .form-table th, .form-table td {
            border: 1px solid black;
        }
        .form-table th, .form-table td {
            padding: 10px;
            text-align: left;
        }
        .form-table input, .form-table textarea, .form-table select {
            width: 100%;
            border: none;
            outline: none;
            background-color: transparent;
        }
        .form-section-title {
            background-color: #d1d6db;
            font-weight: bold;
            text-align: left;
            padding-left: 10px;
        }
        .checkbox {
            width: 16px;
            height: 16px;
            border: 1px solid black;
            display: inline-block;
        }
        @media print {
            @page {
                size: legal; /* Set the paper size to legal */
                margin: 1in; /* Set margins as needed */
            }
            /* Additional print styles */
            body {
                font-family: Arial, sans-serif;
            }
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
<body class="bg-white text-black">

    <!-- Header -->
    <div class="form-header">
        <div style="font-size: 14px;">YAYASAN KARYA BAKTI SURAKARTA</div>
        <div style="font-size: 14px;">DIREKTORAT MANAJEMEN ASET</div>
       
       
        <div>
            <span style="font-size: 20px; font-weight: bold;">SURAT PERMINTAAN AKTIVA TETAP</span>
        </div>

    <!-- Table Content -->
    <table class="form-table">
        <!-- Row 1: Header Information -->
        <tr>
            <th colspan="6" style="border: none;">UNIT KARYA/USAHA: <span>............................</span></th>
            <th colspan="2" style="border: none; text-align: left;">No: <span>{{$pfa->id_permintaan_fa}}</span></th>
        </tr>
        
        <!-- Row 2: Approval Section -->
        <tr>
            <th colspan="6" >PERSETUJUAN UNIT KERJA</th>
            <th colspan="1" style="border-left: none; text-align: left;">Tanggal: <span>{{ date('j F Y', strtotime($pfa->created_at)) }}</span></th>
        </tr>
        <tr style="height: 86px;"> <!-- Adjust the height as needed -->
            <td colspan="6">
                Unit Kerja Pemohon: <span>{{$pfa->institusi->nama_institusi}}</span><br>
                Obyek Permohonan: 
                <div class="flex items-center">
                    <div class="checkbox mr-2">
                        <input type="checkbox" {{ $pfa->status_permohonan == 'Pengadaan Baru' ? 'checked' : '' }}>
                    </div> Pengadaan Baru
                    <div class="checkbox ml-4 mr-2">
                        <input type="checkbox" {{ $pfa->status_permohonan == 'Perbaikan' ? 'checked' : '' }}>
                    </div> Perbaikan
                    <div class="checkbox ml-4 mr-2">
                        <input type="checkbox" {{ $pfa->status_permohonan == 'Pemindahan' ? 'checked' : '' }}>
                    </div> Pemindahan
                    <div class="checkbox ml-4 mr-2">
                        <input type="checkbox" {{ $pfa->status_permohonan == 'Penjualan' ? 'checked' : '' }}>
                    </div> Penjualan
                </div>
                Nama Barang: <span>{{ ucfirst($pfa->nama_barang)}}</span><br>
                Spesifikasi Teknis: <span>{{ ucfirst($pfa->deskripsi_permintaan)}}</span><br>
                Alasan Pengadaan: <span>{{ ucfirst($pfa->alasan_permintaan)}}</span>
            </td>
            
            <td colspan="2" class="text-center">
                Kaprodi/Manajer/KUK<br><br>
                <img src="{{ asset('ttd/dummy.png') }}" class="product-image" alt="Foto Barang Aset" style="width: 80px; max-width: 100%; position: relative; z-index: 10;">
                <span>............................</span>
            </td>
        </tr>
        <!-- Row 3: Confirmation -->
        <tr>
            <th colspan="6" style="border: none;">KONFIRMASI OFFICIAL UNIT KARYA/UNIT USAHA </th>
            <th colspan="2" style="border: none; text-align: left;">Tanggal: <span>{{ date('j F Y', strtotime($pfa->valid_fixaset_timestamp)) }}</span></th>
        </tr>
        <tr style="height: 86px;"> <!-- Adjust the height as needed -->
            <td colspan="6" style="text-align: center; vertical-align: middle;">
                <div style="display: inline-block; text-align: left;">
                    @if($pfa->status_permohonan != 'Pemindahan')
                    <div class="flex items-center" style="justify-content: left;">
                        <div class="checkbox mr-2">
                            <input type="checkbox" {{ $pfa->status_permohonan == 'Pengadaan Baru' ? 'checked' : '' }}>
                        </div> Pembelian Aset
                        <span>/</span>
                        <div class="checkbox mr-2">
                            <input type="checkbox" {{ $pfa->status_permohonan == 'Penjualan' ? 'checked' : '' }}>
                        </div> Penjualan Aset
                    </div>
                    Perkiraan Harga: Rp. <span>{{number_format($pfa->perkiraan_harga, 0, ',', '.')}}</span></span><br><br>
                    @endif
                    <div class="flex items-center" style="justify-content: left;">
                        <div class="checkbox mr-2">
                            <input type="checkbox" {{ $pfa->status_permohonan == 'Pemindahan' ? 'checked' : '' }}>
                        </div> Pemindahan Aset
                    </div>
                    Unit Asal Aset (yang akan dipindah): <span>{{ ucfirst($pfa->unit_asal ?? '') }}                    </span>
                </div>
            </td>
            
            <td colspan="2" class="text-center">
                Official Fix Aset<br><br>
                <img src="{{ asset('ttd/dummy.png') }}" class="product-image" alt="Foto Barang Aset" style="width: 80px; max-width: 100%; position: relative; z-index: 10;">
                <span>............................</span>
            </td>
        </tr>
        <!-- Row 4: Approval from Higher Authority -->
        <tr>
            <th colspan="6"style="border: none;">PERSETUJUAN KETUA YAYASAN/PIMPINAN UNIT KARYA/USAHA </th>
            <th colspan="2" style="border: none; text-align: left;">Tanggal: <span>{{ $pfa->valid_karyausaha_timestamp ? date('j F Y', strtotime($pfa->valid_karyausaha_timestamp)) : date('j F Y', strtotime($pfa->valid_ketuayayasan_timestamp)) }}
            </span></th>
        </tr>
        <tr style="height: 86px;"> <!-- Adjust the height as needed -->
            <td colspan="1" class="text-center">
                Ketua Yayasan<br><br>
                @if($pfa->valid_ketuayayasan === 'menunggu')
                <br><br><br>
                <span>............................</span>
                @else
                <img src="{{ asset('ttd/dummy.png') }}" class="product-image" alt="Foto Barang Aset" style="width: 80px; max-width: 100%; position: relative; z-index: 10;">
                <span>............................</span>
                @endif

            </td>
            <td colspan="5">
                <div class="flex items-center">
                    <div class="checkbox mr-2">
                        <input type="checkbox" {{ ($pfa->valid_ketuayayasan == 'setuju' || $pfa->valid_karyausaha == 'setuju') ? 'checked' : '' }}>
                    </div> Disetujui
                    <div class=" mr-2">
                    </div>
                    <div class="checkbox mr-2">
                        <input type="checkbox" {{ ($pfa->valid_ketuayayasan == 'tolak' || $pfa->valid_karyausaha == 'tolak') ? 'checked' : '' }}>
                    </div> Ditolak
                </div>
                @if($pfa->status == 'ditolak')
                Alasan: <span>{{$pfa->catatan ?? ''}}</span><br><br>
                @endif
                Tindak Lanjut: <span>{{$pfa->tindak_lanjut ?? ''}}</span>
            </td>
            <td colspan="2" class="text-center">
                Pimpinan Unit Karya/Usaha<br><br>
                <img src="{{ asset('ttd/dummy.png') }}" class="product-image" alt="Foto Barang Aset" style="width: 80px; max-width: 100%; position: relative; z-index: 10;">
                <span>............................</span>
            </td>
        </tr>
        <!-- Row 6: Completion of Asset Status -->
         <tr>
            <th colspan="5" style="border: none;">PENYELESAIAN STATUS ASET</th>
            <th colspan="2" style="border: none; text-align: right;">Tanggal: <span>{{ date('j F Y', strtotime($pfa->valid_dirmanageraset_timestamp)) }}
            </tr>
        <tr>
            <td colspan="1" class="text-center">
                Direktur Keuangan<br><br>
                @if($pfa->status_permohonan === 'pemindahan')
                <br><br><br>
                <span>............................</span>
                @else
                <img src="{{ asset('ttd/dummy.png') }}" class="product-image" alt="Foto Barang Aset" style="width: 80px; max-width: 100%; position: relative; z-index: 10;">
                <span>............................</span>
                @endif

            </td>
            <td colspan="5">
               @if($pfa->status_permohonan != 'pemindahan')
                <div class="flex items-center">
                    <div class="checkbox mr-2">
                        <input type="checkbox" checked>
                    </div> Pembelian Aset sudah selesai
                </div>
                Harga Perolehan: Rp. <span>{{number_format($pfa->perolehan_harga, 0, ',', '.')}}</span><br><br>
                @endif

                <div class="flex items-center">
                    <div class="checkbox mr-2">
                        <input type="checkbox" checked>
                    </div> Penyerahan Aset sudah dilakukan
                </div>
                Pengesahan Berita Acara Serah Terima, <br> No: <span>{{ str_pad($bast->id_bast, 2, '0', STR_PAD_LEFT) . '/' . $bast->BAST . '/' . $bast->bulan . '/' . $bast->tahun}}</span>
            </td>
            <td colspan="2" class="text-center">
                Direktur Manajemen Aset<br><br>
                <img src="{{ asset('ttd/dummy.png') }}" class="product-image" alt="Foto Barang Aset" style="width: 80px; max-width: 100%; position: relative; z-index: 10;">
                <span>............................</span>
            </td>
        </tr>
        <!-- Row 6: Asset Registration -->
          <tr>
            <th colspan="5" style="border: none;">PENDATAAN ASET</th>
            <th colspan="2" style="border: none; text-align: right;">Tanggal: <span>{{ date('j F Y', strtotime($pfa->valid_manageraset_timestamp)) }}
            </span></th>
        </tr>
        <tr style="height: 86px;"> <!-- Adjust the height as needed -->
            <td colspan="6">
                <div class="flex items-center">
                    <div class="checkbox mr-2">
                        <input type="checkbox" checked>
                    </div> Updating data Fixaset
                </div><br>
                <div class="flex items-center">
                    <div class="checkbox mr-2">
                        <input type="checkbox" checked>
                    </div> Pemberian Label Aset
                </div>
            </td>
            <td colspan="2" class="text-center" style="position: relative;">
                Manajer Aset<br><br>
                <img src="{{ asset('ttd/dummy.png') }}" class="product-image" alt="Foto Barang Aset" style="width: 80px; max-width: 100%; position: relative; z-index: 10;">
                <span>............................</span>
            </td>
            
            
            
        </tr>
    </table>

</body>
</html>
