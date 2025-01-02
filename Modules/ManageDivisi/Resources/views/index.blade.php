@extends('layouts.layout_main')
@section('title', 'Data Divisi')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div class="container-fluid">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-6">
                            <h1 class="m-0">Data Divisi</h1>
                        </div><!-- /.col -->
                        <div class="col-6">
                            <a href="javascript:void(0)" class="btn btn-sm btn-info float-right" id="btn-create-divisi">
                                <i class="fas fa-plus"></i> Divisi
                            </a>
                        </div>
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->
            <div class="content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="m-0">Divisi</h5>
                        </div>
                        <div class="card-body">
                            <table  class="table table-striped table-sm" id="tbl_divisi">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Institusi</th>
                                        <th>Nama Divisi</th>
                                        <th>Kode Divisi</th>
                                        <th class="w-1"><i class="fas fa-bars"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($divisi as $dv)
                                        <tr id="index_{{ $dv->id_divisi }}">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $dv->institusi->nama_institusi }}</td>
                                            <td>{{ $dv->nama_divisi }}</td>
                                            <td class="text-center lead">
                                                <span class="badge bg-yellow">{{ $dv->kode_divisi }} </span>
                                            </td>
                                            <td>
                                                <a href="javascript:void(0)" id="btn-detail-divisi"
                                                    data-di = "{{ $dv->id_divisi }}" title="Detail divisi"
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
                                        <th>Institusi</th>
                                        <th>Nama Divisi</th>
                                        <th>Kode Divisi</th>
                                        <th class="w-1"><i class="fas fa-bars"></i></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.content -->
        </div>
    </div>
    @include('managedivisi::modal-create')

@endsection
@section('scripttambahan')
    <script>
        $(document).ready(function() {
            //button create post event
            $('body').on('click', '#btn-detail-divisi', function() {
                let kode = $(this).data('di');

                $.ajax({
                    type: "GET",
                    success: function(response) {
                        // Redirect ke URL yang diterima dalam respons
                        window.location.href = `/divisi/managedivisi/detail/${kode}`;
                    },
                    error: function(xhr, status, error) {
                        // Tangani kesalahan jika diperlukan
                        console.error(xhr.responseText);
                    }
                });

            });
        });
    </script>
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
