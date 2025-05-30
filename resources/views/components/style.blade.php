<link rel="shortcut icon" href="{{ url('assets/images/logo.png') }}" type="image/x-icon">
<link rel="stylesheet" href="{{ url('assets/vendors/bootstrap/css/bootstrap.css') }}">
<link rel="stylesheet" href="{{ url('assets/vendors/boxicons/css/boxicons.min.css') }}">
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="{{ url('assets/css/style.css') }}">

<!-- PWA  -->
<meta name="theme-color" content="#f1f5fb"/>
<link rel="apple-touch-icon" href="{{ asset('assets/images/logo.png') }}">
<link rel="manifest" href="{{ asset('/manifest.json') }}">

@stack('styles')

<title>{{ $title }}</title>