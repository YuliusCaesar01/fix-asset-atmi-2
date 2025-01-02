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
                            <h1 class="m-0">Data Institusi</h1>
                        </div><!-- /.col -->
                        @if(auth()->user()->role_id == 19)

                        <div class="col-6">
                            {{-- <a href="javascript:void(0)" class="btn btn-sm btn-info float-right" id="btn-create-kelompok">
                                <i class="fas fa-plus"></i> Institusi
                            </a> --}}
                        </div>
                        @endif
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->
            <div class="content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="m-0">Institusi</h5>
                        </div>
                        <div class="card-body">
                            <table  class="table table-striped table-sm" id="tbl_institusi">
                                <thead>
                                    <tr>
                                        <th>Kode Institusi</th>
                                        <th>Nama</th>
                                        <th class="w-1"><i class="fas fa-bars"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($institusi as $ins)
                                        <tr id="index_{{ $ins->id_institusi }}">
                                            <td class="text-center lead">
                                                <span class="badge bg-yellow">{{ $ins->kode_institusi }} </span>
                                            </td>
                                            <td>{{ $ins->nama_institusi }}</td>
                                            <td>
                                                <a href="javascript:void(0)" id="btn-detail-institusi"
                                                    data-di = "{{ $ins->id_institusi }}" title="Detail Institusi"
                                                    class="btn btn-sm btn-light">
                                                    <i class="far fa-folder-open"></i> Detail
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Kode Institusi</th>
                                        <th>Nama</th>
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
    <script>
        $(document).ready(function() {
            $('#form-create-kelompok').on('submit', function(e) {
                e.preventDefault(); // Prevent the default form submission
    
                $.ajax({
                    url: $(this).attr('action'), // Get the form action URL
                    type: 'POST',
                    data: $(this).serialize(), // Serialize the form data
                    success: function(response) {
                        // Show success message with SweetAlert
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message, // Success message from the server
                        }).then(() => {
                            location.reload(); // Reload the page after closing the alert
                        });
                    },
                    error: function(xhr) {
                        // Show error messages with SweetAlert
                        let errors = xhr.responseJSON.errors;
                        let errorMessage = '';
                        $.each(errors, function(key, value) {
                            errorMessage += value[0] + '\n'; // Concatenate all error messages
                        });
    
                        Swal.fire({
                            icon: 'error',
                            title: 'Validation Errors',
                            text: errorMessage, // Show validation errors
                        });
                    }
                });
            });
        });
    </script>
@endsection
