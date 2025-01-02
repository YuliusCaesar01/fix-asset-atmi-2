@extends('layouts.layout_main')
@section('title', 'Data User')
@section('content')

<div class="content-wrapper">
    <div class="container-fluid">
        <div class="content-header">
            <div class="row mb-2">
                <div class="col-6">
                    <h1 class="m-0">Data User</h1>
                </div>
                <div class="col-6">
                    <button class="btn btn-sm btn-info float-right" id="btn-create-user">
                        <i class="fas fa-plus"></i> User
                    </button>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            <h5 class="m-0">User</h5>
                        </div>
                        <div class="col-6">
                            <input type="text" class="form-control form-control-sm float-right" id="search-user" placeholder="Search User">
                        </div>
                    </div>
                </div>
                
                <div class="card-body">
                    <table id="tbl_user" class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama User</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th class="w-1"><i class="fas fa-bars"></i></th>
                            </tr>
                        </thead>
                        <tbody id="user-body">
                            @foreach ($users as $user)
                                @php
                                    $userdetail = $user->userDetail; // Assuming a relationship
                                @endphp
                                <tr id="index_{{ $user->id }}" data-nama="{{ $user->username }}" data-email="{{ $user->email }}" data-role="{{ $user->role }}">
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="nama-user">{{ ucfirst($user->username) }}</td>
                                    <td>{{ ucfirst($user->email) }}</td>
                                    <td>{{ ucfirst($user->getRoleNames()->first()) }}</td>
                                    <td>
                                        @if ($userdetail)
                                            <a href="{{ route('manage-user.userdetails', ['id' => $userdetail->id_userdetail]) }}" 
                                               title="Detail User"
                                               class="btn btn-sm btn-outline-secondary">
                                                <i class="far fa-folder-open"></i> UserDetails
                                            </a>
                                        @else
                                            <form action="{{ route('notifications.send') }}" method="POST" style="margin-left: 0px; display:inline;">
                                                @csrf
                                                <input type="hidden" name="id_user_pengirim" value="{{ auth()->user()->id }}">
                                                <input type="hidden" name="id_user_penerima" value="{{ $user->id }}">
                                                <input type="hidden" name="id_pengajuan" value="null">
                                                <input type="hidden" name="jenis_notif" value="profil"> <!-- Input untuk jenis_notif -->
                                                <input type="hidden" name="keterangan_notif" value="Data Userdetails anda belum terupdate, Mohon untuk mengisi nama lengkap dll terlebih dahulu!">
                                                <button type="submit" class="btn btn-warning btn-sm">
                                                    Kirim Notifikasi
                                                </button>
                                                <small style="font-size: 0.7em;">Userdetail belum terupdate</small>
                                                
                                            </form>
                                        @endif
                                    </td>
                                    
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Nama User</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th><i class="fas fa-bars"></i></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Creating User -->
<div class="modal fade" id="modal-create-user" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Create User</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form id="createUserForm" method="POST" action="{{ route('manage-user.store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="userEmail">Email</label>
                        <input type="email" class="form-control" id="userEmail" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="userPassword">Password</label>
                        <input type="password" class="form-control" id="userPassword" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="userInstansi">Instansi</label>
                        <select class="form-control" id="userInstansi" name="divisi_id" required>
                            <option value="">Select Instansi</option>
                            <option value="4">Politeknik</option>
                            <option value="1">Yayasan</option>
                            <option value="12">SMK Mikael</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="userRole">Role</label>
                        <select class="form-control" id="userRole" name="role_id" required>
                            <option value="">Select Role</option>
                            @foreach(\Spatie\Permission\Models\Role::whereIn('id', [5, 14, 15, 16, 17, 18, 19])->get() as $role)
                                <option value="{{ $role->id }}">{{ ucfirst($role->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="alert alert-danger d-none" id="errorMessage"></div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" form="createUserForm">Save User</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripttambahan')
<script>
    $(document).ready(function() {
        // Open modal
        $('#btn-create-user').click(function() {
            $('#modal-create-user').modal('show');
        });

        // Handle save user
        $('#createUserForm').on('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission
            const formData = $(this).serialize();

            $.ajax({
                type: "POST",
                url: $(this).attr('action'),
                data: formData,
                success: function(response) {
                    $('#modal-create-user').modal('hide');
                    $('#createUserForm')[0].reset();
                    $('#errorMessage').addClass('d-none');

                    // Optionally, refresh the user table or add the new user to the table
                    location.reload(); // or append the new user row to the table
                },
                error: function(xhr) {
                    const errors = xhr.responseJSON.errors;
                    $('#errorMessage').removeClass('d-none').html('');

                    // Display validation errors
                    $.each(errors, function(key, value) {
                        $('#errorMessage').append('<p>' + value[0] + '</p>');
                    });
                }
            });
        });

        // Search user functionality
        $('#search-user').on('keyup', function() {
            const value = $(this).val().toLowerCase();
            $('#user-body tr').filter(function() {
                $(this).toggle($(this).data('nama').toLowerCase().indexOf(value) > -1 || $(this).data('email').toLowerCase().indexOf(value) > -1);
            });
        });
    });
</script>


@endsection
