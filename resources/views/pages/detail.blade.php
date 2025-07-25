@extends('layouts.home')

@push('styles')
    @livewireStyles()

    <style>
        nav.navbar {
            display: none !important;
        }
    </style>
@endpush

@section('content')
    <nav class="navbar-detail sticky-top">
        <div class="container d-flex align-items-center gap-2 py-3">
            <a href="{{ route('home') }}" class="py-0 my-0 text-dark" title="Back">
                <i class='bx bx-arrow-back fw-semibold py-0 my-0 mt-1'></i>
            </a>
            <span class="py-0 my-0 fs-6 fw-semibold article-title-nav">{{ $article->title }}</span>
        </div>
    </nav>

    @include('components.toast')

    <section class="thumbnail py-0 my-0">
        <img src="{{ url('storage/thumbnails/' . $article->thumbnail) }}" alt="thumbnail">
    </section>

    <section class="bg-soft-blue article-container">
        <div class="container px-3 px-md-5 pt-5 pb-4">
            <h1 class="text-dark fw-bold">
                {{ $article->title }}
            </h1>
            <p class="mb-0 text-secondary fs-7">Kategori : {{ str_replace(',', ', ', $article->category) }}</p>
            <hr class="bg-secondary">
            <div class="author d-flex gap-2">
                <a href="{{ route('author.show', ['slug' => $author->slug]) }}" class="profile-image">
                    @if (!empty($article->user->avatar))
                        <img class="img" src="{{ asset('storage/avatars/' . $article->user->avatar) }}">
                    @elseif (!empty($article->user->avatar_google))
                        <img class="img" src="{{ $article->user->avatar_google }}">
                    @else
                        <img class="img" src="https://ui-avatars.com/api/?background=random&name={{ urlencode($article->user->name) }}">
                    @endif
                </a>
                <div class="info d-flex flex-column">
                    <a href="{{ route('author.show', ['slug' => $author->slug]) }}" class="author-name">
                        <p class="my-0 py-0 text-primary fw-semibold">{{ $author->name }}</p>
                        <p class="my-0 py-0 text-secondary fs-7">&#64;{{ $author->slug }}</p>
                    </a>                                     
                    <a class="d-flex align-items-center gap-1 p-0 m-0" onclick="viewDetails('{{ $article->id }}')">
                        <p class="mb-0 text-secondary fs-7">Diperbarui pada {{ Carbon\Carbon::parse($article->updated_at)->translatedFormat('d F Y, H:i') }} WIB</p>
                        <i class='bx bx-chevron-down text-secondary' id="icon-down-{{ $article->id }}"></i>
                        <i class='bx bx-chevron-up text-secondary' id="icon-up-{{ $article->id }}"></i>
                    </a>
                    <div class="view-details" id="view-details-{{ $article->id }}">
                        <p class="mb-0 text-secondary fs-7">Diterbitkan pada {{ Carbon\Carbon::parse($article->created_at)->translatedFormat('d F Y, H:i') }} WIB</p>
                    </div>
                </div>
            </div>
            
            <div class="actions d-flex align-items-center justify-content-between gap-2">
                <div class="share">
                    <button onclick="shareToFacebook('{{ url('/detail/' . $article->slug) }}')" class="facebook" title="Share to Facebook">
                        <i class="fa-brands fa-facebook-f"></i>
                    </button>
                    <button onclick="shareToX('{{ url('/detail/' . $article->slug) }}', '{{ $article->title }}')" class="x" title="Share to X">
                        <i class="fa-brands fa-x-twitter"></i>
                    </button>
                    <button onclick="shareToEmail('{{ url('/detail/' . $article->slug) }}', '{{ $article->title }}')" class="email" title="Share to Email">
                        <i class="fa-solid fa-envelope"></i>
                    </button>
                    <button onclick="copyLink('{{ $article->id }}')" class="copy-link-btn" id="copy-link-btn-{{ $article->id }}" title="Copy Link">
                        <p class="copy-link-text p-0 m-0 fs-7" id="copy-link-text-{{ $article->id }}">
                            <i class="fa-solid fa-copy"></i>
                        </p>
                        <input type="text" id="copy-link-{{ $article->id }}" value="{{ url('/detail/' . $article->slug) }}" hidden>
                    </button>
                </div>                                            
                @livewire('like-article', ['article_id' => $article->id])
            </div>

            <div class="read-time d-flex align-items-center justify-content-end mt-4 text-secondary">
                <div class="d-flex align-items-center justify-content-center gap-1 bg-primary text-light rounded-pill py-2 px-4">
                    <i class='bx bx-stopwatch fs-5'></i>
                    <p class="my-0 py-0 fs-7">
                        {{ $readTime }}
                    </p>
                </div>
            </div>
        </div>
    </section>

    <div class="row row-cols-1 article-container g-0">
        <section class="col article-body py-4 py-lg-5">
            <div class="container px-3 px-md-5">
                <div class="thumbnail">
                    <img src="{{ url('storage/thumbnails/' . $article->thumbnail) }}" alt="thumbnail" class="rounded-2 mb-5">
                </div>
                <div class="px-0 mx-0 text-break">
                    {!! $article->body !!}
                </div>
            </div>
        </section>
    </div>

    <section class="bg-soft-blue article-container py-2">
        <div class="container px-3 px-md-5">
            @livewire('comment', ['id' => $article->id])
        </div>
    </section>

    <!-- Report Comment -->
    @auth
        <div class="modal fade report-comment-modal" id="reportComment" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header border-0">
                        <h3 class="modal-title">Report Comment</h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body pt-0 pb-2">
                        <div class="comment-content text-decoration-none d-flex flex-column bg-soft-blue px-3 pt-0 pb-3">
                            <div class="sticky-top d-flex align-items-center bg-soft-blue pt-3">
                                <div class="header position-relative">
                                    <div class="profile-image position-absolute top-0">
                                        <img src="{{ url('assets/images/user.jpg') }}" class="img" id="user-profile" alt="profile image">
                                    </div>
                                    <div class="user-info d-flex gap-2" style="margin-left: 50px;">
                                        <div class="username d-flex flex-column gap-0">
                                            <p class="fw-semibold p-0 m-0 fs-7" id="username"></p>
                                            <p class="text-color fs-7" id="slug"></p>
                                        </div>
                                        <p class="text-color p-0 m-0 fs-8" id="created_at">&middot; </p>
                                    </div>
                                </div>
                            </div>
                            <div class="user-comment">
                                <span class="comment-body py-0 my-0" id="comment-body"></span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex flex-column align-items-start pt-0">
                        <label for="report" class="my-2">Report Type</label>
                        <form action="{{ route('report.comment') }}" method="POST" class="w-100">
                            @csrf
                            <input type="hidden" name="user_id" id="user_id" value="{{ Auth::user()->id }}">
                            <input type="hidden" name="comment_id" id="comment_id" value="">
                            <select class="form-select" id="report" name="report" required>
                                <option value="Spam">Spam</option>
                                <option value="Promosi">Promosi</option>
                                <option value="Rasis">Rasis</option>
                                <option value="Berkata Kasar">Berkata Kasar</option>
                                <option value="Ujaran Kebencian">Ujaran Kebencian</option>
                                <option value="Pembulian">Pembulian</option>
                                <option value="Pornografi">Pornografi</option>
                            </select>
                            <div class="d-flex align-items-center justify-content-end gap-2 mt-3 w-100">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary" id="report-button">Report</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endauth

    @include('components.toast')
@endsection

@push('scripts')
    @livewireScripts()
    
    <!-- JQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ url('assets/js/comment.js') }}"></script>

    <script>
        $(document).ready(function(){
            // Cek apakah ada session success
            if ("{{ session()->has('success') }}") {
                // Tampilkan toast
                $('#toast-success-content').toast('show');
                
            } else if ("{{ session()->has('error') }}") {
                $('#toast-error-content').toast('show');
            }
        });
        
        var avatarBaseUrl = '{{ asset('storage/avatars/') }}/';
    </script>
@endpush
