@extends('layouts.main')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
@endpush

@section('content')
    <div class="title d-flex align-items-center gap-2 mb-4">
        <a href="{{ route('dashboard.index') }}" class="text-dark d-flex align-items-center" title="Back">
            <i class='bx bx-arrow-back fs-3'></i>
        </a>
        <h3 class="text-dark fw-bold my-0 py-0">Edit Artikel</h3>
    </div>

    <div class="card">
        <div class="card-body p-3 p-lg-4">
            <form action="{{ route('dashboard.update', $article->id) }}" method="post" enctype="multipart/form-data">
                @csrf @method('PUT')

                <div class="mb-3">
                    <label for="title">Judul</label>
                    <input type="text" name="title" class="form-control" id="title" placeholder="Masukkan judul artikelnya" value="{{ $article->title }}" required autofocus>
                </div>
                <div class="mb-3">
                    <label for="thumbnail">Thumbnail</label>
                    <input type="file" name="thumbnail" id="thumbnail" class="form-control" accept=".jpg, .jpeg, .png, .webp">
                </div>
                <div class="mb-3">
                    <label for="body">Isi Konten</label>
                    <textarea name="body" id="body" cols="30" rows="10">{{ $article->body }}</textarea>
                </div>

                <div class="d-grid d-md-flex justify-content-md-end w-100">
                    <button class="btn btn-primary" type="submit">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    
    <script>
        $(document).ready(function () {
            $('#body').summernote({
                height: 400,
                tabsize: 5
            });
        });
    </script>
@endpush
