@extends('layouts.home')

@section('content')
    <section class="bg-soft-blue">
        <div class="container">
            <h1 class="text-dark fw-bold">Blog App</h1>
            <p class="mb-0 text-secondary">All the latest Programmer News posts.</p>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row g-4">
                @forelse ($articles as $item)
                    <div class="col-md-4">
                        <a href="{{ route('detail', $item->slug) }}" class="article">
                            <img src="{{ url('storage/thumbnails/' . $item->thumbnail) }}"
                                alt="thumbnail" class="rounded-3 mb-3">
                            <h3>
                                {{ $item->title }}
                            </h3>
                        </a>
                    </div>
                    
                @empty
                    <div class="d-flex justify-content-center align-items-center">
                        <p class="fs-4 text-dark">Belum ada artikel.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
@endsection