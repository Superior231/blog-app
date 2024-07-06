<nav class="navbar py-4 bg-soft-blue">
    <div class="container align-items-center justify-content-between">
        <a href="" class="logo">
            <img src="{{ url('assets/images/logo.png') }}" alt="Blog App">
            <span>Blog App</span>
        </a>

        @auth()
            <div class="d-flex align-items-center gap-4">
                <a href="{{ route('home') }}" class="link {{ $active == 'home' ? 'text-primary' : '' }}">Home</a>
                <a href="{{ route('dashboard.index') }}" class="link {{ $active == 'dashboard' ? 'text-primary' : '' }}">Dashboard</a>
                <a id="logout-confirmaton" class="btn btn-danger" href="{{ route('logout') }}"
                    onclick="event.preventDefault(); logout();">
                    {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        
        @else
            <div class="d-flex align-items-center gap-4">
                <a href="{{ route('home') }}" class="link {{ $active == 'home' ? 'text-primary' : '' }}">Home</a>
                <a href="{{ route('login') }}" class="btn btn-primary">Masuk</a>
            </div>
        @endauth
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