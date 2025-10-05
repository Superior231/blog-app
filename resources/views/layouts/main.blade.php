<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @include('components.meta')
    @include('components.style')
</head>

<body>
    @include('components.navbar')
    @include('components.toast')

    <section class="bg-soft-blue py-0 my-0">
        <div class="container py-0 my-0">
            @yield('content')
        </div>
    </section>

    <div class="back-to-top">
        <a class="icon-back-to-top" href="#"><i class='bx bxs-chevron-up fs-2'></i></a>
    </div>

    @include('components.footer')

    @include('components.script')
</body>

</html>
