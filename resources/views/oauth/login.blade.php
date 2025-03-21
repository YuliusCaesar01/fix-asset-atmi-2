@extends('layouts.layout_auth')
@section('title', 'Login')

@section('content')
<style>
    body {
        position: relative;
        height: 100vh;
        overflow: hidden;
    }
    
    body::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: url("{{ asset('atmisolo.png') }}");
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        background-attachment: fixed;
        filter: blur(5px); /* Adds blur to the background image */
        z-index: -1;
    }
    
    .login-box {
        margin-top: 20px;
        position: relative;
        z-index: 1;
    }
    
    .card {
        background-color: rgba(255, 255, 255, 0.756); /* Semi-transparent white background */
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
    }
    
    .login-card-body {
        background-color: transparent;
    }
    
    .navbar-brand-image {
        filter: drop-shadow(0px 0px 5px rgba(255, 255, 255, 0.7));
    }
</style>
    <div class="login-box">
        <div class="card">
            <div class="card-body card-primary login-card-body">
                <div class="login-logo">
                    <a href="#">
                        <img src="{{ asset('logologin.png') }}" width="250" alt="Logo" class="navbar-brand-image">
                    </a>
                </div>
                <h2 class="text-center mb-4">ACCOUNT LOGIN</h2>
                
                @if (session('success'))
                    <div class="alert alert-primary">{{ session('success') }}</div>
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

                <form method="POST" action="{{ url('auth/login') }}">
                    @csrf
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <div class="input-group mb-3">
                            <input type="email" id="email" class="form-control" placeholder="Enter your email" name="email" required autocomplete="off">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group mb-3">
                            <input type="password" id="password" class="form-control" placeholder="Enter your password" name="password" required>
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-sign-in-alt mr-2"></i> Sign In
                        </button>
                    </div>
                </form>

                <hr>

                {{-- <div class="social-auth-links text-center mb-3">
                    <p>- OR -</p>
                    <form action="{{ route('oauth.google') }}" method="GET">
                        <button type="submit" class="btn btn-google btn-block">
                            <i class="fab fa-google mr-2"></i> Login with Google
                        </button>
                    </form>
                </div> --}}

                <div class="text-center">
                    <p class="mb-1">
                        <button type="button" class="btn btn-link" data-toggle="modal" data-target="#forgotPasswordModal">
                            Forgot Password?
                        </button>
                                        </p>
                </div>
            </div>
        </div>
    </div>



    <!-- Modal for Forgot Password -->
<div class="modal fade" id="forgotPasswordModal" tabindex="-1" role="dialog" aria-labelledby="forgotPasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="forgotPasswordModalLabel">Reset Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('password') }}">
                    @csrf
                    <div class="form-group">
                        <label for="resetEmail">Email</label>
                        <input type="email" id="resetEmail" class="form-control" name="email" placeholder="Enter your email" required>
                        
                        <!-- Cek apakah ada error untuk email -->
                        @error('email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Send Password Reset Link</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
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
    $(document).ready(function() {
    @if ($errors->any())
        $('#forgotPasswordModal').modal('show'); // Membuka kembali modal jika ada error
    @endif
});
</script>
<script>
    $(document).ready(function() {
        $('form').on('submit', function(e) {
            var $form = $(this);
            var $submitBtn = $form.find('button[type="submit"]');

            // Disable the submit button after it's clicked
            $submitBtn.prop('disabled', true);
        });

        // Membuka kembali modal jika ada error
        @if ($errors->any())
            $('#forgotPasswordModal').modal('show');
        @endif
    });
</script>



@endsection
