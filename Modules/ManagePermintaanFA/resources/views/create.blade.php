@extends('layouts.layout_main')
@section('title', 'Tambah Permintaan Aktiva Tetap (SPA)')
@section('scriptheadtambahan')
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
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
                            <h1 class="m-0">Tambah Permintaan Aktiva Tetap (SPA)</h1>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->
            <div class="content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Form Permintaan Aktiva Tetap</h3>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            @if (session('error'))
                                <div class="alert alert-danger" role="alert">
                                    {{ session('error') }}
                                </div>
                            @endif
                            <form action="{{ route('managepermintaanfa.store') }}" class="form-horizontal" method="POST" enctype="multipart/form-data" novalidate>
                                @csrf
                                <input type="hidden" id="id_permintaan_fa">
                                <input type="hidden" value="{{ Auth::user()->id_divisi }}" name="id_divisi">
                                <!-- Hidden field for unit pemohon -->
                                <input type="hidden" name="unit_pemohon" value="{{ Auth::user()->divisi->nama_divisi }}">
                                <table class="table table-sm table-bordered">
                                    <thead>
                                        <tr class="text-center">
                                            <th>#</th>
                                            <th>Persetujuan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td rowspan="2">1.</td>
                                            <td rowspan="2">
                                                <h5><b>Unit Pemohon: </b> <span id="instansi" >{{ Auth::user()->divisi->nama_divisi }}</span></h5>
                                                <hr>
                                                <label for="des_minta" class="col-sm-4 col-form-label">
                                                    Mengajukan Permohonan :
                                                </label>
                                                <div class="form-group row">
                                                    <label for="nama_barang" class="col-sm-2 col-form-label">
                                                        Nama Barang
                                                        <small>Masukkan nama barang</small>
                                                    </label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" id="nama_barang" name="nama_barang" required placeholder="Nama barang ...">
                                                        <div class="invalid-feedback">Nama barang wajib diisi.</div>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group row">
                                                    <label for="merk_barang" class="col-sm-2 col-form-label">
                                                        Merek Barang
                                                        <small>Masukkan merek barang</small>
                                                    </label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" id="merk_barang" name="merk_barang" required placeholder="Merek barang ...">
                                                        <div class="invalid-feedback">Merek barang wajib diisi.</div>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group row">
                                                    <label for="des_minta" class="col-sm-2 col-form-label">
                                                        Spesifikasi lengkap
                                                    </label>
                                                    <div class="col-sm-10">
                                                        <textarea class="form-control des_minta" rows="3" name="deskripsi_permintaan" required placeholder="Deskripsi permohonan ..."></textarea>
                                                        <div class="invalid-feedback">Deskripsi permintaan wajib diisi.</div>
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
                                                
                                                <div class="form-group row">
                                                    <label for="stts_trans" class="col-sm-2 col-form-label">
                                                        Status Transaksi Barang
                                                    </label>
                                                    <div class="col-sm-10">
                                                        <select id="stts_trans" class="form-control" name="status_transaksi" style="width: 100%;" required>
                                                            <option value="">- Pilih Status -</option>
                                                            <option value="Pengadaan Baru">Pengadaan Baru</option>
                                                            <option value="Penjualan">Penjualan</option>
                                                            <option value="Pemindahan">Pemindahan</option>
                                                            <option value="Perbaikan">Perbaikan</option>
                                                        </select>
                                                        <div class="invalid-feedback">Status transaksi wajib dipilih.</div>
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group row" id="unit-asal-group" style="display: none;">
                                                    <label for="unit_asal" class="col-sm-2 col-form-label">
                                                        Unit Asal
                                                    </label>
                                                    <div class="col-sm-10">
                                                        <input 
                                                            type="text" 
                                                            class="form-control" 
                                                            id="unit_asal" 
                                                            name="unit_asal" 
                                                            placeholder="Masukkan unit asal ..." 
                                                        >
                                                        <div class="invalid-feedback">Unit asal wajib diisi jika status Pemindahan.</div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label for="unit_tujuan" class="col-sm-2 col-form-label">
                                                        Unit Tujuan
                                                    </label>
                                                    <div class="col-sm-10">
                                                        <input type="text" id="unit_tujuan" name="unit_tujuan" class="form-control" value="{{ $institusi->first()->nama_institusi ?? 'N/A' }}" readonly>
                                                    </div>
                                                    
                                                </div>
                                                
                                                <div class="form-group row">
                                                    <label for="alasan_permintaan" class="col-sm-2 col-form-label">
                                                        Dengan alasan
                                                    </label>
                                                    <div class="col-sm-10">
                                                        <textarea class="form-control des_minta" rows="3" name="alasan_permintaan" required placeholder="Alasan permohonan ..."></textarea>
                                                        <div class="invalid-feedback">Alasan permintaan wajib diisi.</div>
                                                    </div>
                                                </div>
                                                <h5>Kategori Barang</h5>
                                                <div class="row">
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label>Lokasi</label>
                                                            <select id="lokasi" name="id_lokasi" class="form-control select2" style="width: 100%;" required>
                                                                <option value="">- Pilih Lokasi -</option>
                                                                @foreach ($lokasi as $lk)
                                                                    <option value="{{ $lk->id_lokasi }}">{{ $lk->nama_lokasi_yayasan }}</option>
                                                                @endforeach
                                                               
                                                            </select>
                                                            <div class="invalid-feedback">Lokasi wajib dipilih.</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label>Institusi</label>
                                                            <input type="text" class="form-control" value="{{ $institusi->first()->nama_institusi ?? 'N/A' }}" readonly>
                                                            <div class="invalid-feedback">Lokasi wajib dipilih.</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label>Ruang</label>
                                                            <select id="ruang" name="id_ruang" class="form-control select2" style="width: 100%;" required>
                                                                @foreach($ruang as $item)
                                                                <option value="{{ $item->id_ruang }}" data-institusi-id="{{ $item->institusi->id_institusi }}">
                                                                    {{ $item->nama_ruang }}
                                                                </option>
                                                        @endforeach
                                                            </select>
                                                            <div class="invalid-feedback">Ruang wajib dipilih.</div>
                                                        </div>
                                                </div>
                                                
                                                <div class="row">
                                                   
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label>Kelompok</label>
                                                            <select id="kelompok" name="id_kelompok" class="form-control select2" style="width: 100%;" required>
                                                                <option value="">- Pilih Kelompok -</option>
                                                                @foreach($kelompok as $item)
                                                                <option value="{{ $item->id_kelompok }}">{{ $item->nama_kelompok_yayasan }}</option>
                                                                @endforeach
                                                            </select>
                                                            <div class="invalid-feedback">Kelompok wajib dipilih.</div>
                                                        </div>
                                                    </div>
                                                  
                                                    <div class="col-4">
                                                      
                                                        <div class="form-group">
                                                            <label>Jenis</label>
                                                            <select id="jenis" name="id_jenis" class="form-control select2" style="width: 100%;" data-placeholder="- Pilih Jenis -" required>
                                                                <option value="">- Pilih Jenis -</option>
                                                                @foreach($jenis as $item)
                                                                    <option value="{{ $item->id_jenis }}" data-kelompok-id="{{ $item->id_kelompok }}">
                                                                        {{ $item->nama_jenis_yayasan }}
                                                                    </option>
                                                                @endforeach
                                                             </select>
                                                            <div class="invalid-feedback">Jenis wajib dipilih.</div>
                                                        </div>
                                                    </div>

                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label>Tipe</label>
                                                            <select id="tipe" name="id_tipe" class="form-control select2" style="width: 100%;" required>
                                                                <option value="">- Pilih Tipe -</option>
                                                                @foreach($tipe as $item)
                                                                <option value="{{ $item->id_tipe }}"data-jenis-id="{{ $item->id_jenis }}">
                                                                    {{ $item->nama_tipe_yayasan }}
                                                                </option>
                                                            @endforeach
                                                            </select>
                                                            <div class="invalid-feedback">Tipe wajib dipilih.</div>
                                                        </div>
                                                    </div>
                                                    
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label for="pdf_file">Upload PDF (Opsional)</label>
                                                            <input type="file" class="form-control-file" id="pdf_file" name="file_pdf" accept="application/pdf">
                                                            <small class="text-muted">(*Opsional upload pdf)</small>
                                                            <div id="file-upload-feedback" class="mt-2"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="align-middle text-center">
                                              
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fas fa-share"></i> AjukanFixAset
                                                </button>
                                              
                                            </td>
                                        
                                            
                                        </tr>
                                       
                                    </tbody>
                                </table>
                            </form>
                        </div><!-- /.card-body -->
                    </div>
                    <!-- ./card -->
                </div>
            </div>
            <!-- /.content -->
{{-- @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
            </div>
@endif --}}
        </div>
    </div>

  

@endsection
@section('scripttambahan')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- InputMask -->
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/inputmask/jquery.inputmask.min.js') }}"></script>
    <!-- Summernote -->
    <script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
    <!-- bs-custom-file-input -->
    <script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(document).ready(function() {
    // Store all ruang options when the page loads
    var allRuangOptions = $('#ruang option').clone();

    $('#unit_tujuan').change(function() {
        var selectedInstitusiId = $(this).val(); // Get selected institusi ID
        
        // Clear and disable ruang dropdown initially
        $('#ruang')
            .empty()
            .append('<option value="">- Pilih Ruang -</option>')
            .prop('disabled', !selectedInstitusiId);
        
        if (selectedInstitusiId) {
            // Append only the ruang options that match the selected institusi ID
            allRuangOptions.each(function() {
                var ruangOption = $(this);
                if (ruangOption.attr('data-institusi-id') == selectedInstitusiId) {
                    $('#ruang').append(ruangOption.clone());
                }
            });
        }
    });
});

        </script>
        <script>
            $(document).ready(function() {
                // Store all ruang options in a variable when page loads
                var allJenisOptions = $('#jenis option').clone();
                
                $('#kelompok').change(function() {
                    var selectedKelompokId = $(this).val();
                    
                    // Clear and disable ruang dropdown
                    $('#jenis')
                        .empty()
                        .append('<option value="">- Pilih Jenis -</option>')
                        .prop('disabled', !selectedKelompokId);
                        
                    if (selectedKelompokId) {
                        // Filter ruang options based on selected institusi
                        allJenisOptions.each(function() {
                            var jenisOption = $(this);
                            if (jenisOption.data('kelompok-id') == selectedKelompokId) {
                                $('#jenis').append(jenisOption.clone());
                            }
                        });
                    }
                });
            });
            </script>
            <script>
                $(document).ready(function() {
                    // Store all ruang options in a variable when page loads
                    var allTipeOptions = $('#tipe option').clone();
                    
                    $('#jenis').change(function() {
                        var selectedJenisId = $(this).val();
                        
                        // Clear and disable ruang dropdown
                        $('#tipe')
                            .empty()
                            .append('<option value="">- Pilih Tipe -</option>')
                            .prop('disabled', !selectedJenisId);
                            
                        if (selectedJenisId) {
                            // Filter ruang options based on selected institusi
                            allTipeOptions.each(function() {
                                var TipeOption = $(this);
                                if (TipeOption.data('jenis-id') == selectedJenisId) {
                                    $('#tipe').append(TipeOption.clone());
                                }
                            });
                        }
                    });
                });
                </script>
    <script>
        // Ambil elemen select dan div input Unit Asal
        const statusTransaksi = document.getElementById('stts_trans');
        const unitAsalGroup = document.getElementById('unit-asal-group');
    
        // Tambahkan event listener pada select
        statusTransaksi.addEventListener('change', function () {
            // Periksa nilai yang dipilih
            if (this.value === 'Pemindahan') {
                // Tampilkan input Unit Asal
                unitAsalGroup.style.display = 'flex';
            } else {
                // Sembunyikan input Unit Asal
                unitAsalGroup.style.display = 'none';
            }
        });
    </script>
   
        
   
@endsection
