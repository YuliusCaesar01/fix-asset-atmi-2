@extends('layouts.layout_main')
@section('title', 'Edit Aset Tetap')
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
                            <h1 class="m-0">Edit Data Aset</h1>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->
            <div class="content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Aset Tetap (Fixed Asset)</h3>
                            <span class="badge bg-info float-right fs-7">{{ $fa->kode_fa }}</span>
                        </div>
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger" role="alert">
                                    {!! implode('', $errors->all('<li>:message</li>')) !!}
                                </div>
                            @endif
                            <form action="{{ route('manageaset.update', $fa->id_fa) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <input type="hidden" id="id_fa">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Lokasi</label>
                                            <select id="lokasi" name="id_lokasi" class="form-control select2" style="width: 100%;" required>
                                                <option value="">- Pilih Lokasi -</option>
                                                @foreach($lokasi as $item)
                                                    <option value="{{ $item->id_lokasi }}" {{ $fa->id_lokasi == $item->id_lokasi ? 'selected' : '' }}>
                                                        {{ $item->nama_lokasi_yayasan }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Institusi</label>
                                            <select id="instansi" name="instansi" class="form-control" style="width: 100%;" required>
                                                <option value="">- Pilih Insitusi -</option>
                                                @foreach($institusi as $item)
                                                    <option value="{{ $item->id_institusi }}" {{ $fa->id_institusi == $item->id_institusi ? 'selected' : '' }}>
                                                        {{ $item->nama_institusi }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    
                            
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Ruang</label>
                                            <select id="ruang" name="id_ruang" class="form-control select2" style="width: 100%;" required>
                                                <option value="">- Pilih Ruang -</option>
                                                @foreach($ruang as $item)
                                                    <option value="{{ $item->id_ruang }}" data-institusi-id="{{ $item->id_institusi }}" {{ $fa->id_ruang == $item->id_ruang ? 'selected' : '' }}>
                                                        {{ $item->nama_ruang }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Kelompok</label>
                                            <select id="kelompok" name="id_kelompok" class="form-control select2" style="width: 100%;" required>
                                                <option value="">- Pilih Kelompok -</option>
                                                @foreach ($kelompok as $ke)
                                                <option value="{{ $ke->id_kelompok }}" {{ $fa->id_kelompok == $ke->id_kelompok ? 'selected' : '' }}>
                                                    {{ $ke->nama_kelompok_yayasan }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <!-- Jenis dropdown - Add data-kelompok-id attribute -->
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Jenis</label>
                                            <select id="jenis" name="id_jenis" class="form-control select2" style="width: 100%;" required>
                                                <option value="">- Pilih Jenis -</option>
                                                @foreach ($jenis as $je)
                                                <option value="{{ $je->id_jenis }}" data-kelompok-id="{{ $je->id_kelompok }}" {{ $fa->id_jenis == $je->id_jenis ? 'selected' : '' }}>
                                                    {{ $je->nama_jenis_yayasan }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <!-- Tipe dropdown - Add data-jenis-id attribute -->
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Tipe</label>
                                            <select id="tipe" name="id_tipe" class="form-control select2" style="width: 100%;" required>
                                                <option value="">- Pilih Tipe -</option>
                                                @foreach ($tipe as $ti)
                                                <option value="{{ $ti->id_tipe }}" data-jenis-id="{{ $ti->id_jenis }}" {{ $fa->id_tipe == $ti->id_tipe ? 'selected' : '' }}>
                                                    {{ $ti->nama_tipe_yayasan }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="nama_barang">Nama Barang</label>
                                            <input type="text" class="form-control" name="nama_barang" value="{{ $fa->nama_barang }}" id="nama_barang" required>
                                            <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-nama"></div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Tahun Diterima</label>
                                            <input type="text" class="form-control" name="tahun_diterima" value="{{ $fa->tahun_diterima }}" data-inputmask='"mask": "9999"' data-mask>
                                        </div>
                                    </div>
                                </div>
                            
                                <div class="form-group">
                                    <label for="formdes_barang">Deskripsi Detail Barang</label>
                                    <textarea class="form-control" rows="3" name="des_barang" id="formdes_barang">{!! $fa->des_barang !!}</textarea>
                                </div>
                            
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Status Transaksi Barang</label>
                                            <select id="status_transaksi" class="form-control" name="status_transaksi" required>
                                                <option value="Pengadaan Baru" {{ 'Pengadaan Baru' == $fa->status_transaksi ? 'selected' : '' }}>Pengadaan Baru</option>
                                                <option value="Penjualan" {{ 'Penjualan' == $fa->status_transaksi ? 'selected' : '' }}>Penjualan</option>
                                                <option value="Pemindahan" {{ 'Pemindahan' == $fa->status_transaksi ? 'selected' : '' }}>Pemindahan</option>
                                            </select>
                                        </div>
                                    </div>
                            
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Status Kondisi Barang</label>
                                            <select id="status_barang" class="form-control" name="status_barang" required>
                                                <option value="baik(100%)" {{ 'baik (100%)' == $fa->status_barang ? 'selected' : '' }}>Baik (100%)</option>
                                                <option value="cukup(50%)" {{ 'cukup (50%)' == $fa->status_barang ? 'selected' : '' }}>Cukup (50%)</option>
                                                <option value="rusak" {{ 'rusak' == $fa->status_barang ? 'selected' : '' }}>Rusak</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            
                                <!-- New input field for jumlah_unit -->
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="jumlah_unit">Jumlah Unit</label>
                                            <input type="number" class="form-control" name="jumlah_unit" value="{{ $fa->jumlah_unit }}" id="jumlah_unit" required min="1">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="unitDetails" class="col-sm-2 col-form-label">Unit Details</label>
                                    <div class="card-body">
                                        <div id="unitDetailsContainer">
                                            @foreach ($fa->unitDetails as $index => $unit)
                                                <div class="unit-detail">
                                                    <label>Merk</label>
                                                    <input type="text" name="merk[{{ $index + 1 }}]" value="{{ $unit->merk }}" class="form-control">
                                
                                                    <label>Seri</label>
                                                    <input type="text" name="seri[{{ $index + 1 }}]" value="{{ $unit->seri }}" class="form-control">
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                
                            
                                <div class="row">
                                    <div class="col-3">
                                        <img src="{{ $fa->foto_barang ? asset('fotofixaset/' . basename($fa->foto_barang)) : asset('boxs.png') }}" class="product-image" alt="Foto Barang Aset">
                                    </div>
                                    <div class="col-9">
                                        <div class="form-group">
                                            <label for="InputFile">File Foto Barang</label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="customFile" name="foto_barang">
                                                <label class="custom-file-label" for="customFile">Choose file</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            
                                <hr>
                                <button type="submit" class="btn btn-primary btn-block">SIMPAN</button>
                            </form>
                            
                        </div>
                    </div>
                    
                </div>
            </div>
            <!-- /.content -->
        </div>
    </div>
@endsection
@section('scripttambahan')
    <!-- InputMask -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/inputmask/jquery.inputmask.min.js') }}"></script>
    <!-- Summernote -->
    <script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
    <!-- bs-custom-file-input -->
    <script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Store all ruang and jenis options when the page loads
            var allRuangOptions = $('#ruang option').clone();
            var allJenisOptions = $('#jenis option').clone();
    
            function filterRuang() {
                var selectedInstitusiId = $('#instansi').val();
    
                $('#ruang')
                    .empty()
                    .append('<option value="">- Pilih Ruang -</option>')
                    .prop('disabled', !selectedInstitusiId);
    
                if (selectedInstitusiId) {
                    allRuangOptions.each(function() {
                        var ruangOption = $(this);
                        if (ruangOption.data('institusi-id') == selectedInstitusiId) {
                            $('#ruang').append(ruangOption.clone());
                        }
                    });
    
                    // Preserve the selected value
                    $('#ruang').val('{{ $fa->id_ruang }}');
                }
            }
    
            function filterJenis() {
                var selectedKelompokId = $('#kelompok').val();
    
                $('#jenis')
                    .empty()
                    .append('<option value="">- Pilih Jenis -</option>')
                    .prop('disabled', !selectedKelompokId);
    
                if (selectedKelompokId) {
                    allJenisOptions.each(function() {
                        var jenisOption = $(this);
                        if (jenisOption.data('kelompok-id') == selectedKelompokId) {
                            $('#jenis').append(jenisOption.clone());
                        }
                    });
    
                    // Preserve the selected value
                    $('#jenis').val('{{ $fa->id_jenis }}');
                }
            }
    
            // Trigger filtering functions when selection changes
            $('#instansi').change(filterRuang);
            $('#kelompok').change(filterJenis);
    
            // Automatically trigger filtering on page load (for edit mode)
            filterRuang();
            filterJenis();
        });
    </script>
    <script>
        $(document).ready(function() {
            // Store all tipe options when the page loads
            var allTipeOptions = $('#tipe option').clone();
    
            function filterTipe() {
                var selectedJenisId = $('#jenis').val();
    
                $('#tipe')
                    .empty()
                    .append('<option value="">- Pilih Tipe -</option>')
                    .prop('disabled', !selectedJenisId);
    
                if (selectedJenisId) {
                    allTipeOptions.each(function() {
                        var tipeOption = $(this);
                        if (tipeOption.data('jenis-id') == selectedJenisId) {
                            $('#tipe').append(tipeOption.clone());
                        }
                    });
    
                    // Preserve the selected value
                    $('#tipe').val('{{ $fa->id_tipe }}');
                }
            }
    
            // Trigger filtering function when selection changes
            $('#jenis').change(filterTipe);
    
            // Automatically trigger filtering on page load (for edit mode)
            filterTipe();
        });
    </script>
   
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
@endsection
