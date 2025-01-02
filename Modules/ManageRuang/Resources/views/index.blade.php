@extends('layouts.layout_main')
@section('title', 'Data Ruang')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div class="container-fluid">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-6">
                            <h1 class="m-0">Data Ruang</h1>
                        </div><!-- /.col -->
                        @if(auth()->user()->role_id == 19)

                        <div class="col-6">
                            <a href="javascript:void(0)" class="btn btn-sm btn-info float-right" id="btn-create-ruang">
                                <i class="fas fa-plus"></i> Ruang
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
                        <div class="card-header">
                            <div class="row">
                                <div class="col-6">
                                    <h5 class="m-0">Ruang</h5>
                                </div>
                                <div class="col-6" style="display: grid; grid-template-columns: auto 1fr; align-items: center;">
                                    <span>Pilih Institusi:</span>
                                    <select class="form-control form-control-sm" id="mode-selector">
                                        <center>
                                        <option value="yayasan">Yayasan</option>
                                        <option value="smkmikael">SMK Mikael</option>
                                        <option value="politeknik">Politeknik</option>
                                        </center>
                                    </select>
                                </div>
                                
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <table id="tbl_ruang" class="table table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Ruang</th>
                                        <th>Kode Ruang</th>
                                        <th class="w-1"><i class="fas fa-bars"></i></th>
                                    </tr>
                                </thead>
                                <tbody id="ruang-body">
                                    @foreach ($ruang as $rg)
                                        <tr id="index_{{ $rg->id_ruang }}" data-iteration="{{ $loop->iteration }}" 
                                            data-nama-ruang-yayasan="{{ $rg->nama_ruang_yayasan }}" 
                                            data-nama-ruang-smkmikael="{{ $rg->nama_ruang_mikael }}" 
                                            data-nama-ruang-politeknik="{{ $rg->nama_ruang_politeknik }}">
                                            <td>{{ $loop->iteration }}</td>
                                            <td class="nama-ruang">{{ $rg->nama_ruang_yayasan }}</td>
                                            <td class="text-center lead">
                                                <span class="badge badge-danger">{{ $rg->kode_ruang }}</span>
                                            </td>
                                            <td>
                                                <a href="javascript:void(0)" id="btn-detail-ruang"
                                                    data-di = "{{ $rg->id_ruang }}" title="Detail Ruang"
                                                    class="btn btn-sm btn-light">
                                                    <i class="far fa-folder-open"></i> Detail
                                                </a>
                                                @role('manageraset')
                                                <form id="delete-user-form-{{ $rg->id_ruang }}" action="{{ route('manage-ruang.destroy', $rg->id_ruang) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-sm btn-danger" title="Delete Aset"
                                                        style="font-size: 0.7rem; padding: 0.25rem 0.5rem;" 
                                                        onclick="confirmDelete('{{ $rg->id_ruang }}')">
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
                                        <th>#</th>
                                        <th>Nama Ruang</th>
                                        <th>Kode Ruang</th>
                                        <th><i class="fas fa-bars"></i></th>
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
    @include('manageruang::modal-create')

@endsection

@section('scripttambahan')
    <script>
        $(document).ready(function() {
            // Handle mode change event
            $('#mode-selector').change(function() {
                let selectedMode = $(this).val();

                // Loop through each row and update the "Nama Ruang" column based on the selected mode
                $('#ruang-body tr').each(function() {
                    let namaRuang;
                    switch (selectedMode) {
                        case 'yayasan':
                            namaRuang = $(this).data('nama-ruang-yayasan');
                            break;
                        case 'smkmikael':
                            namaRuang = $(this).data('nama-ruang-smkmikael');
                            break;
                        case 'politeknik':
                            namaRuang = $(this).data('nama-ruang-politeknik');
                            break;
                    }
                    $(this).find('.nama-ruang').text(namaRuang);
                });
            });

            // Detail button event
            $('body').on('click', '#btn-detail-ruang', function() {
                let kode = $(this).data('di');

                $.ajax({
                    type: "GET",
                    success: function(response) {
                        window.location.href = `/ruang/manageruang/detail/${kode}`;
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });
        });

        // DataTables initialization
        $(function() {
            $("#tbl_ruang").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#tbl_ruang_wrapper .col-md-6:eq(0)');
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#form-create-ruang').on('submit', function(e) {
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
