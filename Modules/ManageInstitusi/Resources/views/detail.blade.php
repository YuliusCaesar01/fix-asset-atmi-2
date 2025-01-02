@extends('layouts.layout_main')
@section('title', 'Data Detail Institusi')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Detail Institusi</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('manageinstitusi.index') }}">Home</a></li>
                            <li class="breadcrumb-item active">Detail Institusi</li>
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
                                <h3 class="m-0 text-center" id="nama_institusi"><i class="fas fa-building"></i>
                                    {{ $ins->nama_institusi }}</h3>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-6">
                                        <h4 class="m-0 text-center">
                                            <span class="badge badge-primary"><i class="fas fa-barcode"></i> Kode :
                                                {{ $ins->kode_institusi }}</span>
                                        </h4>
                                    </div>
                                    @if(auth()->user()->role_id == 19)
                                    <div class="col-6">
                                        <a href="javascript:void(0)" id="btn-edit-institusi" title="Ubah Tipe"
                                            data-di="{{ $ins->id_institusi }}" class="btn btn-sm btn-secondary float-right">
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
                        <img src="{{ $ins->foto_institusi ? asset('foto/fixasetlist/' . basename($ins->foto_institusi)) : asset('boxs.png') }}" class="product-image" alt="Foto Barang Aset">
                    </div>
                </div>

                <!-- Main content -->
                <div class="card card-primary-outline">
                    <div class="card-header">
                        <h3 class="card-title">Divisi Terkait dalam Institusi</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="tbl_divisi" class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Kode</th>
                                    <th><i class="fas fa-bars"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($divisi as $div)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $div->nama_divisi }}</td>
                                        <td>{{ $div->kode_divisi }}</td>
                                        <td> Detail </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Kode </th>
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

    @include('manageinstitusi::modal-edit')
@endsection
@section('scripttambahan')
    <!-- Page specific script -->
    <script>
        $(function() {
            $("#tbl_divisi").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#tbl_divisi_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection
