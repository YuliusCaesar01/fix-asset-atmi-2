@extends('layouts.layout_main')
@section('title', 'Data Detail Tipe')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Detail Tipe</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('managetipe.index') }}">Home</a></li>
                            <li class="breadcrumb-item active">Detail Tipe</li>
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
                                <h3 class="m-0 text-center" id="nama_tipe"><i class="fas fa-building"></i>
                                    {{ $tipe->nama_tipe_yayasan }}</h3>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-6">
                                        <h4 class="m-0 text-center">
                                            <span class="badge badge-success"><i class="fas fa-barcode"></i> Kode :
                                                {{ $tipe->kode_tipe }}</span>
                                        </h4>
                                    </div>
                                    @if(auth()->user()->role_id == 19)
                                    <div class="col-6">
                                        <a href="javascript:void(0)" id="btn-edit-tipe" title="Ubah Tipe"
                                            data-di="{{ $tipe->id_tipe }}" class="btn btn-sm btn-secondary float-right">
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
                    
                    <img src="{{ $tipe->foto_tipe ? asset('foto/fixasetlist/' . basename($tipe->foto_tipe)) : asset('boxs.png') }}" class="product-image" alt="Foto Barang Aset">
                
                </div>
            </div>
                <!-- Main content -->
                <div class="card card-primary-outline">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">
                                <h3 class="card-title">Kelompok</h3>
                            </div>
                          
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="tbl_kelompok" class="table table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Kode Kelompok</th>
                                    <th class="w-1"><i class="fas fa-bars"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kelompok as $kl)
                                    <tr id="index_{{ $kl->id_kelompok }}">
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="nama-kelompok">{{ $kl->nama_kelompok_yayasan }}</td>
                                        <td class="text-center lead">
                                            <span class="badge bg-pink">{{ $kl->kode_kelompok }}</span>
                                        </td>
                                        <td>
                                            <a href="javascript:void(0)" id="btn-detail-kelompok"
                                                data-di="{{ $kl->id_kelompok }}" title="Detail Kelompok"
                                                class="btn btn-sm btn-light">
                                                <i class="far fa-folder-open"></i> Detail
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Kode Kelompok</th>
                                    <th><i class="fas fa-bars"></i></th>
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

    @include('managetipe::modal-edit')
@endsection

@section('scripttambahan')
    <script>
        $(document).ready(function() {
            // Handle mode change event
            $('#mode-selector').change(function() {
                let selectedMode = $(this).val();

                // Update the "Nama Kelompok" column based on the selected mode
                $('#tbl_kelompok tbody tr').each(function() {
                    let namaKelompok;
                    switch (selectedMode) {
                        case 'yayasan':
                            namaKelompok = $(this).data('nama-kelompok-yayasan');
                            break;
                        case 'smkmikael':
                            namaKelompok = $(this).data('nama-kelompok-smkmikael');
                            break;
                        case 'politeknik':
                            namaKelompok = $(this).data('nama-kelompok-politeknik');
                            break;
                    }
                    $(this).find('.nama-kelompok').text(namaKelompok);
                });
            });

            // Trigger the mode change event to initialize table with the default mode
            $('#mode-selector').trigger('change');

            // Handle button click to view details
            $('body').on('click', '#btn-detail-kelompok', function() {
                let kode = $(this).data('di');

                $.ajax({
                    type: "GET",
                    success: function(response) {
                        // Redirect to the details page
                        window.location.href = `/kelompok/managekelompok/detail/${kode}`;
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });

            $("#tbl_kelompok").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#tbl_kelompok_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection
