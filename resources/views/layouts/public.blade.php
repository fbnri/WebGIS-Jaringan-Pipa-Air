<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Monitoring PDAM</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    @stack('styles')
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
    <div class="container">
        
        <span class="navbar-brand">WebGIS PDAM Kota Bandung</span>
        <a href="{{ route('login') }}" class="btn btn-light btn-sm">Login Admin</a>
    </div>
</nav>

<div class="container mt-4">
    @yield('content')
</div>

@stack('scripts')

</body>
</html>