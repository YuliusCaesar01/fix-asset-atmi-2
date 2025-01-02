@extends('layouts.layout_main')
@section('title', 'Dashboard')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>User Notification Message</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Notification</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                   <!-- Profile Column -->
                   <div class="col-md-3">
                       <!-- Profile Card -->
                       <div class="card card-primary" style="border: none; border-radius: 8px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);">
                           <div class="card-body text-center">
                               <!-- Profile Image -->
                               <img class="profile-user-img img-fluid img-circle" 
                                    src="{{ auth()->user()->userDetail && auth()->user()->userDetail->foto && auth()->user()->userDetail->foto !== 'default.png' 
                                           ? asset(auth()->user()->userDetail->foto) 
                                           : 'https://as2.ftcdn.net/v2/jpg/00/64/67/27/1000_F_64672736_U5kpdGs9keUll8CRQ3p3YaEv2M6qkVY5.jpg' }}" 
                                    alt="User profile picture" 
                                    loading="lazy" 
                                    style="width: 90px; height: 90px; object-fit: cover; object-position: top; border-radius: 50%; border: none;">

                               <!-- Profile Info -->
                               <h3 class="profile-username" style="margin-top: 10px;">{{ ucfirst(auth()->user()->username) }}</h3>
                               <p class="text-muted" style="margin-bottom: 10px;">Divisi: {{ auth()->user()->Divisi->nama_divisi }}</p>

                               <!-- Edit Button -->
                               <button class="btn btn-icon-edit btn-primary btn-block" 
                                       style="border-radius: 0%; background-color: #007bff; border: none; padding: 10px; cursor: pointer;" 
                                       data-id="{{ Auth::user()->id }}" 
                                       data-name="{{ Auth::user()->username }}" 
                                       title="Edit Profile">
                                   <span style="font-weight: bold;">Edit Profile</span> &nbsp;<i class="fas fa-edit"></i>
                               </button>
                           </div>
                       </div>

                       <!-- About Me Box -->
                       <div class="card" style="margin-top: 15px; border-radius: 8px; border: none;">
                           <div class="card-header" style="background-color: #f8f9fa; border-bottom: none;">
                               <h4 class="card-title" style="text-align: left; margin: 0; font-weight: bold;">About Me</h4>
                           </div>
                           <div class="card-body" style="padding: 15px;">
                               <!-- Full Name -->
                               <div style="margin-bottom: 15px;">
                                   <strong style="font-size: 16px;"><i class="fas fa-user mr-1"></i> Nama Lengkap</strong>
                                   <p class="text-muted" style="margin-top: 5px;">{{ ucfirst(auth()->user()->userDetail->nama_lengkap ?? 'userdetail belum terinput') }}</p>
                               </div>

                               <!-- Email -->
                               <div style="margin-bottom: 15px;">
                                   <strong style="font-size: 16px;"><i class="fas fa-envelope mr-1"></i> Email</strong>
                                   <p class="text-muted" style="margin-top: 5px;">{{ auth()->user()->email }}</p>
                               </div>

                               <!-- Role -->
                               <div style="margin-bottom: 15px;">
                                   <strong style="font-size: 16px;"><i class="fas fa-users mr-1"></i> User Role</strong>
                                   <p class="text-muted" style="margin-top: 5px;">{{ ucfirst(auth()->user()->getRoleNames()->first()) }}</p>
                               </div>

                               <!-- Employee ID -->
                               <div style="margin-bottom: 15px;">
                                   <strong style="font-size: 16px;"><i class="fas fa-id-badge mr-1"></i> No Induk Karyawan</strong>
                                   <p class="text-muted" style="margin-top: 5px;">{{ ucfirst(auth()->user()->userDetail->no_induk_karyawan ?? 'userdetail belum terinput') }}</p>
                               </div>
                           </div>
                       </div>
                   </div>

                   <!-- Notification Column -->
                   <div class="col-md-9">
                       <div class="card">
                           <div class="card-header p-2">
                               <ul class="nav nav-pills">
                                   <li class="nav-item">
                                       <a class="nav-link active" href="#in" data-toggle="tab">Notification Message</a>
                                   </li>
                               </ul>
                           </div>

                           <div class="card-body">
                               <div class="tab-content">
                                   <div class="active tab-pane" id="in">
                                       <div class="form-group">
                                           <p class="text-bold">Today's Notifications</p>
                                           <small>Only notifications from the last 30 days are displayed.</small>
                                           <input type="text" id="search" class="form-control" placeholder="Search notifications" onkeyup="filterNotifications()">
                                       </div>

                                       <!-- Notification Timeline -->
                                       <div class="timeline timeline-inverse" id="notificationTimeline">
                                           @foreach ($notifications->take(5) as $notification) <!-- Display only first 5 notifications -->
                                               <div class="notification-item">
                                                   <span class="bg-danger">{{ $notification->created_at->format('d M. Y') }}</span>
                                               </div>
                                               <div class="notification-item">
                                                   <i class="fas fa-envelope bg-primary"></i>
                                                   <div class="timeline-item">
                                                       <span class="time">
                                                           <i class="far fa-clock"></i> {{ $notification->created_at->format('h:i A') }}
                                                       </span>
                                                       <div class="timeline-header d-flex align-items-center">
                                                           <!-- Sender Profile Picture -->
                                                           <img src="{{ $notification->pengirim->userDetail && $notification->pengirim->userDetail->foto && $notification->pengirim->userDetail->foto !== 'default.png' 
                                                               ? asset($notification->pengirim->userDetail->foto) 
                                                               : 'https://as2.ftcdn.net/v2/jpg/00/64/67/27/1000_F_64672736_U5kpdGs9keUll8CRQ3p3YaEv2M6qkVY5.jpg' }}" 
                                                                alt="Sender Profile" 
                                                                class="img-circle mr-2" 
                                                                style="width: 40px; height: 40px; object-fit: cover; object-position: top;">
                                                           
                                                           <!-- Sender Name in Bold -->
                                                           <h3 class="timeline-header">
                                                               <strong><a href="#">{{ ucfirst($notification->pengirim->username) }}</a></strong> sent you a message
                                                           </h3>
                                                       </div>
                                                       <div class="timeline-body">
                                                           {{ $notification->keterangan_notif }}
                                                       </div>
                                                       <div class="timeline-footer">
                                                          @if($notification->jenis_notif == 'profil')
                                                          <button class="btn btn-icon-edit btn-primary btn-sm" style="border-radius: 0%;" data-id="{{ Auth::user()->id }}" data-name="{{ Auth::user()->username }}" title="Edit">
                                                           <span class="text-bold">Edit Profile</span> &nbsp;<i class="fas fa-edit"></i>
                                                          </button> 
                                                          @else
                                                          <a href="{{ route('managepermintaanfa.index') }}" class="btn btn-primary btn-sm">Check more</a>
                                                         @endif
                                                           <form action="{{ route('notification.destroy', $notification->id) }}" method="POST" style="display: inline-block;">
                                                               @csrf
                                                               @method('DELETE')
                                                               <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus notifikasi ini?')">Delete</button>
                                                           </form>
                                                       </div>
                                                   </div>
                                               </div>
                                           @endforeach

                                           @if ($notifications->count() > 5) <!-- Check if there are more notifications -->
                                               <button id="loadMore" class="btn btn-info" style="margin-top: 10px;" onclick="loadMore()">More</button>
                                           @endif
                                       </div>
                                   </div>
                               </div>
                           </div>
                       </div>
                   </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        let displayedCount = 5;

        function loadMore() {
            displayedCount += 5; // Increase the count by 5
            const notifications = document.querySelectorAll('.notification-item');
            notifications.forEach((notification, index) => {
                if (index < displayedCount) {
                    notification.style.display = 'block'; // Show the next set of notifications
                } else {
                    notification.style.display = 'none'; // Hide the rest
                }
            });

            // Hide the "More" button if all notifications are displayed
            if (displayedCount >= notifications.length) {
                document.getElementById('loadMore').style.display = 'none';
            }
        }

        function filterNotifications() {
            const input = document.getElementById('search').value.toLowerCase();
            const notifications = document.querySelectorAll('.notification-item');

            notifications.forEach((notification) => {
                const content = notification.textContent.toLowerCase();
                notification.style.display = content.includes(input) ? 'block' : 'none';
            });
        }

        // Call loadMore() to initially hide extra notifications
        loadMore();
    </script>
@endsection
