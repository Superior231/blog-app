<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @include('components.style')
</head>

<body>
    @include('components.navbar')

    @yield('content')

    @include('components.footer')

    @include('components.script')
</body>

</html>
