@php
use App\Models\PermintaanNonFixedAsset;
use App\Models\Userdetail;
use App\Models\Notification;

use Illuminate\Support\Facades\Auth;

$role = Auth::user()->getRoleNames()->first(); // Assuming the user has only one role

$userdetail = Userdetail::where('id_user', Auth::id())->first();

$unreadCount = Notification::where('id_user_penerima', auth()->user()->id)
                                ->where('read_at', null) // Assuming you have a read_at column
                                ->count();

@endphp
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
  <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
     </li>
     <li class="nav-item d-none d-sm-inline-block">
        <a href="index3.html" class="nav-link">Home</a>
     </li>
     <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ route('guides.index') }}" class="nav-link">Contact</a>
    </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item icon-button">
            
            <div class="navbar-search-block">
                <form class="form-inline">
                    <div class="input-group input-group-sm">
                        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-navbar" type="submit"><i class="fas fa-search"></i></button>
                            <li class="nav-item icon-button">
                                <a class="nav-link material-icons {{ $menu == 'notifprofile' ? 'active' : '' }}" 
                                   onclick="removeSpan()" 
                                   data-widget="notif" 
                                   href="{{ route('notifprofile') }}" 
                                   role="button" 
                                   style="position: relative;">
                                    <i class="fas fa-bell"></i>
                              <span class="notification-count" 
                                    id="notificationCount" 
                                    style="position: absolute; top: -2px; right: -8px; background-color: red; color: white; border-radius: 50%; padding: 0px 5px; font-size: 10px; display: {{ $unreadCount > 0 ? 'inline' : 'none' }};">
                              </span>
                              
                                </a>
                            </li>
                            
                            <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </li>
        <li class="nav-item icon-button">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
        <span id="notificationCount" style="display: none;">0</span>
        <li class="nav-item icon-button">
            <a class="nav-link material-icons {{ $menu == 'notifprofile' ? 'active' : '' }}" 
               onclick="removeSpan()" 
               data-widget="notif" 
               href="{{ route('notifprofile') }}" 
               role="button" 
               style="position: relative;">
                <i class="fas fa-bell"></i>
                <span class="notification-count" 
                id="notificationCount" 
                style="position: absolute; top: -2px; right: -8px; background-color: red; color: white; border-radius: 50%; padding: 0px 5px; font-size: 10px; display: {{ $unreadCount > 0 ? 'inline' : 'none' }};">
              {{ $unreadCount }}
          </span>
          
            </a>
        </li>
        
        <li class="nav-item icon-button">
            <a class="nav-link" href="{{ route('logout') }}" role="button">
                <i class="fas fa-sign-out-alt"></i>
            </a>
        </li>
    </ul>
</nav>

<aside class="main-sidebar sidebar-light-lightblue elevation-4">
    <a href="{{ route('dashboard') }}" class="brand-link">
        <img src="{{ asset('LogoFixaset.png') }}" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Fixed<b>Asset</b>&nbsp;<span style="font-weight: 500;">YKBS</span>

        </span>
    </a>

    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img id="profile-img" src="{{ $userdetail && $userdetail->foto && $userdetail->foto !== 'default.png' ? asset($userdetail->foto) : 'https://as2.ftcdn.net/v2/jpg/00/64/67/27/1000_F_64672736_U5kpdGs9keUll8CRQ3p3YaEv2M6qkVY5.jpg' }}" alt="User Image" class="profile-img" width="250" height="250" style="object-fit: cover; border-radius: 50%;">
            </div>
            <div class="info">
                <p>{{ strtoupper(Auth::user()->username) }}</p>
            </div>
        </div>

        <div id="profile-view" style="display: none;">
            <div class="profile-header">
                <button id="back-to-navbar" class="btn-icon btn-icon-primary" title="Back">
                    <i class="fas fa-arrow-left"></i>
                </button>
            </div>
            <div class="profile-info">
                <img src="{{ $userdetail && $userdetail->foto && $userdetail->foto !== 'default.png' ? asset($userdetail->foto) : 'https://as2.ftcdn.net/v2/jpg/00/64/67/27/1000_F_64672736_U5kpdGs9keUll8CRQ3p3YaEv2M6qkVY5.jpg' }}" alt="User Image" class="profile-img">
                <div class="profile-details">
                    <h3>{{ strtoupper(Auth::user()->username) }}</h3>
                    <p>Email: {{ Auth::user()->email }}</p>
                    <button class="btn-icon btn-icon-edit" data-id="{{ Auth::user()->id }}" data-name="{{ Auth::user()->username }}" title="Edit">
                        <i class="fas fa-edit"></i>
                    </button>
                </div>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item {{ $menu == 'Dashboard' || $menu == 'ManualBook' ? 'menu-open' : '' }}">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ $menu == 'Dashboard' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('guides.index') }}" class="nav-link {{ $menu == 'ManualBook' ? 'active' : '' }}">
                                <i class="nav-icon fas fa-book"></i>
                                <p>Manual Book</p>
                            </a>
                        </li>
                        
                    </ul>
                </li>
                
                <li class="nav-header">FIXED ASSET</li>

                <li class="nav-item has-treeview {{ $menu == 'Aset' || $menu == 'Tambah Aset' ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ $menu == 'Aset' || $menu == 'Tambah Aset' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-folder"></i>
                        <p>
                            Data Fixed Aset
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('manageaset.index') }}" class="nav-link {{ $menu == 'Aset' ? 'active' : '' }}">
                                <i class="fas fa-cubes nav-icon"></i>
                                <p>Fix Aset</p>
                            </a>
                        </li>
                        @if(auth()->user()->role_id == 19 || auth()->user()->role_id == 1)

                        <li class="nav-item">
                            <a href="{{ route('manageaset.create') }}" class="nav-link {{ $menu == 'Tambah Aset' ? 'active' : '' }}">
                                <i class="fas fa-plus nav-icon"></i>
                                <p>Tambah Aset</p>
                            </a>
                        </li>
                        @endif

                    </ul>
                </li>

                <li class="nav-item has-treeview {{ $menu == 'PermintaanFA' || $menu == 'ApprovalAset' ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ $menu == 'PermintaanFA' || $menu == 'ApprovalAset' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-folder"></i>
                        <p>
                            Permintaan Fix Aset
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('managepermintaanfa.index') }}" class="nav-link {{ $menu == 'PermintaanFA' ? 'active' : '' }}">
                                <i class="far fa-life-ring nav-icon"></i>
                                <p>Permintaan Aset</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-header">KATEGORI</li>
                <li class="nav-item">
                    <a href="{{ route('manageinstitusi.index') }}" class="nav-link {{ $menu == 'Institusi' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-building"></i>
                        <p>Institusi</p>
                    </a>
                </li>

                <li class="nav-item menu-is-opening {{ $menu == 'Tipe' ? 'menu-open' : '' }}">
                    <a id="daftar" href="#" class="nav-link {{ in_array($menu, ['Tipe', 'Kelompok', 'Jenis', 'Lokasi', 'Ruang']) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>
                            Daftar Kode Aset Tetap
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('manage-tipe.index') }}" class="nav-link {{ $menu == 'Tipe' ? 'active' : '' }}">
                                <i class="fas fa-th-large nav-icon"></i>
                                <p>Tipe</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('manage-kelompok.index') }}" class="nav-link {{ $menu == 'Kelompok' ? 'active' : '' }}">
                                <i class="fas fa-cube  nav-icon" ></i>
                                <p>Kelompok</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('manage-jenis.index') }}" class="nav-link {{ $menu == 'Jenis' ? 'active' : '' }}">
                                <i class="fas fa-tags nav-icon"></i>
                                <p>Jenis</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('manage-lokasi.index') }}" class="nav-link {{ $menu == 'Lokasi' ? 'active' : '' }}">
                                <i class="fas fa-map-marker-alt nav-icon"></i>
                                <p>Lokasi</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('manage-ruang.index') }}" class="nav-link {{ $menu == 'Ruang' ? 'active' : '' }}">
                                <i class="fas fa-building nav-icon"></i>
                                <p>Ruang</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @if(auth()->user()->role_id == 19 || auth()->user()->role_id == 1)

                <li class="nav-item">
                    <a href="{{ route('manage-user.index', ['type' => 'fixaset']) }}" 
                       class="nav-link {{ $menu == 'fixasetuser' ? 'active' : '' }}" 
                       aria-label="Manage Users">
                        <i class="nav-icon fas fa-users" style="font-size: 1.2rem;"></i> <!-- Ganti ikon -->
                        <p class="ml-2">Users</p>
                    </a>
                </li>
                @endif
                
            </ul>
        </nav>
    </div>
</aside>
<!-- Edit User Details and Change Password Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit User Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @php $null = 0; @endphp

                <!-- User Details Form -->
                <form id="editDetailsForm" method="POST" action="{{ route('editprofil', $userdetail->id_userdetail ?? $null) }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{ $userdetail->id_userdetail ?? '' }}">
                    
                    <!-- Display existing photo -->
                    <div class="form-group text-center mb-4">
                        <center>
                        <img src="{{ $userdetail && $userdetail->foto && $userdetail->foto !== 'default.png' ? asset($userdetail->foto) : 'https://as2.ftcdn.net/v2/jpg/00/64/67/27/1000_F_64672736_U5kpdGs9keUll8CRQ3p3YaEv2M6qkVY5.jpg' }}" alt="User Image" class="profile-img" style="border-radius: 50%; width: 100px; height: 100px; object-fit: cover;">
                        </center>
                        <small class="d-block mt-2">Current Profile Photo</small>
                    </div>

                    <!-- Change Profile Photo Input -->
                    <div class="form-group">
                        <label for="foto" class="font-weight-bold">Change Profile Photo</label>
                        <input type="file" class="form-control-file" id="foto" name="foto" accept="image/*">
                    </div>

                    <!-- User Details Fields -->
                    <div class="form-group">
                        <label for="nama_lengkap" class="font-weight-bold">Nama Lengkap</label>
                        <input type="text" class="form-control" id="nama_lengkap" value="{{ $userdetail->nama_lengkap ?? 'belum ditambahkan' }}" name="nama_lengkap" required>
                    </div>
                    <div class="form-group">
                        <label for="jenis_kelamin" class="font-weight-bold">Jenis Kelamin</label>
                        <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required aria-label="Pilih Jenis Kelamin">
                            <option value="" disabled selected>Pilih Jenis Kelamin</option>
                            <option value="laki-laki">Laki-laki</option>
                            <option value="perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="no_induk_karyawan" class="font-weight-bold">No Induk Karyawan</label>
                        <input type="text" class="form-control" value="{{ $userdetail->no_induk_karyawan ?? 'belum ditambahkan' }}" id="no_induk_karyawan" name="no_induk_karyawan" required>
                    </div>

                    <!-- Change Password Button -->
                    <button type="button" class="btn btn-primary btn-block show-form" data-target="changePasswordForm">
                        <i class="fas fa-key"></i> Change Password
                    </button>

                    <!-- Change User Data Button -->
                    <button type="button" class="btn btn-warning btn-block show-form" data-target="changeEmailForm">
                        <i class="fas fa-user"></i> Change User Data
                    </button>
                </form>

                <!-- Change Password Form -->
                <form id="changePasswordForm" method="POST" action="{{ route('profile.change-password') }}" style="display: none;">
                    @csrf
                    <input type="hidden" name="user_id" id="user_id" value="{{ Auth::id() }}">
                    <div class="form-group">
                        <label for="old_password" class="font-weight-bold">Old Password</label>
                        <input type="password" class="form-control" id="old_password" name="old_password" required>
                    </div>
                    <div class="form-group">
                        <label for="new_password" class="font-weight-bold">New Password</label>
                        <input type="password" class="form-control" id="new_password" name="new_password" required>
                    </div>
                    <div class="form-group">
                        <label for="new_password_confirmation" class="font-weight-bold">Confirm New Password</label>
                        <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
                    </div>
                    <!-- Edit User Details Button -->
                    <button type="button" class="btn btn-info btn-block show-form" data-target="editDetailsForm">
                        <i class="fas fa-id-badge"></i> Edit User Details
                    </button>
                </form>

                <!-- Change Email Form -->
                <form id="changeEmailForm" method="POST" action="{{ route('change.email') }}" style="display: none;" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="user_id" id="user_id" value="{{ Auth::id() }}">
                    <div class="form-group">
                        <label for="old_email" class="font-weight-bold">Old Email</label>
                        <input type="email" class="form-control" id="old_email" name="old_email" value="{{ Auth::user()->email }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="new_email" class="font-weight-bold">New Email</label>
                        <input type="email" class="form-control" id="new_email" name="new_email" required>
                    </div>
                    <div class="form-group">
                        <label for="ttd" class="font-weight-bold">Upload TTD</label>
                        <input type="file" class="form-control-file" id="ttd" name="ttd" accept="image/*">
                        <small>Upload your signature. Background will be automatically removed if white.</small>
                    </div>
                    <!-- Edit User Details Button -->
                    <button type="button" class="btn btn-info btn-block show-form" data-target="editDetailsForm">
                        <i class="fas fa-id-badge"></i> Edit User Details
                    </button>
                    <!-- Edit Password Button -->
                    <button type="button" class="btn btn-primary btn-block show-form" data-target="changePasswordForm">
                        <i class="fas fa-key"></i> Change Password
                    </button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" id="gantiprofil" form="editDetailsForm" class="btn btn-primary" style="display: none;">Save User Details</button>
                <button type="submit" id="gantipassword" form="changePasswordForm" class="btn btn-primary" style="display: none;">Change Password</button>
                <button type="submit" id="gantiemail" form="changeEmailForm" class="btn btn-primary" style="display: none;">Change UserData</button>
            </div>
        </div>
    </div>
</div>


@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<script>
   document.addEventListener('DOMContentLoaded', function () {
    // Ensure jQuery is loaded before using it
    if (typeof $ === 'undefined') {
        console.error('jQuery is not loaded');
        return;
    }

    // Set initial state of buttons and forms
    document.getElementById('gantipassword').style.display = 'none';
    document.getElementById('gantiprofil').style.display = 'block';
    document.getElementById('gantiemail').style.display = 'none';
    document.getElementById('changePasswordForm').style.display = 'none';
    document.getElementById('changeEmailForm').style.display = 'none';
    document.getElementById('editDetailsForm').style.display = 'block';
    document.querySelector('.form-group.text-center').style.display = 'block';

    // Open the edit modal when the edit button is clicked
    document.querySelectorAll('.btn-icon-edit').forEach(button => {
        button.addEventListener('click', function () {
            // Retrieve necessary data from the clicked button if needed
            // const itemId = this.dataset.id;
            // const itemName = this.dataset.name;
            // Update any modal input fields with item data here if needed

            // Show the modal
            $('#editModal').modal('show');
        });
    });
    document.querySelectorAll('.close-modal, .close').forEach(function (button) {
        button.addEventListener('click', function () {
            $('#editModal').modal('hide');
        });
    });
    // Toggle forms based on the clicked link
    document.querySelectorAll('.show-form').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const targetFormId = btn.getAttribute('data-target');
            document.querySelectorAll('form').forEach(function (form) {
                form.style.display = 'none';
            });
            document.getElementById(targetFormId).style.display = 'block';
            
            // Hide/Show buttons based on form
            document.getElementById('gantiprofil').style.display = (targetFormId === 'editDetailsForm') ? 'block' : 'none';
            document.getElementById('gantipassword').style.display = (targetFormId === 'changePasswordForm') ? 'block' : 'none';
            document.getElementById('gantiemail').style.display = (targetFormId === 'changeEmailForm') ? 'block' : 'none';

            // Hide profile photo form-group on email/password form
            document.querySelector('.form-group.text-center').style.display = (targetFormId === 'editDetailsForm') ? 'block' : 'none';
        });
    });

    // When the modal is shown, ensure the correct initial state
    $('#editModal').on('show.bs.modal', function () {
        document.getElementById('gantipassword').style.display = 'none';
        document.getElementById('gantiprofil').style.display = 'block';
        document.getElementById('gantiemail').style.display = 'none';
        document.getElementById('changePasswordForm').style.display = 'none';
        document.getElementById('changeEmailForm').style.display = 'none';
        document.getElementById('editDetailsForm').style.display = 'block';
        document.querySelector('.form-group.text-center').style.display = 'block';
    });
});

    
      
        document.querySelectorAll('.nav-item').forEach(item => {
    const dropdown = item.querySelector('.nav-treeview');
    const arrowIcon = item.querySelector('.nav-link .right');

    item.addEventListener('click', (event) => {
        // Prevents the click from bubbling up to parent elements
        event.stopPropagation();

        if (dropdown) {
            const isOpen = dropdown.style.display === 'block';
            dropdown.style.display = isOpen ? 'none' : 'block';
            if (arrowIcon) {
                arrowIcon.classList.toggle('active', !isOpen);
            }
        }
    });
});

    
document.addEventListener('DOMContentLoaded', function () {
    const profileImg = document.getElementById('profile-img');
    const profileView = document.getElementById('profile-view');
    const sidebar = document.querySelector('.main-sidebar');
    const backToNavbarButton = document.getElementById('back-to-navbar');

    if (profileImg && profileView && sidebar && backToNavbarButton) {
        // Handle profile image click
        profileImg.addEventListener('click', function () {
            profileView.style.display = 'block';
            sidebar.classList.add('hidden-sidebar'); // Hide sidebar
        });

        // Handle back to navbar click
        backToNavbarButton.addEventListener('click', function () {
            profileView.style.display = 'none';
            sidebar.classList.remove('hidden-sidebar'); // Show sidebar again
        });
    } else {
        console.error('Elements not found in the DOM.');
    }
});

    
      
    
       
    </script>




    