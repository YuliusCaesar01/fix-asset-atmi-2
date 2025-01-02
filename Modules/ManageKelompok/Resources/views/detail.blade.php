@extends('layouts.layout_main')
@section('title', 'Data Detail Kelompok')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Detail Kelompok</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('managekelompok.index') }}">Kelompok</a></li>
                            <li class="breadcrumb-item active">Detail Kelompok</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h4 class="m-0 text-center text-purple lead">Kelompok :
                                    <span class="badge bg-purple">{{ $kelompok->kode_kelompok }}</span> {{ $kelompok->nama_kelompok }}
                                </h4>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-6">
                                        <h3 class="m-0 text-center" id="nama_kelompok"><i class="fas fa-building"></i>
                                            {{ $kelompok->nama_kelompok }}
                                        </h3>
                                        <h4 class="m-0 text-center">
                                            <span class="badge badge-primary"><i class="fas fa-barcode"></i> Kode :
                                                {{ $kelompok->kode_kelompok }}</span>
                                        </h4>
                                    </div>
                                    @if(auth()->user()->role_id == 19)
                                    <div class="col-6">
                                        <a href="javascript:void(0)" id="btn-edit-kelompok" title="Ubah kelompok"
                                            data-di="{{   $kelompok->id_kelompok}}" class="btn btn-sm btn-secondary float-right">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                    </div>
                                    @endif
                                </div>
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </div><!-- /.container-fluid -->
                </div>
                <!-- /.content-header -->

                 <!-- Display the image -->
                 <div class="row mb-4">
                    <div class="col-12 text-center">
                        
                        <img src="{{ asset('boxs.png') }}" alt="Descriptive Alt Text" width="400" height="auto">
                    
                    </div>
                </div>
                <!-- Main content -->
                <div class="card card-primary-outline">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">
                                <h3 class="card-title">Jenis</h3>
                            </div>
                         
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="tbl_jenis" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Kelompok</th>
                                    <th>Kode Kelompok</th>
                                </tr>
                            </thead>
                            <tbody>
                                    <tr id="index_{{ $kelompok->id_kelompok }}">
                                        <td></td>
                                        <td class="nama-jenis">{{ $kelompok->nama_kelompok_yayasan }}</td>
                                        <td class="text-center lead">
                                            <span class="badge badge-warning">{{ $kelompok->kode_kelompok }}</span>
                                        </td>
                                       
                                    </tr>
                                
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Kelompok</th>
                                    <th>Kode Kelompok</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.content -->
            </div>
        </section>
    </div>

    @include('managekelompok::modal-edit')
@endsection

@section('scripttambahan')
    <script>
        $(document).ready(function() {
            // Handle mode change event
            $('#mode-selector').change(function() {
                let selectedMode = $(this).val();

                // Update the "Nama Jenis" column based on the selected mode
                $('#tbl_jenis tbody tr').each(function() {
                    let namaJenis;
                    switch (selectedMode) {
                        case 'yayasan':
                            namaJenis = $(this).data('nama-jenis-yayasan');
                            break;
                        case 'smkmikael':
                            namaJenis = $(this).data('nama-jenis-smkmikael');
                            break;
                        case 'politeknik':
                            namaJenis = $(this).data('nama-jenis-politeknik');
                            break;
                    }
                    $(this).find('.nama-jenis').text(namaJenis);
                });
            });

            // Trigger the mode change event to initialize table with the default mode
            $('#mode-selector').trigger('change');

            $("#tbl_jenis").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#tbl_jenis_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection

