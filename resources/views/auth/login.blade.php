@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-md-5">
            <div class="text-center mb-4">
                <h1 class="display-4 text-primary fw-bold">SUMANA SAREEES</h1>
                <p class="lead text-muted">GST Billing System</p>
            </div>
            
            <div class="card shadow-lg border-0 rounded-lg">
                <div class="card-body p-5">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login.submit') }}" class="needs-validation" novalidate>
                        @csrf
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control form-control-lg" id="username" name="username" value="{{ old('username') }}" required autofocus placeholder="Username">
                            <label for="username">Username</label>
                        </div>

                        <div class="form-floating mb-4">
                            <input type="password" class="form-control form-control-lg" id="password" name="password" required placeholder="Password">
                            <label for="password">Password</label>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-sign-in-alt me-2"></i>Login
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="text-center mt-4">
                <p class="text-muted">Bhanugudi, Kakinada - 533003</p>
                <p class="text-muted">Andhra Pradesh, India</p>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    backdrop-filter: blur(10px);
    background-color: rgba(255, 255, 255, 0.9);
}

.form-control:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

.btn-primary {
    background: linear-gradient(45deg, #0d6efd, #0a58ca);
    border: none;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    background: linear-gradient(45deg, #0a58ca, #084298);
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.display-4 {
    background: linear-gradient(45deg, #0d6efd, #0a58ca);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    margin-bottom: 0.5rem;
}

.lead {
    font-size: 1.1rem;
    color: #6c757d;
}

.form-floating > .form-control {
    padding: 1rem 0.75rem;
}

.form-floating > label {
    padding: 1rem 0.75rem;
}
</style>
@endsection 