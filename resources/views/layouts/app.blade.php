<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Global Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"> <!-- compiled app CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <!-- Page-specific Styles -->
    @yield('styles')
</head>
<body>
    <!-- Header -->
    @include('layouts.header')

    <!-- Navbar -->
    @include('layouts.navbar')

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2">
                @include('layouts.sidebar')
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10">
                <main>
                    @yield('content')
                </main>
            </div>
        </div>
    </div>

    <!-- Global Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script> <!-- compiled app JS -->

    <!-- Page-specific Scripts -->
    @yield('scripts')
</body>
</html>
