<nav class="navbar sticky-top navbar-expand-lg {{ Auth::user() ? 'py-1' : 'py-3' }} bg-soft-blue">
    <div class="container">
        <a href="{{ route('home') }}" class="logo">
            <img src="{{ url('assets/images/logo.png') }}" alt="Blog App Logo">
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
                    <li class="nav-item">
                        <a href="{{ route('whitelist') }}" class="nav-link text-center {{ $active == 'whitelist' ? 'text-primary fw-semibold' : '' }}">Whitelists</a>
                    </li>
                    @if (Auth::user()->roles == 'admin')
                        <li class="nav-item">
                            <a href="{{ route('category.index') }}" class="nav-link text-center {{ $active == 'category' ? 'text-primary fw-semibold' : '' }}">Categories</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('users.index') }}" class="nav-link text-center {{ $active == 'users' ? 'text-primary fw-semibold' : '' }}">Users</a>
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
                            <span class="nav-text text-dark nav-username">&nbsp;{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-light dropdown-menu-end"
                            aria-labelledby="navbarDropdownMenuLink">
                            <li>
                                <a class="dropdown-item gap-2 d-flex align-items-center {{ $active == 'my profile' ? 'active' : '' }}" href="{{ route('profile.index') }}">
                                    <i class='bx bx-user fs-6'></i>
                                    <span class="py-0 my-0">My profile</span>
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider-dark py-0 my-1">
                            </li>
                            <li>
                                <a id="logout-confirmaton" class="gap-2 dropdown-item d-flex align-items-center" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); logout();">
                                    <i class='bx bx-log-in fs-6'></i>
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
                        <a href="{{ route('login') }}" class="nav-link text-center border border-secondary px-3 py-2 rounded-circle">Login</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('register') }}" class="nav-link text-center text-light border border-primary bg-primary px-3 py-2 rounded-circle">Register</a>
                    </li>
                </ul>
            @endauth
        </div>
    </div>
</nav>


@push('scripts')
    <script>
        function login() {
            Swal.fire({
                icon: 'info',
                title: 'Information',
                text: 'To continue, please log in first!',
                showCancelButton: true,
                confirmButtonText: 'Login',
                customClass: {
                    popup: 'sw-popup',
                    title: 'sw-title',
                    htmlContainer: 'sw-text',
                    closeButton: 'sw-close',
                    icon: 'border-primary text-primary',
                    confirmButton: 'btn-primary',
                },
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '{{ route('login') }}';
                }
            });
        }
        
        function logout() {
            Swal.fire({
                icon: 'question',
                title: 'Are You Sure?',
                text: 'Are you sure you want to logout?',
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
