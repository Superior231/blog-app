<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @include('components.style')
</head>

<body>
    
    @include('components.navbar')

    <section class="bg-soft-blue py-4">
        <div class="container">
            @yield('content')
        </div>
    </section>

    @include('components.footer')

    @include('components.script')
</body>

</html>
