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
    @yield('content')

    <div class="back-to-top">
        <a class="icon-back-to-top" href="#"><i class='bx bxs-chevron-up fs-2'></i></a>
    </div>

    @include('components.footer')
    @include('components.script')

    @auth
        @if (!auth()->user()->hasVerifiedEmail())
            <script>
                function showUnverifiedAlert() {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Verification Required',
                        text: 'Your email address is not verified yet. Please verify your email to access all features.',
                        showCancelButton: true,
                        confirmButtonText: 'Verify Now',
                        cancelButtonText: 'Cancel',
                        customClass: {
                            popup: 'sw-popup',
                            title: 'sw-title',
                            htmlContainer: 'sw-text',
                            closeButton: 'sw-close',
                            icon: 'border-warning text-warning',
                            confirmButton: 'btn-primary',
                        },
                        reverseButtons: true,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "{{ route('verification.notice') }}";
                        }
                    });
                }
            </script>
        @endif
    @endauth
</body>

</html>
