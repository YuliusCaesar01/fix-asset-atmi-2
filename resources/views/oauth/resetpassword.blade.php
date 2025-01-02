@extends('layouts.layout_auth')
@section('title', 'Reset Password')

@section('content')
@php
use App\Models\User;
$userdata = User::where('remember_token', $token)->first();
@endphp

<script>
    // Redirect ke route login jika userdata null
    @if (!$userdata)
        // Gunakan SweetAlert2 untuk notifikasi
        Swal.fire({
            title: 'Invalid Token!',
            text: 'Please request a new password reset link.',
            icon: 'error',
            confirmButtonText: 'Back to Login'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "{{ route('login') }}";
            }
        });
    @endif
</script>

<div class="login-box">
    <div class="login-logo">
        <a href="#">
            <img src="{{ asset('fixaset.png') }}" width="200" alt="Logo" class="navbar-brand-image">
        </a>
    </div>
    
    <div class="card">
        <div class="card-body card-primary login-card-body">
            <h2 class="text-center mb-4">Reset Your Password</h2>
            
            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" class="form-control" placeholder="Enter your email" value="{{ $userdata ? $userdata->email : '' }}" name="email" required autocomplete="off" disabled>
            
            <form method="POST" action="{{ url('password/reset') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="form-group">
                    <label for="password" class="form-label">New Password</label>
                    <div class="input-group mb-3">
                        <input type="password" id="password" class="form-control" placeholder="Enter your new password" name="password" required>
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <div class="input-group mb-3">
                        <input type="password" id="password_confirmation" class="form-control" placeholder="Confirm your new password" name="password_confirmation" required>
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        </div>
                    </div>
                </div>

                <div class="form-group mb-4">
                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fas fa-sign-in-alt mr-2"></i> Reset Password
                    </button>
                </div>
            </form>

            <div class="text-center">
                <p class="mb-1">
                    <a href="{{ route('login') }}" class="btn btn-link">Back to Login</a>
                </p>
            </div>
        </div>
    </div>
</div>

@endsection


