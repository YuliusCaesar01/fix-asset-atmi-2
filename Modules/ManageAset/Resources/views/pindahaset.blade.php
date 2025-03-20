@extends('layouts.layout_main')
@section('title', 'Pemindahan Aset')
@section('content')
<style>
    .gap-2 {
        gap: 0.5rem;
    }
    
    #qrcode {
        display: block;
        margin: 0 auto;
    }
    
    @media (max-width: 768px) {
        .col-md-6 {
            margin-bottom: 1rem;
        }
    }
    </style>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Pemindahan Aset</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('manageaset.index') }}">Aset Tetap</a></li>
                            <li class="breadcrumb-item active">Pemindahan Aset</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="card card-solid">
                <div class="card-body">
                    <div class="row">
                        <!-- Left Column with Item Details -->
                        <div class="col-12 col-sm-6">
                            <h3 class="d-inline-block">
                                <b>Fix Asset {{ ucfirst($fa->nama_barang) }}</b>
                            </h3>
                            <div class="col-12">
                                <!-- Asset Image -->
                                <img src="{{ $fa->foto_barang ? asset('fotofixaset/' . basename($fa->foto_barang)) : asset('boxs.png') }}" class="product-image" alt="Foto Barang Aset">
                                <p class="float-right">Dibuat Oleh: <b>{{ ucfirst($fa->user->username) }}</b></p>
                            </div>
                        </div>
        
                        <!-- Right Column with Asset Information -->
                        
                        <div class="col-12 col-sm-6">
                            <form action="{{ route('manageaset.updatepindahaset', $fa->id_fa) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <input type="hidden" id="id_fa">
                            <h4 class="my-3 d-flex align-items-center justify-content-between">
                                <b>KODE: <span class="badge bg-info fs-6">{{ $fa->kode_fa }}</span></b>
                            </h4>                            
                            <hr>
                            <dl class="row mb-0">
                                <dt class="col-sm-12 mb-2">Lokasi</dt>
                                <dd class="col-sm-12 mb-0">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="border rounded px-2 py-1 text-center" style="width: 40%;">
                                            {{$fa->lokasi->nama_lokasi_yayasan }}
                                        </div>
                                        <div class="text-center" style="width: 20%;">
                                            <i class="fas fa-arrow-right"></i>
                                        </div>
                                        <select id="lokasi" name="id_lokasi" class="form-select form-select-sm" style="width: 40%;">
                                            @foreach($lokasi as $item)
                                            <option value="{{ $item->id_lokasi }}" {{ $fa->id_lokasi == $item->id_lokasi ? 'selected' : '' }}>
                                                {{ $item->nama_lokasi_yayasan }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </dd>
                                <dt class="col-sm-12 mb-2">Institusi</dt>
                                <dd class="col-sm-12 mb-0">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="border rounded px-2 py-1 text-center" style="width: 40%;">
                                            {{$fa->institusi->nama_institusi }}
                                        </div>
                                        <div class="text-center" style="width: 20%;">
                                            <i class="fas fa-arrow-right"></i>
                                        </div>
                                        <select id="instansi" name="instansi" class="form-select form-select-sm"  style="width: 40%;">
                                            @foreach($institusi as $item)
                                            <option value="{{ $item->id_institusi }}" {{ $fa->id_institusi == $item->id_institusi ? 'selected' : '' }}>
                                                {{ $item->nama_institusi }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </dd>
                                <dt class="col-sm-12 mb-2">Ruang</dt>
                                <dd class="col-sm-12 mb-0">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="border rounded px-2 py-1 text-center" style="width: 40%;">
                                            {{$fa->ruang->nama_ruang }}
                                        </div>
                                        <div class="text-center" style="width: 20%;">
                                            <i class="fas fa-arrow-right"></i>
                                        </div>
                                        <select id="ruang" name="id_ruang" class="form-select form-select-sm" name="new_lokasi_id" style="width: 40%;">
                                            @foreach($ruang as $item)
                                            <option value="{{ $item->id_ruang }}" data-institusi-id="{{ $item->id_institusi }}" {{ $fa->id_ruang == $item->id_ruang ? 'selected' : '' }}>
                                                {{ $item->nama_ruang }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </dd>
                                <dt class="col-sm-12 mb-2">Jumlah</dt>
                                <dd class="col-sm-12 mb-0">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="border rounded px-2 py-1 text-center" style="width: 40%;">
                                            {{$fa->jumlah_unit }}
                                        </div>
                                        <div class="text-center" style="width: 20%;">
                                            <i class="fas fa-arrow-right"></i>
                                        </div>
                                        <input 
                                            type="number" 
                                            id="jumlah_unit" 
                                            name="jumlah_unit" 
                                            class="form-control form-control-sm" 
                                            style="width: 40%;" 
                                            value="{{ $fa->jumlah_unit }}"
                                            min="0"
                                            max="{{ $fa->jumlah_unit }}"
                                        >
                                    </div>
                                </dd>
                            </dl>
                            
                            <!-- Update Button -->
                            <div class="mt-4 text-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i> Pindah Aset
                                </button>
                            </div>
                        </form>
                        </div>
                    
        
                    <!-- Tabs for Description and History -->
                    <div class="row mt-4">
                        <nav class="w-100">
                            <div class="nav nav-tabs" id="product-tab" role="tablist">
                                <a class="nav-item nav-link active" id="product-desc-tab" data-toggle="tab" href="#product-desc" role="tab" aria-controls="product-desc" aria-selected="true">Description</a>
                                <a class="nav-item nav-link" id="product-history-tab" data-toggle="tab" href="#product-history" role="tab" aria-controls="product-history" aria-selected="false">History Ajuan</a>
                            </div>
                        </nav>
                        <div class="tab-content p-3" id="nav-tabContent">
                            <!-- Description Tab -->
                            <div class="tab-pane fade show active" id="product-desc" role="tabpanel" aria-labelledby="product-desc-tab">
                                <p class="lead">Deskripsi:</p>
                                <p>{!! $fa->des_barang !!}</p>
                            </div>
                            
                            <!-- History Tab -->
                            <div class="tab-pane fade" id="product-history" role="tabpanel" aria-labelledby="product-history-tab">
                                <dl class="row">
                                    <dt class="col-sm-4">STATUS:</dt>
                                    <dd class="col-sm-8">{{ $fa->status_transaksi }}</dd>
                                    
                                    @if($fa->no_permintaan)
                                        <dt class="col-sm-4">Pengajuan ID</dt>
                                        <dd class="col-sm-4">{{ $fa->no_permintaan }}</dd>
                                    @endif
                                    
                                    <dt class="col-sm-4">Jumlah Unit</dt>
                                    <dd class="col-sm-4">{{ $fa->jumlah_unit }}</dd>
                                    
                                    @if($fa->unit_asal)
                                        <dt class="col-sm-4">Unit Asal Aset</dt>
                                        <dd class="col-sm-8">{{ ucfirst($fa->unit_asal) }}</dd>
                                    @endif
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </section>
        
    </div>
@endsection
@section('scripttambahan')
    <!-- InputMask -->
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/inputmask/jquery.inputmask.min.js') }}"></script>
    <!-- Summernote -->
    <script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
    <!-- bs-custom-file-input -->
    <script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <!-- Page specific script -->

    <!-- Add SweetAlert library -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Show SweetAlert on success -->
     
    <script>
        $(document).ready(function() {
            // Store all ruang and jenis options when the page loads
            var allRuangOptions = $('#ruang option').clone();

            // SweetAlert for success message
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: "{{ session('success') }}",
                    showConfirmButton: true,
                    timer: 3000
                });
            @endif
    
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
    
            // Trigger filtering functions when selection changes
            $('#instansi').change(filterRuang);
    
            // Automatically trigger filtering on page load (for edit mode)
            filterRuang();
        });
    </script>
    <script>
        $(function() {
            $('[data-mask]').inputmask()
            $('#formdes_barang').summernote({
                height: 100, //set editable area's height,
                toolbar: [
                    // [groupName, [list of button]]
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['fontsize', ['fontsize']],
                    ['para', ['ul', 'ol']],
                ],
                placeholder: 'Spesifikasi, warna, bahan, nomor barang lainnya ...'
            });
            bsCustomFileInput.init();
        });

       
    </script>
  
@endsection


