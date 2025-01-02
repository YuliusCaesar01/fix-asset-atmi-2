@extends('layouts.layout_main')
@section('title', 'Tambah Aset Tetap')
@section('scriptheadtambahan')
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}">
@endsection
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div class="container-fluid">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-6">
                            <h1 class="m-0">Tambah Data Aset</h1>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->
            <div class="content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header d-flex p-0">
                            <h3 class="card-title p-3">Aset Tetap</h3>
                            <ul class="nav nav-pills ml-auto p-2">
                                <li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">Tambah
                                        Aset</a></li>
                                <li class="nav-item"><a class="nav-link" href="#tab_2" data-toggle="tab">Tambah Aset
                                        Masal</a></li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            @if (session('error'))
                                <div class="alert alert-danger" role="alert">
                                    {{ session('error') }}
                                </div>
                            @endif
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_1">
                                    <form action="{{ route('manageaset.store') }}" enctype="multipart/form-data"
                                        method="post">
                                        @csrf

                                            @if(session('success'))
                                            <div class="alert alert-success">{{ session('success') }}</div>
                                        @endif

                                        @if($errors->any())
                                            <div class="alert alert-danger">
                                                <ul>
                                                    @foreach($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                        <input type="hidden" id="id_fa">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label>Instansi</label>
                                                    <select id="instansi" name="instansi" class="form-control" style="width: 100%;" required>
                                                        <option value="">- Pilih Instansi -</option>
                                                        <option value="1">Yayasan</option>
                                                        <option value="2">SMK Mikael</option>
                                                        <option value="3">Politeknik</option>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label>Lokasi</label>
                                                    <select id="lokasi" name="id_lokasi" class="form-control select2" style="width: 100%;" required>
                                                        <option value="">- Pilih Lokasi -</option>
                                                        @foreach($lokasi as $item)
                                                            <option value="{{ $item->id_lokasi }}">{{ $item->nama_lokasi_yayasan }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label>Ruang</label>
                                                    <select id="ruang" name="id_ruang" class="form-control select2" style="width: 100%;" required>
                                                        <option value="">- Pilih Ruang -</option>
                                                    </select>
                                                </div>
                                            </div>
                                        <div class="row">
                                            <div class="row">
                                                <div class="col-4">
                                                    <div class="form-group">
                                                        <label>Tipe</label>
                                                        <select id="tipe" name="id_tipe" class="form-control select2" style="width: 100%;" required>
                                                            <option value="">- Pilih Tipe -</option>
                                                            @foreach($tipe as $item)
                                                                <option value="{{ $item->id_tipe }}">{{ $item->nama_tipe_yayasan }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="form-group">
                                                        <label>Kelompok</label>
                                                        <select id="kelompok" name="id_kelompok" class="form-control select2" style="width: 100%;" required>
                                                            <option value="">- Pilih Kelompok -</option>
                                                            @foreach($kelompok as $item)
                                                                <option value="{{ $item->id_kelompok }}">{{ $item->nama_kelompok_yayasan }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label>Jenis</label>
                                                    <select id="jenis" name="id_jenis" class="form-control select2" style="width: 100%;" data-placeholder="- Pilih Jenis -" required>
                                                        <option value="">- Pilih Jenis -</option>
                                                        @foreach($jenis as $item)
                                                            <option value="{{ $item->id_jenis }}">{{ $item->nama_jenis_yayasan }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="nama_barang" class="control-label">Nama Barang</label>
                                                    <input type="text" class="form-control" name="nama_barang"
                                                        id="nama_barang" required>
                                                    <div class="alert alert-danger mt-2 d-none" role="alert"
                                                        id="alert-nama">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label class="control-label">Tahun Diterima</label>
                                                    <input type="text" class="form-control" name="tahun_diterima"
                                                        data-inputmask='"mask": "9999"' data-mask>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="no_permaintaan" class="control-label">No Surat
                                                        Permintaan
                                                        (SPA)</label>
                                                    <input type="text" class="form-control" name="no_permaintaan"
                                                        id="no_permaintaan" required>
                                                    <div class="alert alert-danger mt-2 d-none" role="alert"
                                                        id="alert-no">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="formdes_barang" class="control-label">Deskripsi Detail
                                                Barang</label>
                                            <textarea class="form-control" rows="3" name="des_barang" id="formdes_barang"></textarea>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Status Transaksi Barang</label>
                                                    <select id="status_transaksi" class="form-control" name="status_transaksi" style="width: 100%;" required>
                                                        <option value="Pengadaan Baru">Pengadaan Baru</option>
                                                        <option value="Penjualan">Penjualan</option>
                                                        <option value="Pemindahan">Pemindahan</option>
                                                        <option value="Perbaikan">Perbaikan</option>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6" id="unit-asal-group" style="display: none;">
                                                <div class="form-group">
                                                    <label for="unit_asal">Unit Asal</label>
                                                    <input type="text" class="form-control" name="unit_asal" id="unit_asal" placeholder="Masukkan Unit Asal">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="jumlah_unit" class="col-sm-2 col-form-label">
                                                    Jumlah Unit
                                                </label>
                                                <div class="col-sm-10">
                                                    <input 
                                                        type="number" 
                                                        class="form-control jumlah_unit" 
                                                        id="jumlah_unit" 
                                                        name="jumlah_unit" 
                                                        required 
                                                        placeholder="Masukkan jumlah unit ..." 
                                                        min="1"
                                                    >
                                                    <div class="invalid-feedback">Jumlah unit wajib diisi dan harus berupa angka.</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Status Kondisi Barang</label>
                                                    <select id="status_barang" class="form-control" name="status_barang"
                                                        style="width: 100%;" required>
                                                        <option value="baik(100%)">baik(100%)</option>
                                                        <option value="cukup(50%)">cukup(50%)</option>
                                                        <option value="rusak">rusak</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="InputFile">File Foto Barang</label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="customFile"
                                                    name="foto_barang" required>
                                                <label class="custom-file-label" for="customFile">Choose file</label>
                                            </div>
                                        </div>
                                        <hr>
                                        <button type="submit" class="btn btn-primary btn-block">SIMPAN</button>
                                    </form>
                                </div>
                               
                            </div>
                             <!-- /.tab-pane -->
                             <div class="tab-pane" id="tab_2">
                                <p>Download Template :
                                    <a class="text-info"
                                        href="{{ asset('upload_masal_fixed_asset.csv') }}">upload_masal_fixed_asset.csv</a>
                                </p>
                                <form action="{{ route('manageaset.uploadmasal') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label for="InputFile">File Excel</label>
                                        <div class="custom-file">
                                            <input type="file" name="file" accept=".xls, .xlsx"
                                                class="custom-file-input form-control-file" id="customFile" required>
                                            <label class="custom-file-label" for="customFile">Choose file</label>
                                        </div>
                                    </div>
                                    <br>
                                    <button type="submit" class="btn btn-success btn-block">Import User Data</button>
                                </form>
                            </div>
                            <!-- /.tab-pane -->
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                    </div>
                    <!-- ./card -->
                </div>
            </div>
            <!-- /.content -->
        </div>
    </div>
@endsection
@section('scripttambahan')
<script>
$(document).ready(function() {
    $('#instansi').change(function() {
        var instansiId = $(this).val(); // Ambil nilai instansi yang dipilih
        var ruangOptions = ''; // Variabel untuk menyimpan opsi ruang

        if (instansiId == 1) { // Jika Yayasan dipilih
            ruangOptions += '@foreach($ruang as $rg)<option value="{{ $rg->id_ruang }}">{{ $rg->nama_ruang_yayasan }}</option>@endforeach';
        } else if (instansiId == 2) { // Jika SMK Mikael dipilih
            ruangOptions += '@foreach($ruang as $rg)<option value="{{ $rg->id_ruang }}">{{ $rg->nama_ruang_mikael }}</option>@endforeach';
        } else if (instansiId == 3) { // Jika Politeknik dipilih
            ruangOptions += '@foreach($ruang as $rg)<option value="{{ $rg->id_ruang }}">{{ $rg->nama_ruang_politeknik }}</option>@endforeach';
        }

        // Kosongkan dropdown ruang dan tambahkan opsi baru
        $('#ruang').html(ruangOptions);
    });
});
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const statusTransaksi = document.getElementById('status_transaksi');
        const unitAsalGroup = document.getElementById('unit-asal-group');

        statusTransaksi.addEventListener('change', function () {
            if (this.value === 'Pemindahan') {
                unitAsalGroup.style.display = 'block'; // Tampilkan input Unit Asal
            } else {
                unitAsalGroup.style.display = 'none'; // Sembunyikan input Unit Asal
                document.getElementById('unit_asal').value = ''; // Reset nilai input
            }
        });
    });
</script>

    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/inputmask/jquery.inputmask.min.js') }}"></script>
    <!-- Summernote -->
    <script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
    <!-- bs-custom-file-input -->
    <script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    
    @if (session('notification'))
        <script>
            var isi = @json(session('notification'));
            Swal.fire({
                icon: 'success',
                title: 'Hei...',
                text: isi,
                showConfirmButton: false,
                timer: 2500
            });
        </script>
    @endif

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


@endsection
