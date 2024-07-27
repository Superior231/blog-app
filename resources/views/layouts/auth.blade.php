<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ url('assets/images/logo.png') }}" type="image/x-icon">
    <title>Login</title>

    <link rel="stylesheet" href="{{ url('assets/vendors/bootstrap/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ url('assets/vendors/boxicons/css/boxicons.min.css') }}">
    <link rel="stylesheet" href="{{ url('assets/css/style.css') }}">
</head>

<body class="bg-soft-blue">

    <div class="container">
        <div class="row align-items-center justify-content-center py-5" style="min-height: 100vh">
            <div class="col-md-5">
                @include('components.toast')
                <div class="card">
                    <div class="card-body p-4 p-lg-5">
                        <a href="." class="logo mb-4">
                            <img src="{{ url('assets/images/logo.png') }}" alt="Logo">
                            <span>Blog App</span>
                        </a>

                        @yield('content')

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ url('assets/vendors/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    @stack('scripts')
</body>

</html>
