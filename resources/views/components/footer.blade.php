<footer class="pt-5">
    <div class="container">
        <div class="row row-cols-1 row-cols-lg-2 d-flex justify-content-between">
            <div class="col col-lg-5 d-flex align-items-start flex-column gap-3 mb-4">
                <a href="{{ route('home') }}" class="logo d-flex align-items-center gap-2">
                    <img src="{{ url('assets/images/logo.png') }}" alt="logo" width="40px">
                    <span class="fw-bold my-0 py-0">Blog App</span>
                </a>
                <p class="fs-7">
                    This platform is perfect for sharing stories, inspirations, and experiences. Find great articles in various categories from technology, lifestyle, to hidden gems. Join us and start sharing your experiences!
                </p>
            </div>
            <div class="col col-lg-5">
                <div class="row">
                    <div class="col col-6 col-md-4 d-flex align-items-start flex-column gap-3 mb-4">
                        <p class="fs-6 fw-semibold my-0 py-0 footer-nav-title">Navigation</p>
                        <div class="link d-flex flex-column gap-2">
                            <a href="{{ route('home') }}" class="fs-7">Home</a>
                            @auth
                                <a href="{{ route('dashboard.index') }}" class="fs-7">Dashboard</a>
                                <a href="{{ route('whitelist') }}" class="fs-7">Whitelists</a>
                            @else
                                <a href="{{ route('login') }}" class="fs-7">Login</a>
                                <a href="{{ route('register') }}" class="fs-7">Register</a>
                            @endauth
                        </div>
                    </div>
                    <div class="col col-6 col-md-4 d-flex align-items-start flex-column gap-3 mb-4">
                        <p class="fs-6 fw-semibold my-0 py-0 footer-nav-title">Follow Us</p>
                        <div class="link d-flex flex-column gap-2">
                            <a href="" class="d-flex align-items-center gap-1 fs-7">
                                <i class='bx bxl-facebook-circle fs-5'></i> Facebook
                            </a>
                            <a href="" class="d-flex align-items-center gap-1 fs-7">
                                <i class='bx bxl-instagram-alt fs-5'></i> Instagram
                            </a>
                        </div>
                    </div>
                    <div class="col col-12 col-md-4 d-flex align-items-start flex-column gap-3 mb-4">
                        <p class="fs-6 fw-semibold my-0 py-0 text-nowrap footer-nav-title">Blog App</p>
                        <div class="link d-flex flex-column gap-2">
                            <a href="" class="fs-7">About Us</a>
                            <a href="" class="fs-7">Privacy Policy</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <p class="text-center fs-7 mt-3">Copyright &copy; {{ date('Y') }}. All rights reserved.</p>
    </div>
</footer>