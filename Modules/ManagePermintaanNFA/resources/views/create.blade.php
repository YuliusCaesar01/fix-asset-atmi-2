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
                            <h1 class="m-0">Permintaan Non Fixed Assets(NFA)</h1>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->
            <div class="content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header d-flex p-0">
                            <h3 class="card-title p-3">Non Fixed Assets</h3>
                            <ul class="nav nav-pills ml-auto p-3">
                                <a href="{{ route('managepermintaannfa.index') }}" class="nav-link active btn btn-secondary"  >Exit</a>
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
                                    <form action="{{ route('storedata') }}" method="post">
                                        @csrf                                        
                                        <input type="hidden" id="id_fa">
                                        <div class="form-group">
                                            <label for="institusi">Institusi</label>
                                            <select class="form-control" id="institusi" name="id_institusi">
                                                <option value="">Pilih Institusi</option>
                                                @foreach($institusis as $institusi)
                                                    <option value="{{ $institusi->id_institusi }}">{{ $institusi->nama_institusi }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        {{-- <div class="form-group">
                                            <label for="karyawan">Atas nama Karyawan</label>
                                            <input type="text" class="form-control" id="karyawan" name="id_karyawan" placeholder="Tulis Lengkap Nama Karyawan">
                                        </div> --}}
                                        <div class="form-group">
                                            <label for="email" class="control-label">Email Pengaju</label>
                                            <input type="email" class="form-control" name="email" id="email" required>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="formdes_barang" class="control-label">Deskripsi Detail
                                                Barang/Jasa(NFA) Permintaan</label>
                                            <textarea class="form-control" rows="3" name="des_barang" id="formdes_barang"></textarea>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="jenislayanan">Jenis Layanan</label>
                                                    <!-- Radio buttons for Jenis Layanan -->
                                                    <div class="custom-control custom-radio d-inline-block mr-3">
                                                        <input onclick="displaySelectedValue(this)" type="radio" id="jenislayanan_jasa" name="jenislayanan" value="Jasa" class="custom-control-input">
                                                        <label class="custom-control-label" for="jenislayanan_jasa">Jasa</label>
                                                    </div>
                                                    <div class="custom-control custom-radio d-inline-block mr-3">
                                                        <input onclick="displaySelectedValue(this)" type="radio" id="jenislayanan_barang" name="jenislayanan" value="Barang" class="custom-control-input">
                                                        <label class="custom-control-label" for="jenislayanan_barang">Barang</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="butuhbarangtidak" class="col-md-4">
                                                
                                                <div  class="form-group">
                                                    <label for="butuhbarang">Butuh Barang?</label>
                                                    <!-- Radio buttons for Butuh Barang -->
                                                    <div class="custom-control custom-radio d-inline-block mr-3">
                                                        <input onclick="displaySelectedValue2(this)" type="radio" id="butuhbarang_ya" name="butuhbarang" value="Ya" class="custom-control-input">
                                                        <label class="custom-control-label" for="butuhbarang_ya">Ya</label>
                                                    </div>
                                                    <div  class="custom-control custom-radio d-inline-block mr-3">
                                                        <input onclick="displaySelectedValue2(this)" type="radio" id="butuhbarang_tidak" name="butuhbarang" value="Tidak" class="custom-control-input">
                                                        <label class="custom-control-label" for="butuhbarang_tidak">Tidak</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="butuhsubcontidak"class="col-md-4">
                                                <div class="form-group">
                                                    <label for="butuhsubcon">Butuh Subcon?</label>
                                                    <!-- Radio buttons for Butuh Subcon -->
                                                    <div class="custom-control custom-radio d-inline-block mr-3">
                                                        <input type="radio" id="butuhsubcon_ya" name="butuhsubcon" value="Ya" class="custom-control-input">
                                                        <label class="custom-control-label" for="butuhsubcon_ya">Ya</label>
                                                    </div>
                                                    <div class="custom-control custom-radio d-inline-block mr-3">
                                                        <input type="radio" id="butuhsubcon_tidak" name="butuhsubcon" value="Tidak" class="custom-control-input">
                                                        <label class="custom-control-label" for="butuhsubcon_tidak">Tidak</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <button type="submit" class="btn btn-primary btn-block">Ajukan</button>
                                    </form>
                                </div>
                                <!-- /.tab-pane -->
                            </div>
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
    document.getElementById("butuhbarangtidak").style.display = 'none';
    document.getElementById("butuhsubcontidak").style.display = 'none';

    function displaySelectedValue(radioButton) {
            const selectedValue = radioButton.value;
           
        
             if (selectedValue === 'Jasa') {
                document.getElementById("butuhsubcontidak").style.display = 'block';
             }else{
                document.getElementById("butuhbarangtidak").style.display = 'none';
                document.getElementById("butuhsubcontidak").style.display = 'none';
                document.getElementById("butuhbarangtidak").checked = false;

             }
        }
   
        
    </script>
    <!-- InputMask -->
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/inputmask/jquery.inputmask.min.js') }}"></script>
    <!-- Summernote -->
    <script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
    <!-- bs-custom-file-input -->
    <script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            // ... existing script ...

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


