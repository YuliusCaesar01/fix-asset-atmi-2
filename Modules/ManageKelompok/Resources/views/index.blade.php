@extends('layouts.layout_main')
@section('title', 'Data Kelompok Barang')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div class="container-fluid">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-6">
                            <h1 class="m-0">Data Kelompok</h1>
                        </div><!-- /.col -->
                        @if(auth()->user()->role_id == 19)

                        <div class="col-6">
                            <a href="javascript:void(0)" class="btn btn-sm btn-info float-right" id="btn-create-kelompok">
                                <i class="fas fa-plus"></i> Kelompok
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
                                    <h5 class="m-0">Kelompok</h5>
                                </div>
                              
                            </div>
                        </div>
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
                                        <tr id="index_{{ $kl->id_kelompok }}" data-iteration="{{ $loop->iteration }}">
                                            
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
                                                @role('manageraset')
                                                <form action="{{ route('manage-kelompok.destroy',  $kl->id_kelompok ) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Delete Aset"
                                                        style="font-size: 0.7rem; padding: 0.25rem 0.5rem;" 
                                                        onclick="return confirm('Apakah Anda yakin ingin menghapus aset ini?')">
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
                                        <th>Nama</th>
                                        <th>Kode Kelompok</th>
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
<!-- Modal Create Kelompok -->
<div class="modal fade" id="createKelompokModal" tabindex="-1" aria-labelledby="createKelompokLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createKelompokLabel">Create Kelompok</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="modal-body">
                <form id="form-create-kelompok" action="{{ route('manage-kelompok.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf <!-- Include CSRF token for security -->

                    <div class="mb-3">
                        <label for="namaKelompok" class="form-label">Nama Kelompok</label>
                        <input type="text" class="form-control @error('nama_kelompok') is-invalid @enderror" id="namaKelompok" name="nama_kelompok" required value="{{ old('nama_kelompok') }}">
                        @error('nama_kelompok')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="tipeKelompok" class="form-label">Tipe Kelompok</label>
                        <select class="form-control @error('tipe_kelompok') is-invalid @enderror" id="tipeKelompok" name="tipe_kelompok" required>
                            <option value="">Select Tipe Kelompok</option> <!-- Placeholder option -->
                            @foreach($tipe as $item)
                                <option value="{{ $item->id_tipe }}" {{ old('tipe_kelompok') == $item->id_tipe ? 'selected' : '' }}>
                                    {{ $item->nama_tipe_yayasan }}
                                </option> <!-- Replace 'nama_tipe_yayasan' with the appropriate attribute -->
                            @endforeach
                        </select>
                        @error('tipe_kelompok')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="imageKelompok" class="form-label">Upload Gambar (optional)</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="imageKelompok" name="image" accept="image/*">
                        <small>Gambar Minimal 2 Mb</small>
                        @error('image')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Create</button>
                </form>
            </div>
        </div>
    </div>
</div>

  
@endsection

@section('scripttambahan')

    <script>
        $(document).ready(function() {
            // Handle mode change event
            

            // Button create post event
            $('body').on('click', '#btn-detail-kelompok', function() {
                let kode = $(this).data('di');

                $.ajax({
                    type: "GET",
                    success: function(response) {
                        // Redirect to the URL received in the response
                        window.location.href = `/kelompok/managekelompok/detail/${kode}`;
                    },
                    error: function(xhr, status, error) {
                        // Handle errors if needed
                        console.error(xhr.responseText);
                    }
                });
            });

            // Trigger the mode change event to initialize table with the default mode
            $('#mode-selector').trigger('change');
        });

        $(function() {
            $("#tbl_kelompok").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#tbl_kelompok_wrapper .col-md-6:eq(0)');
        });
    </script>
    <script>
     $('body').on('click', '#btn-create-kelompok', function() {
    $('#createKelompokModal').modal('show'); // Show the modal for adding a new Kelompok
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
