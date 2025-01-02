@extends('layouts.layout_main')
@section('title', 'Data Detail Divisi')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Detail Divisi</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('managedivisi.index') }}">Home</a></li>
                            <li class="breadcrumb-item active">Detail Divisi</li>
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
                                <h4 class="m-0 text-center text-purple lead">Institusi :
                                    <span class="badge bg-purple">{{ $divisi->institusi->kode_institusi }}</span>
                                    {{ $divisi->institusi->nama_institusi }}
                                </h4>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-6">
                                        <h3 class="m-0 text-center" id="nama_divisi"><i class="fas fa-tags"></i>
                                            {{ $divisi->nama_divisi }}
                                        </h3>
                                        <h4 class="m-0 text-center">
                                            <span class="badge badge-primary"><i class="fas fa-barcode"></i> Kode :
                                                {{ $divisi->kode_divisi }}</span>
                                        </h4>
                                    </div>
                                    <div class="col-6">
                                        <a href="javascript:void(0)" id="btn-edit-divisi" title="Ubah Divisi"
                                            data-di="{{ $divisi->id_divisi }}" class="btn btn-sm btn-secondary float-right">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                    </div>
                                </div>
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </div><!-- /.container-fluid -->
                </div>
                <!-- /.content-header -->


                <!-- Main content -->
                <div class="card card-primary-outline">
                    <div class="card-header">
                        <h3 class="card-title">User Terkait dalam Divisi</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="tbl_user" class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Foto</th>
                                    <th>Nama</th>
                                    <th><i class="fas fa-bars"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($user as $usr)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <center>
                                                <img src="{{ asset('vendor/img/' . $usr->foto) }}" style="width:30px"
                                                    class="img-circle elevation-2" alt="User Image">
                                            </center>
                                        </td>
                                        <td>{{ $usr->name }}</td>
                                        <td> Detail </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Foto</th>
                                    <th>Nama</th>
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

    @include('managedivisi::modal-edit')
@endsection
@section('scripttambahan')
    <!-- Page specific script -->
    <script>
        $(function() {
            $("#tbl_user").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#tbl_user_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection
