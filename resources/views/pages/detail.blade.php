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
            <p class="mb-0 text-secondary fs-7">Kategori : {{ $article->category }}</p>
            <hr class="bg-secondary">
            <div class="info d-flex flex-column gap-1">
                <div class="author d-flex align-items-center gap-1">
                    <p class="my-0 py-0 text-dark fs-7">By : </p>
                    <div class="profile-author">
                        @if (!empty($article->user->avatar))
                            <img class="img" src="{{ asset('storage/avatars/' . $article->user->avatar) }}">
                        @elseif (!empty($article->user->avatar_google))
                            <img class="img" src="{{ $article->user->avatar_google }}">
                        @else
                            <img class="img" src="https://ui-avatars.com/api/?background=random&name={{ urlencode($article->user->name) }}">
                        @endif
                    </div>
                    <p class="my-0 py-0 text-dark fs-7">{{ $article->author ? $article->author : $article->user->name }}</p>
                </div>
                <p class="mb-0 text-secondary fs-7">Sumber : <i>{{ $article->source ? $article->source : 'blog-app.hikmal-falah.com' }}</i></p>
                <p class="mb-0 text-secondary fs-7">Dipublish pada {{ Carbon\Carbon::parse($article->date)->translatedFormat('d F Y') }}</p>
            </div>
        </div>
    </section>

    <section>
        <div class="container px-3 px-md-5">
            <img src="{{ url('storage/thumbnails/' . $article->thumbnail) }}" alt="thumbnail" class="rounded-2 mb-5">
            <div class="px-0 mx-0">
                {!! $article->body !!}
            </div>
        </div>
    </section>
@endsection