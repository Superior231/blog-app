<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ url('assets/images/logo.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ url('assets/vendors/bootstrap/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ url('assets/vendors/boxicons/css/boxicons.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ url('assets/css/auth.css') }}">
    <title>{{ $title }}</title>

    <!-- PWA  -->
    <meta name="theme-color" content="#f1f5fb"/>
    <link rel="apple-touch-icon" href="{{ asset('assets/images/logo.png') }}">
    <link rel="manifest" href="{{ asset('/manifest.json') }}">

    @include('components.meta')
</head>

<body>
    <div class="d-flex justify-content-end">
        @include('components.toast')
    </div>
    <div class="px-0 mx-0 d-flex justify-content-center w-100">
        @yield('content')
    </div>

    <script src="{{ url('assets/vendors/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ url('assets/js/auth.js') }}"></script>
    @stack('scripts')
</body>

</html>
