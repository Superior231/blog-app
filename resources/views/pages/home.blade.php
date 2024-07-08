@extends('layouts.home')

@section('content')
    <section class="bg-soft-blue">
        <div class="container">
            <h1 class="text-dark fw-bold">Blog App</h1>
            <p class="mb-0 text-secondary">Explore Everything: Tech, Entertainment, Food, and More!</p>
        </div>
    </section>

    <section>
        <div class="container">
            <div class="row g-5 g-md-4">
                @forelse ($articles as $item)
                    <div class="col-md-4">
                        <div class="card h-100">
                            <a href="{{ route('detail', $item->slug) }}" class="article h-100">
                                <img src="{{ url('storage/thumbnails/' . $item->thumbnail) }}" alt="thumbnail" class="rounded-3 mb-3">
                                <div class="category d-flex flex-wrap mb-3 gap-2">
                                    @foreach (explode(',', $item->category) as $categories)
                                        <p class="badge bg-light p-0 m-0 text-dark">{{ $categories }}</p>
                                    @endforeach
                                </div>
                                <h3 class="mb-3">{{ $item->title }}</h3>
                            </a>

                            <div class="article-interaction d-flex align-items-center justify-content-end gap-2">
                                <div class="likes d-flex align-items-center gap-1">
                                    <i class='bx bx-like'></i>
                                    <p class="my-0 py-0 text-dark fs-7">12</p>
                                </div>
                                <div class="dislikes d-flex align-items-center gap-1">
                                    <i class='bx bx-dislike'></i>
                                    <p class="my-0 py-0 text-dark fs-7">2</p>
                                </div>
                                <div class="comments d-flex align-items-center gap-1">
                                    <i class='bx bx-comment'></i>
                                    <p class="my-0 py-0 text-dark fs-7">5</p>
                                </div>
                            </div>
                            
                            <hr class="bg-secondary">
                            <div class="footer d-flex justify-content-between align-items-center">
                                <div class="author d-flex align-items-center gap-1">
                                    <div class="profile-author">
                                        @if (!empty($item->user->avatar))
                                            <img class="img" src="{{ asset('storage/avatars/' . $item->user->avatar) }}">
                                        @elseif (!empty($item->user->avatar_google))
                                            <img class="img" src="{{ $item->user->avatar_google }}">
                                        @else
                                            <img class="img" src="https://ui-avatars.com/api/?background=random&name={{ urlencode($item->user->name) }}">
                                        @endif
                                    </div>
                                    <p class="my-0 py-0 text-dark fs-7">{{ $item->author ? $item->author : $item->user->name }}</p>
                                </div>
                                <p class="mb-0 text-secondary fs-7">{{ Carbon\Carbon::parse($item->date)->translatedFormat('d F Y') }}</p>
                            </div>
                        </div>
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