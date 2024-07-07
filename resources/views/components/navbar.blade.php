<nav class="navbar navbar-expand-lg py-4 bg-soft-blue">
    <div class="container">
        <a href="" class="logo">
            <img src="{{ url('assets/images/logo.png') }}" alt="Blog App">
            <span>Blog App</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            @auth()
                <ul class="navbar-nav ms-auto mx-auto">
                    <li class="nav-item">
                        <a href="{{ route('home') }}" class="nav-link text-center {{ $active == 'home' ? 'text-primary fw-semibold' : '' }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('dashboard.index') }}" class="nav-link text-center {{ $active == 'dashboard' ? 'text-primary fw-semibold' : '' }}">Dashboard</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a id="logout-confirmaton" class="nav-link text-center text-light bg-danger px-3 py-2 rounded-3" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); logout();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            @else
                <ul class="navbar-nav ms-auto mx-auto">
                    <li class="nav-item">
                        <a href="{{ route('home') }}" class="nav-link text-center {{ $active == 'home' ? 'text-primary fw-semibold' : '' }}">Home</a>
                    </li>
                </ul>
                <ul class="navbar-nav gap-2">
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="nav-link text-center border border-secondary px-3 py-2 rounded-3">Masuk</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('register') }}" class="nav-link text-center text-light border border-primary bg-primary px-3 py-2 rounded-3">Daftar</a>
                    </li>
                </ul>
            @endauth
        </div>
    </div>
</nav>


@push('scripts')
    <script>
        function logout() {
            Swal.fire({
                icon: 'question',
                title: 'Anda Yakin?',
                text: 'Apakah Anda yakin ingin logout?',
                showCancelButton: true,
                confirmButtonText: 'Logout',
                customClass: {
                    popup: 'sw-popup',
                    title: 'sw-title',
                    htmlContainer: 'sw-text',
                    icon: 'border-primary text-primary',
                    closeButton: 'bg-secondary border-0 shadow-none',
                    confirmButton: 'bg-danger border-0 shadow-none',
                },
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            });
        }
    </script>
@endpush
