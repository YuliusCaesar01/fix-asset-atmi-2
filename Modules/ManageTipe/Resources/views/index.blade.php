@extends('layouts.layout_main')
@section('title', 'Data Tipe')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <div class="container-fluid">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-6">
                            <h1 class="m-0">Data Tipe</h1>
                        </div><!-- /.col -->
                        @if(auth()->user()->role_id == 19)

                        <div class="col-6">
                            <a href="javascript:void(0)" class="btn btn-sm btn-info float-right" id="btn-create-kelompok">
                                <i class="fas fa-plus"></i> Tipe
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
                                    <h5 class="m-0">Tipe</h5>
                                </div>
                                <div class="col-6" style="display: grid; grid-template-columns: auto 1fr; align-items: center;">
                                    <span>Pilih Jenis:</span>
                                    <input class="form-control form-control-sm" list="jenis-list" id="jenis-input" placeholder="Pilih atau ketik jenis...">
                                    <datalist id="jenis-list">
                                        @foreach($tipe as $k)
                                            <option value="{{ $k->nama_jenis_yayasan }}">
                                        @endforeach
                                    </datalist>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="tbl_tipe" class="table table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Kelompok</th>
                                        <th>Nama Jenis</th>
                                        <th>Nama Tipe</th>
                                        <th>Kode Tipe</th>
                                        <th class="w-1"><i class="fas fa-bars"></i></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tipe as $tp)
                                        <tr id="index_{{ $tp->id_tipe }}" data-iteration="{{ $loop->iteration }}"
                                            data-nama-tipe-yayasan="{{ $tp->nama_tipe_yayasan }}"
                                            data-nama-tipe-mikael="{{ $tp->nama_tipe_mikael }}"
                                            data-nama-tipe-politeknik="{{ $tp->nama_tipe_politeknik }}">
                                            <td>{{ $loop->iteration }}</td>
                                            <td class="nama-tipe">{{ $tp->nama_kelompok_yayasan }}</td>
                                            <td class="nama-tipe">{{ $tp->nama_jenis_yayasan }}</td>
                                            <td class="nama-tipe">{{ $tp->nama_tipe_yayasan }}</td>
                                            <td class="text-center lead">
                                                <span class="badge bg-green">{{ $tp->kode_tipe }}</span>
                                            </td>
                                            <td>
                                                <a href="javascript:void(0)" id="btn-detail-tipe"
                                                    data-di="{{ $tp->id_tipe }}" title="Detail Tipe"
                                                    class="btn btn-sm btn-light">
                                                    <i class="far fa-folder-open"></i> Detail
                                                </a>
                                                @role('manageraset')
                                                <form id="delete-user-form-{{ $tp->id_tipe }}" action="{{ route('manage-tipe.destroy', $tp->id_tipe)  }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-sm btn-danger" title="Delete Aset"
                                                        style="font-size: 0.7rem; padding: 0.25rem 0.5rem;" 
                                                        onclick="confirmDelete('{{ $tp->id_tipe }}')">
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
                                        <th>No</th>
                                        <th>Nama Kelompok</th>
                                        <th>Nama Jenis</th>
                                        <th>Nama Tipe</th>
                                        <th>Kode Tipe</th>
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
    
<!-- Update the form in the modal -->
<div class="modal fade" id="modal-create" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">TAMBAH DATA TIPE</h5>
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
                <form id="form-tipe" method="POST" action="/tipe/managetipe" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="id_tipe" name="id_tipe">
                    
                    <div class="form-group">
                        <label for="nama_kelompok" class="control-label">Nama Kelompok</label>
                        <select class="form-control @error('nama_kelompok') is-invalid @enderror" id="nama_kelompok" name="nama_kelompok">
                            <option value="">Select Kelompok</option>
                        </select>
                        @error('nama_kelompok')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="nama_jenis" class="control-label">Nama Jenis</label>
                        <select class="form-control @error('nama_jenis') is-invalid @enderror" id="nama_jenis" name="nama_jenis">
                            <option value="">Select Jenis</option>
                        </select>
                        @error('nama_jenis')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Hidden input untuk nama_jenis_yayasan -->
                    <input type="hidden" id="nama_jenis_yayasan" name="nama_jenis_yayasan">
                    
                    <div class="form-group">
                        <label for="id_jenis" class="control-label">ID Jenis Terpilih</label>
                        <div id="id_jenis" class="border p-2">Pilih jenis untuk melihat ID</div>
                    </div>


                    <div class="form-group">
                        <label for="nama_tipe" class="control-label">Nama Tipe Barang</label>
                        <input type="text" class="form-control @error('nama_tipe') is-invalid @enderror" id="nama_tipe" name="nama_tipe" value="{{ old('nama_tipe') }}">
                        @error('nama_tipe')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="image" class="control-label">Upload Gambar</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                        @error('image')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">SIMPAN</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



@endsection

@section('scripttambahan')
<script>
   $(document).ready(function() {
    $('#jenis-input').on('input', function() {
        let selectedValue = $(this).val().toLowerCase().trim();
        
        $('#tbl_tipe tbody tr').each(function() {
            let namaJenis = $(this).find('td:nth-child(3)').text().toLowerCase().trim();
            $(this).toggle(selectedValue === '' || namaJenis.includes(selectedValue));
        });
    });
});
</script>
<script>
    $(document).ready(function() {
        // Function to initialize DataTable
        function initializeDataTable() {
            // Check if DataTable is already initialized
            if ($.fn.dataTable.isDataTable('#tbl_tipe')) {
                $('#tbl_tipe').DataTable().destroy(); // Destroy existing instance
            }

            // Initialize the DataTable
            $("#tbl_tipe").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "paging": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#tbl_tipe_wrapper .col-md-6:eq(0)');
        }

        // Call the DataTable initialization
        initializeDataTable();

        // Button to open the modal
        $('body').on('click', '#btn-create-kelompok', function() {
            $('#modal-create').modal('show'); // Show the modal for adding a new Tipe
        });

        // Handle form submission errors (optional)
        $('#form-tipe').on('submit', function(e) {
            let hasError = false;
            if ($('#nama_tipe').val() === '') {
                hasError = true;
                $('#alert-nama').removeClass('d-none').addClass('d-block').html('Please enter a valid name for Tipe Barang Yayasan.');
            }
            // Add similar checks for other input fields as needed

            if (hasError) {
                e.preventDefault(); // Prevent form submission if there are errors
            }
        });
    });

    // Add this to your existing script section
$(document).ready(function() {
    // Load Kelompok dropdown
    $.ajax({
        url: '/tipe/get-kelompok',
        type: 'GET',
        success: function(data) {
            let dropdown = $('#nama_kelompok');
            dropdown.empty();
            dropdown.append('<option value="">Select Kelompok</option>');
            $.each(data, function(key, value) {
                dropdown.append($('<option></option>')
                    .attr('value', value.nama_kelompok_yayasan)
                    .text(value.nama_kelompok_yayasan));
            });
        }
    });

    // Handle Kelompok change
    $('#nama_kelompok').change(function() {
        let kelompok = $(this).val();
        let jenisDropdown = $('#nama_jenis');
        
        if (kelompok) {
            // Enable and load Jenis dropdown
            jenisDropdown.prop('disabled', false);
            $.ajax({
                url: '/tipe/get-jenis/' + kelompok,
                type: 'GET',
                success: function(data) {
                    jenisDropdown.empty();
                    jenisDropdown.append('<option value="">Select Jenis</option>');
                    $.each(data, function(key, value) {
                        jenisDropdown.append($('<option></option>')
                            .attr('value', value.id_jenis)
                            .text(value.nama_jenis_yayasan));
                    });
                }
            });
        } else {
            // Disable and clear Jenis dropdown
            jenisDropdown.prop('disabled', true);
            jenisDropdown.empty();
            jenisDropdown.append('<option value="">Select Jenis</option>');
        }
    });
    $('#nama_jenis').change(function() {
        let selectedOption = $(this).find(':selected');
        let selectedId = selectedOption.val();
        let selectedName = selectedOption.text();

        // Tampilkan ID di div
        $('#id_jenis').text('ID Jenis: ' + selectedId);

        // Isi hidden input dengan nama_jenis_yayasan
        $('#nama_jenis_yayasan').val(selectedName);
    });
});

    
    // // Handle form submission for creating kelompok
    // $(document).ready(function() {
    //     $('#form-tipe').on('submit', function(e) {
    //         e.preventDefault(); // Prevent the default form submission
    //         $.ajax({
    //             url: $(this).attr('action'), // Get the form action URL
    //             type: 'POST',
    //             data: $(this).serialize(), // Serialize the form data
    //             success: function(response) {
    //                 Swal.fire({
    //                     icon: 'success',
    //                     title: 'Success',
    //                     text: response.message,
    //                 }).then(() => {
    //                     location.reload(); // Reload the page after closing the alert
    //                 });
    //             },
    //             error: function(xhr) {
    //                 let errors = xhr.responseJSON.errors;
    //                 let errorMessage = '';
    //                 $.each(errors, function(key, value) {
    //                     errorMessage += value[0] + '\n'; // Concatenate all error messages
    //                 });
    //                 Swal.fire({
    //                     icon: 'error',
    //                     title: 'Validation Errors',
    //                     text: errorMessage,
    //                 });
    //             }
    //         });
    //     });
    // });
      // Detail button event
      $('body').on('click', '#btn-detail-tipe', function() {
                let kode = $(this).data('di');

                $.ajax({
                    type: "GET",
                    success: function(response) {
                        window.location.href = `/tipe/managetipe/detail/${kode}`;
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