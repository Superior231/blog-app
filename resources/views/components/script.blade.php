<script src="{{ url('assets/vendors/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ url('assets/js/script.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- PWA  -->
<script src="{{ asset('/sw.js') }}"></script>
<script>
    if ("serviceWorker" in navigator) {
        navigator.serviceWorker.register("/sw.js").then(
            (registration) => {
                console.log("Service worker registration succeeded");
            },
            (error) => {
                console.error(`Service worker registration failed`);
            },
        );
    } else {
        console.error("Service workers are not supported.");
    }
</script>

@stack('scripts')