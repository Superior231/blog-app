@extends('layouts.home')

@section('content')
    <section class="thumbnail py-0 my-0">
        <img src="{{ url('storage/thumbnails/' . $article->thumbnail) }}" alt="thumbnail">
    </section>

    <section class="bg-soft-blue">
        <div class="container px-3 px-md-5">
            <h1 class="text-dark fw-bold">
                {{ $article->title }}
            </h1>
            <p class="mb-0 text-secondary fs-7">Kategori : {{ str_replace(',', ', ', $article->category) }}</p>
            <hr class="bg-secondary">
            <div class="author d-flex gap-2">
                <a href="" class="profile-image">
                    @if (!empty($article->user->avatar))
                        <img class="img" src="{{ asset('storage/avatars/' . $article->user->avatar) }}">
                    @elseif (!empty($article->user->avatar_google))
                        <img class="img" src="{{ $article->user->avatar_google }}">
                    @else
                        <img class="img" src="https://ui-avatars.com/api/?background=random&name={{ urlencode($article->user->name) }}">
                    @endif
                </a>
                <div class="info d-flex flex-column">
                    <a href="" class="author-name">
                        <p class="my-0 py-0 text-primary fw-semibold">{{ $article->user->name }}</p>
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
            
            <div class="actions d-flex align-items-center justify-content-between">
                <div class="share">
                    <button onclick="shareToFacebook('{{ url('/detail/' . $article->slug) }}')" class="facebook" id="facebook-share-{{ $article->id }}">
                        <i class="fa-brands fa-facebook-f"></i>
                    </button>
                    <button onclick="shareToTwitter('{{ url('/detail/' . $article->slug) }}', '{{ $article->title }}')" class="x" id="twitter-share-{{ $article->id }}">
                        <i class="fa-brands fa-x-twitter"></i>
                    </button>
                    <button onclick="shareToEmail('{{ url('/detail/' . $article->slug) }}', '{{ $article->title }}')" class="email" id="email-share-{{ $article->id }}">
                        <i class="fa-solid fa-envelope"></i>
                    </button>
                    <button onclick="copyLink('{{ $article->id }}')" class="copy-link-btn" id="copy-link-btn-{{ $article->id }}">
                        <p class="copy-link-text p-0 m-0 fs-7" id="copy-link-text-{{ $article->id }}">
                            <i class="fa-solid fa-copy"></i>
                        </p>
                        <input type="text" id="copy-link-{{ $article->id }}" value="{{ url('/detail/' . $article->slug) }}" hidden>
                    </button>
                </div>                                            
                @livewire('like-article', ['article_id' => $article->id])
            </div>
        </div>
    </section>

    <section class="article-body">
        <div class="container px-3 px-md-5">
            <div class="thumbnail">
                <img src="{{ url('storage/thumbnails/' . $article->thumbnail) }}" alt="thumbnail" class="rounded-2 mb-5">
            </div>
            <div class="px-0 mx-0">
                {!! $article->body !!}
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        function login() {
            Swal.fire({
                icon: 'info',
                title: 'Information',
                text: 'Untuk melanjutkan, harap login terlebih dahulu!',
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
    </script>
@endpush
