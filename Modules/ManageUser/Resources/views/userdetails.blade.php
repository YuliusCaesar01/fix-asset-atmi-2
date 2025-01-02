@extends('layouts.layout_main')
@section('title', 'Data Detail User')
@section('content')
<style>
    #changeEmail {
    display: none; /* Initially hidden */
}

    .swal2-toast {
        font-size: 12px; /* Adjust font size */
        padding: 10px; /* Adjust padding */
        width: 200px; /* Set width for the toast */
    }


    </style>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">DETAIL DATA USER</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('manageruang.index') }}">Home</a></li>
                        <li class="breadcrumb-item">Users</li>
                        <li class="breadcrumb-item active">User Details</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    
    <section class="content">
        <div class="container-fluid">
            <div class="content-header">
                <div class="row mb-2">
                    <div class="col-sm-6 text-center">
                        <h4 class="text-purple lead">
                            ID User: {{ str_pad($userdetailed->id_userdetail, 2, '0', STR_PAD_LEFT) }}
                        </h4>
                    </div>
                    <div class="col-sm-6">
                        <div class="float-right">
                            <a href="javascript:void(0)" id="btn-edit-user" title="Ubah user" class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#editModaled">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            @if(auth()->user()->role_id == 19)
                                <form id="delete-user-form-{{ $userdetailed->user->id }}" action="{{ route('delete.user', $userdetailed->user->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                <a href="javascript:void(0)" id="btn-delete-user" title="Hapus user" class="btn btn-sm btn-danger ml-2" onclick="confirmDelete({{ $userdetailed->user->id }})">
                                    <i class="fas fa-trash"></i>
                                </a>
                            @endif

                            
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-sm" id="tbl_lokasi">
                        <thead>
                            <tr>
                                <th>Foto</th>
                                <th>Nama Lengkap</th>
                                <th>Jenis Kelamin</th>
                                <th>No Induk Karyawan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center lead" style="vertical-align: middle;">
                                    @if($userdetailed->foto && $userdetailed->foto !== 'default.png')
                                    <img src="{{ asset($userdetailed->foto) }}" alt="Profile Photo" class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover; border-radius: 50%; object-position: top;">
                                    @else
                                        <img src="https://as2.ftcdn.net/v2/jpg/00/64/67/27/1000_F_64672736_U5kpdGs9keUll8CRQ3p3YaEv2M6qkVY5.jpg" alt="Profile Photo" class="rounded-circle" style="width: 80px; height: 80px;">
                                    @endif
                                </td>
                                <td class="text-left" style="vertical-align: middle;">{{ $userdetailed->nama_lengkap }}</td>
                                <td class="text-left" style="vertical-align: middle;">{{ $userdetailed->jenis_kelamin }}</td>
                                <td class="text-left" style="vertical-align: middle;">{{ $userdetailed->no_induk_karyawan }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>



<!-- Edit User Details Modal -->
<div class="modal fade" id="editModaled" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Edit User Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <!-- User Details Form -->
                <form id="userDetailsForm" method="POST" action="{{ route('editprofil', $userdetailed->id_userdetail ?? '') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $userdetailed->id_userdetail ?? '' }}">

                    <div class="form-group">
                        <label for="nama_lengkap">Full Name</label>
                        <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="{{ $userdetailed->nama_lengkap ?? '' }}" required>
                    </div>

                    <div class="form-group">
                        <label for="jenis_kelamin">Gender</label>
                        <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                            <option value="" disabled selected>Select Gender</option>
                            <option value="laki-laki" {{ ($userdetailed->jenis_kelamin ?? '') == 'laki-laki' ? 'selected' : '' }}>Male</option>
                            <option value="perempuan" {{ ($userdetailed->jenis_kelamin ?? '') == 'perempuan' ? 'selected' : '' }}>Female</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="no_induk_karyawan">Employee ID</label>
                        <input type="text" class="form-control" id="no_induk_karyawan" name="no_induk_karyawan" value="{{ $userdetailed->no_induk_karyawan ?? '' }}" required>
                    </div>

                    <button type="button" class="btn btn-warning btn-block" id="showChangeEmailForm">Edit User Data</button>
                </form>

                <!-- Change Email Form -->
                <form id="changeEmail" method="POST" action="{{ route('change.email') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $userdetailed->user->id }}">
                    <div class="form-group">
                        <label for="old_email">Old Email</label>
                        <input type="email" class="form-control" id="old_email" name="old_email" value="{{ Auth::user()->email }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="new_email">New Email</label>
                        <input type="email" class="form-control" id="new_email" name="new_email" required>
                    </div>
                    <div class="form-group">
                        <label for="ttd">Upload Signature</label>
                        <input type="file" class="form-control-file" id="ttd" name="ttd" accept="image/*" required>
                        <small>Upload your signature. Background will be automatically removed if white.</small>
                    </div>

                    <button type="button" class="btn btn-info btn-block" id="showUserDetailsForm">Back to User Details</button>
                </form>

            </div>
            <div class="modal-footer">
                <button type="submit" form="userDetailsForm" class="btn btn-primary">Save Changes</button>
                <button type="submit" form="changeEmail" class="btn btn-primary" style="display: none;">Update Email</button>
            </div>
            
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('showChangeEmailForm').addEventListener('click', function() {
        document.getElementById('userDetailsForm').style.display = 'none'; // Hide user details form
        document.getElementById('changeEmail').style.display = 'block'; // Show email change form
        document.querySelector('button[form="userDetailsForm"]').style.display = 'none';
        document.querySelector('button[form="changeEmail"]').style.display = 'block'; // Correct form ID

        // Show toast notification
        Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: 'Switched to Email Change Form (GOOD DANIEL)',
            showConfirmButton: false,
            timer: 250 // Duration in milliseconds
        });
    });

    document.getElementById('showUserDetailsForm').addEventListener('click', function() {
        document.getElementById('changeEmail').style.display = 'none'; // Hide email change form
        document.getElementById('userDetailsForm').style.display = 'block'; // Show user details form
        document.querySelector('button[form="changeEmail"]').style.display = 'none'; // Correct form ID
        document.querySelector('button[form="userDetailsForm"]').style.display = 'block';

        // Show toast notification
        Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: 'Switched to User Details Form (GOOD DANIEL)',
            showConfirmButton: false,
            timer: 250 // Duration in milliseconds
        });
    });
});


function confirmDelete(userId) {
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
            // Submit the form to delete the user
            document.getElementById('delete-user-form-' + userId).submit();
            
            // Show success message
            Swal.fire(
                'Deleted!',
                'The user has been deleted.',
                'success'
            );
        }
    });
}



</script>

    
</div>
@endsection
