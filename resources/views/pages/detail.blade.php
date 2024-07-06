@extends('layouts.home')

@section('content')
    <section class="bg-soft-blue">
        <div class="container">
            <h1 class="text-dark fw-bold">
                {{ $article->title }}
            </h1>
            <p class="mb-0 text-secondary fs-7">Dipublish pada {{ Carbon\Carbon::parse($article->created_at)->translatedFormat('d F Y') }} oleh {{ $article->user->name }}</p>
        </div>
    </section>

    <section>
        <div class="container">
            <img src="{{ url('storage/thumbnails/' . $article->thumbnail) }}" alt="thumbnail" class="rounded-2 mb-5">

            <div class="text-secondary px-0 mx-0">
                {!! $article->body !!}
            </div>
        </div>
    </section>
@endsection