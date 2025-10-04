@extends('layouts.main')

@push('styles')
    @livewireStyles()

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <style>
        .row.dt-row {
            overflow-x: auto !important;
        }
    </style>
@endpush

@section('content')
    @include('components.toast')

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
                                <h5 class="fs-6 py-0 my-0">{{ $myArticlesCount }}</h5>
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
                                <h5 class="fs-6 py-0 my-0">{{ $categoriesCount }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="card">
        <div class="card-body p-3 p-lg-4">
            <div class="actions d-flex justify-content-between align-items-center">
                <h4 class="py-0 my-0 fw-bold">My Articles</h4>
                <a href="{{ route('dashboard.create') }}" class="btn btn-primary d-flex align-items-center gap-1 px-4 py-2 rounded-pill">
                    <i class='bx bx-plus fs-5'></i>
                    Create
                </a>
            </div>
            <hr>

            <div class="table-responsive">
                <table class="table table-striped table-hover" id="articlesTable">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th>Title</th>
                            <th>Categories</th>
                            <th>Updated at</th>
                            <th>Created at</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($myArticles as $index => $item)
                            <tr class="align-middle">
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>
                                    <div class="title" style="min-width: 250px;">
                                        {{ $item->title }}
                                    </div>
                                </td>
                                <td>
                                    <div class="categories ellipsis-2">
                                        @php
                                            $categories = explode(',', $item->category);
                                        @endphp
                                        @foreach ($categories as $category)
                                            <span class="badge bg-primary">{{ $category }}</span>
                                        @endforeach
                                    </div>
                                </td>
                                <td>
                                    <div class="created-at">
                                        {{ Carbon\Carbon::parse($item->updated_at)->translatedFormat('d F Y, H:i') }} WIB
                                    </div>
                                </td>
                                <td>
                                    <div class="created-at">
                                        {{ Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y, H:i') }} WIB
                                    </div>
                                </td>
                                <td>
                                    <div class="gap-2 actions d-flex align-items-center justify-content-center pe-3">
                                        <a href="{{ route('dashboard.edit', $item->slug) }}" class="p-2 rounded btn btn-primary d-flex align-items-center justify-content-center">
                                            <i class='p-0 m-0 bx bxs-pencil'></i>
                                        </a>
                                        <form id="delete-article-form-{{ $item->id }}" action="{{ route('dashboard.destroy', $item->id) }}" method="POST">
                                            @csrf @method('DELETE')
        
                                            <button type="button" style="cursor: pointer;" class="p-2 rounded btn btn-danger d-flex align-items-center justify-content-center" onclick="confirmDeleteArticle({{ $item->id }})">
                                                <i class='p-0 m-0 bx bxs-trash'></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if (Auth::user()->roles === 'admin')
        <div class="card mt-3">
            <div class="card-body p-3 p-lg-4">
                <div class="actions d-flex justify-content-between align-items-center">
                    <h4 class="py-0 my-0 fw-bold">All Articles</h4>
                    <a href="{{ route('dashboard.create') }}" class="btn btn-primary d-flex align-items-center gap-1 px-4 py-2 rounded-pill">
                        <i class='bx bx-plus fs-5'></i>
                        Create
                    </a>
                </div>
                <hr>

                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="allArticlesTable">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Categories</th>
                                <th>Updated at</th>
                                <th>Created at</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($articles as $index => $item)
                                <tr class="align-middle">
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td>
                                        <div class="title" style="min-width: 250px;">
                                            {{ $item->title }}
                                        </div>
                                    </td>
                                    <td>
                                        <a href="{{ route('author.show', $item->user->slug) }}" class="username-info d-flex justify-content-center align-items-center gap-2" style="width: max-content;">
                                            <div class="profile-image" style="width: 30px; height: 30px;">
                                                @if (!empty($item->user->avatar))
                                                    <img class="img" src="{{ asset('storage/avatars/' . $item->user->avatar) }}">
                                                @elseif (!empty($item->user->avatar_google))
                                                    <img class="img" src="{{ $item->user->avatar_google }}">
                                                @else
                                                    <img class="img" src="https://ui-avatars.com/api/?background=random&name={{ urlencode($item->user->name) }}">
                                                @endif
                                            </div>
                                            <span class="py-0 my-0 nav-username">{{ $item->user->name }}</span>
                                        </a>
                                    </td>
                                    <td>
                                        <div class="categories">
                                            @php
                                                $categories = explode(',', $item->category);
                                            @endphp
                                            @foreach ($categories as $category)
                                                <span class="badge bg-primary">{{ $category }}</span>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td>
                                        <div class="created-at">
                                            {{ Carbon\Carbon::parse($item->updated_at)->translatedFormat('d F Y, H:i') }} WIB
                                        </div>
                                    </td>
                                    <td>
                                        <div class="created-at">
                                            {{ Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y, H:i') }} WIB
                                        </div>
                                    </td>
                                    <td>
                                        <div class="gap-2 actions d-flex align-items-center justify-content-center pe-3">
                                            <a href="{{ route('dashboard.edit', $item->slug) }}" class="p-2 rounded btn btn-primary d-flex align-items-center justify-content-center">
                                                <i class='p-0 m-0 bx bxs-pencil'></i>
                                            </a>
                                            <form id="delete-article-form-{{ $item->id }}" action="{{ route('dashboard.destroy', $item->id) }}" method="POST">
                                                @csrf @method('DELETE')
            
                                                <button type="button" style="cursor: pointer;" class="p-2 rounded btn btn-danger d-flex align-items-center justify-content-center" onclick="confirmDeleteArticle({{ $item->id }})">
                                                    <i class='p-0 m-0 bx bxs-trash'></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
@endsection

@push('scripts')
    @livewireScripts()

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#articlesTable').DataTable({
                "language": {
                    "searchPlaceholder": "Search..."
                },
                responsive: true
            });

            $('#allArticlesTable').DataTable({
                "language": {
                    "searchPlaceholder": "Search..."
                },
                responsive: true
            });
        });

        function confirmDeleteArticle(articleId) {
            Swal.fire({
                icon: 'question',
                title: 'Are you sure?',
                text: 'You won\'t be able to revert this.',
                showCancelButton: true,
                confirmButtonText: 'Delete',
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
                    document.getElementById('delete-article-form-' + articleId).submit();
                }
            });
        }
    </script>
@endpush
