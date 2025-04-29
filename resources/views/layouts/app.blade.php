@php
use Illuminate\Support\Facades\Session;
@endphp
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>GST Billing Application</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand" href="{{ route('invoices.index') }}">GST Billing</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto">
          @if(Session::has('user_authenticated') && Session::get('user_authenticated') === true)
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('invoices.*') ? 'active' : '' }}" href="{{ route('invoices.index') }}">Invoices</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('customers.*') ? 'active' : '' }}" href="{{ route('customers.index') }}">Customers</a>
          </li>
          @endif
        </ul>
        
        @if(Session::has('user_authenticated') && Session::get('user_authenticated') === true)
        <div class="navbar-nav ms-auto">
          <span class="nav-item nav-link text-light me-3">Welcome, {{ Session::get('username') }}</span>
          <a href="{{ route('logout') }}" class="btn btn-outline-light btn-sm">Logout</a>
        </div>
        @endif
      </div>
    </div>
  </nav>

  <div class="container mt-4">
    @yield('content')
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
