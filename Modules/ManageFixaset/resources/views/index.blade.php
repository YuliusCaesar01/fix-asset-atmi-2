@extends('layouts.layout_main')
@section('title', 'Data Institusi')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div class="container-fluid">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-6">
                            <h1 class="m-0">Data Permintaan Fixed Asset</h1>
                        </div><!-- /.col -->
                        <div class="col-6">
                            <a href="javascript:void(0)" class="btn btn-sm btn-info float-right" id="btn-create-institusi">
                                <i class="fas fa-plus"></i> Fixed Asset
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
                            <h5 class="m-0">Fixed Asset</h5>
                        </div>
                        <div class="card-body">
                            <table id="tbl_permintaanfa"  class="table table-striped table-sm" id="tbl_institusi">
                                <thead>
                                    <tr>
                                        <th>Kode Permintaan FA</th>
                                        <th>Pengajuan</th>
                                        <th>    </th>
                                        <th>    </th>
                                        <th class="w-1"><i class="fas fa-bars"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($fixedaset as $fixed)
                                        <tr id="index_{{ $fixed->id_institusi }}">
                                            <td class="text-center lead">
                                                <span class="badge bg-yellow">{{ $fixed->kode_institusi }} </span>
                                            </td>
                                            <td>{{ $fixed->nama_institusi }}</td>
                                            <td>
                                                <a href="javascript:void(0)" id="btn-detail-institusi"
                                                    data-di = "{{ $fixed->id_institusi }}" title="Detail Institusi"
                                                    class="btn btn-sm btn-light">
                                                    <i class="far fa-folder-open"></i> Detail
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Kode Permintaan FA</th>
                                        <th>Pengajuan</th>
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
    @include('manageinstitusi::modal-create')

@endsection
@section('scripttambahan')
    <script>
        $(document).ready(function() {
            //button create post event
            $('body').on('click', '#btn-detail-institusi', function() {
                let kode = $(this).data('di');

                $.ajax({
                    type: "GET",
                    success: function(response) {
                        // Redirect ke URL yang diterima dalam respons
                        window.location.href =
                            `/institusi/manageinstitusi/detail/${kode}`;
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
            $("#tbl_institusi").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#tbl_institusi_wrapper .col-md-6:eq(0)');
        });
    </script>
@endsection



    
