@extends('layouts.main')

@push('styles')
    @livewireStyles()
@endpush

@section('content')
    @if (Auth::user()->roles === 'admin')
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-2 mb-5" id="admin-article-info">
            <div class="col text-decoration-none">
                <div class="card">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div class="info d-flex align-items-center gap-3">
                            <img src="{{ url('assets/images/logo.png') }}" alt="icon">
                            <div class="card-info d-flex flex-column justify-content-center gap-2">
                                <h4 class="py-0 my-0 fw-semibold">Total Article</h4>
                                <h5 class="fs-6 py-0 my-0">{{ $articles->count() }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col text-decoration-none">
                <div class="card">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div class="info d-flex align-items-center gap-3">
                            <img src="{{ url('assets/images/logo.png') }}" alt="icon">
                            <div class="card-info d-flex flex-column justify-content-center gap-2">
                                <h4 class="py-0 my-0 fw-semibold">My Articles</h4>
                                <h5 class="fs-6 py-0 my-0">{{ $myArticles }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col col-md-12 text-decoration-none">
                <div class="card">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div class="info d-flex align-items-center gap-3">
                            <i class='bx bxs-food-menu fs-1 text-primary py-0 my-0'></i>
                            <div class="card-info d-flex flex-column justify-content-center gap-2">
                                <h4 class="py-0 my-0 fw-semibold">Categories</h4>
                                <h5 class="fs-6 py-0 my-0">{{ $categories }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="d-flex align-items-center justify-content-between mb-3">
        <h3 class="mb-0 text-dark fw-bold">My Articles</h3>
        <a href="{{ route('dashboard.create') }}" class="btn btn-primary">Tambah Artikel</a>
    </div>

    @include('components.alert')

    @livewire('dashboard')

    @if (Auth::user()->roles === 'admin')
        <div class="d-flex align-items-center justify-content-between mb-3 mt-5">
            <h3 class="mb-0 text-dark fw-bold">All Articles</h3>
        </div>
        @livewire('admin-dashboard')
    @endif
@endsection

@push('scripts')
    @livewireScripts()

    <script>
        function confirmDeleteArticle(articleId) {
            Swal.fire({
                icon: 'question',
                title: 'Anda Yakin?',
                text: 'Apakah Anda yakin ingin menghapus artikel ini?',
                showCancelButton: true,
                confirmButtonText: 'Ya',
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
                    document.getElementById('delete-article-form-' + articleId).submit();
                }
            });
        }
    </script>
@endpush
