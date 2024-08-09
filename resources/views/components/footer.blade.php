<footer class="pt-5">
    <div class="container">
        <div class="row row-cols-1 row-cols-lg-2 d-flex justify-content-between">
            <div class="col col-lg-5 d-flex align-items-start flex-column gap-3 mb-4">
                <a href="{{ route('home') }}" class="logo d-flex align-items-center gap-2">
                    <img src="{{ url('assets/images/logo.png') }}" alt="logo" width="40px">
                    <span class="fw-bold my-0 py-0">Blog App</span>
                </a>
                <p class="fs-7">
                    Platform terbaik untuk berbagi cerita, inspirasi, dan pengetahuan. Temukan beragam artikel menarik di berbagai kategori mulai dari teknologi, hiburan, hingga gaya hidup. Bergabunglah dengan kami dan mulai berbagi pengalaman Anda!
                </p>
            </div>
            <div class="col col-lg-5">
                <div class="row">
                    <div class="col col-6 col-md-4 d-flex align-items-start flex-column gap-3 mb-4">
                        <p class="fs-6 fw-semibold my-0 py-0">Navigasi</p>
                        <div class="link d-flex flex-column gap-2">
                            <a href="{{ route('home') }}" class="fs-7">Beranda</a>
                            @auth
                                <a href="{{ route('dashboard.index') }}" class="fs-7">Dashboard</a>
                                <a href="{{ route('whitelist') }}" class="fs-7">Whitelists</a>
                            @else
                                <a href="{{ route('login') }}" class="fs-7">Masuk</a>
                                <a href="{{ route('register') }}" class="fs-7">Daftar</a>
                            @endauth
                        </div>
                    </div>
                    <div class="col col-6 col-md-4 d-flex align-items-start flex-column gap-3 mb-4">
                        <p class="fs-6 fw-semibold my-0 py-0">Ikuti Kami</p>
                        <div class="link d-flex flex-column gap-2">
                            <a href="" class="d-flex align-items-center gap-1 fs-7">
                                <i class='bx bxl-facebook-circle fs-5'></i> Facebook
                            </a>
                            <a href="" class="d-flex align-items-center gap-1 fs-7">
                                <i class='bx bxl-instagram-alt fs-5'></i> Instagram
                            </a>
                            <a href="" class="d-flex align-items-center gap-1 fs-7">
                                <i class='bx bxl-twitter fs-5'></i> Twitter
                            </a>
                        </div>
                    </div>
                    <div class="col col-12 col-md-4 d-flex align-items-start flex-column gap-3 mb-4">
                        <p class="fs-6 fw-semibold my-0 py-0 text-nowrap">Tentang Kami</p>
                        <div class="link d-flex flex-column gap-2">
                            <a href="" class="fs-7">Tentang Kami</a>
                            <a href="" class="fs-7">Kebijakan Privasi</a>
                            <a href="" class="fs-7">Kritik dan Saran</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <p class="text-center fs-7 mt-3">Copyright &copy;2024. All rights reserved.</p>
    </div>
</footer>