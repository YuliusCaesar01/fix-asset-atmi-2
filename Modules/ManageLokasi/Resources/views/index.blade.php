@extends('layouts.layout_main')
@section('title', 'Data Lokasi')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div class="container-fluid">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-6">
                            <h1 class="m-0">Data Lokasi</h1>
                        </div><!-- /.col -->
                        @if(auth()->user()->role_id == 19)

                        <div class="col-6">
                            <a href="javascript:void(0)" class="btn btn-sm btn-info float-right" id="btn-create-lokasi">
                                <i class="fas fa-plus"></i> Lokasi
                            </a>
                        </div>
                        @endif
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->
            <div class="content">
                <div class="container-fluid">
                    <div class="card">
                        
                        <div class="card-body">
                            <table class="table table-striped table-sm" id="tbl_lokasi">
                                <thead>
                                    <tr>
                                        <th>Kode Lokasi</th>
                                        <th>Nama</th>
                                        <th>Keterangan</th>
                                        <th class="w-1"><i class="fas fa-bars"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($lokasi as $lok)
                                    <tr id="index_{{ $lok->id_lokasi  }}" data-iteration="{{ $loop->iteration }}" 
                                        data-nama-lokasi-yayasan="{{ $lok->nama_lokasi_yayasan }}" 
                                        data-nama-lokasi-smkmikael="{{ $lok->nama_lokasi_mikael }}" 
                                        data-nama-lokasi-politeknik="{{ $lok->nama_lokasi_politeknik }}">
                                            <td class="text-center lead">
                                                <span class="badge bg-yellow">{{ $lok->kode_lokasi }} </span>
                                            </td>
                                            <td class="nama-lokasi">{{ $lok->nama_lokasi_yayasan }}</td>
                                            <td >{{ $lok->keterangan_lokasi }}</td>

                                            <td>
                                                <a href="javascript:void(0)" id="btn-detail-lokasi"
                                                    data-di = "{{ $lok->id_lokasi }}" title="Detail Lokasi"
                                                    class="btn btn-sm btn-light">
                                                    <i class="far fa-folder-open"></i> Detail
                                                </a>
                                                @role('manageraset')
                                                <form id="delete-user-form-{{ $lok->id_lokasi }}" action="{{ route('manage-lokasi.destroy', $lok->id_lokasi ) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-sm btn-danger" title="Delete Aset"
                                                        style="font-size: 0.7rem; padding: 0.25rem 0.5rem;" 
                                                        onclick="confirmDelete('{{ $lok->id_lokasi }}')">
                                                        <i class="fa fa-trash"></i> Delete
                                                    </button>
                                                </form>
                                                @endrole
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Kode Lokasi</th>
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
    @include('managelokasi::modal-create')

@endsection
@section('scripttambahan')
<script>

if ($.fn.DataTable.isDataTable('#tbl_lokasi')) {
    $('#tbl_lokasi').DataTable().destroy();
}


        $(function() {
            $("#tbl_lokasi").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#tbl_lokasi_wrapper .col-md-6:eq(0)');
        });
    </script>
    
<script>
   

    // Handle form submission for creating kelompok
    $(document).ready(function() {
        $('#form-create-lokasi').on('submit', function(e) {
            e.preventDefault(); // Prevent the default form submission
            $.ajax({
                url: $(this).attr('action'), // Get the form action URL
                type: 'POST',
                data: $(this).serialize(), // Serialize the form data
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.message,
                    }).then(() => {
                        location.reload(); // Reload the page after closing the alert
                    });
                },
                error: function(xhr) {
                    let errors = xhr.responseJSON.errors;
                    let errorMessage = '';
                    $.each(errors, function(key, value) {
                        errorMessage += value[0] + '\n'; // Concatenate all error messages
                    });
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Errors',
                        text: errorMessage,
                    });
                }
            });
        });
    });
     // Detail button event
     $('body').on('click', '#btn-detail-lokasi', function() {
                let kode = $(this).data('di');

                $.ajax({
                    type: "GET",
                    success: function(response) {
                        window.location.href = `/lokasi/managelokasi/detail/${kode}`;
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });
            function confirmDelete(id) { 
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            // Submit the form to delete the asset
            document.getElementById('delete-user-form-' + id).submit();
            
            // Show success message
            Swal.fire(
                'Deleted!',
                'The asset has been deleted.',
                'success'
            );
        }
    });
}
</script>

@endsection
