<nav class="navbar sticky-top navbar-expand-lg py-3 bg-soft-blue">
    <div class="container">
        <a href="{{ route('home') }}" class="logo">
            <img src="{{ url('assets/images/logo.png') }}" alt="Blog App">
            <span>Blog App</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            @auth()
                <ul class="navbar-nav d-flex justify-content-center w-100">
                    <li class="nav-item">
                        <a href="{{ route('home') }}" class="nav-link text-center {{ $active == 'home' ? 'text-primary fw-semibold' : '' }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('dashboard.index') }}" class="nav-link text-center {{ $active == 'dashboard' ? 'text-primary fw-semibold' : '' }}">Dashboard</a>
                    </li>
                    @if (Auth::user()->roles == 'admin')
                        <li class="nav-item">
                            <a href="{{ route('category.index') }}" class="nav-link text-center {{ $active == 'category' ? 'text-primary fw-semibold' : '' }}">Category</a>
                        </li>
                    @endif
                </ul>
                <ul class="navbar-nav mx-0" id="dropdown">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center text-dark" href="#" id="navbarDropdownMenuLink"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="profile-image">
                                @if (!empty(Auth::user()->avatar))
                                    <img class="img" src="{{ asset('storage/avatars/' . Auth::user()->avatar) }}">
                                @elseif (!empty(Auth::user()->avatar_google))
                                    <img class="img" src="{{ Auth::user()->avatar_google }}">
                                @else
                                    <img class="img" src="https://ui-avatars.com/api/?background=random&name={{ urlencode(Auth::user()->name) }}">
                                @endif
                            </div>
                            <span class="nav-text text-dark username-count">&nbsp;{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-light dropdown-menu-end"
                            aria-labelledby="navbarDropdownMenuLink">
                            <li>
                                <a id="logout-confirmaton" class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); logout();">
                                    {{ __('Logout') }}
                                </a>
    
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            @else
                <ul class="navbar-nav ms-auto mx-0 gap-2">
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
