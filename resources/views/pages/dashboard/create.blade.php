@extends('layouts.main')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
@endpush

@section('content')
    <div class="title d-flex align-items-center gap-2 mb-4">
        <a href="{{ route('dashboard.index') }}" class="text-dark d-flex align-items-center" title="Back">
            <i class='bx bx-arrow-back fs-3'></i>
        </a>
        <h3 class="text-dark fw-bold my-0 py-0">Tambah Artikel</h3>
    </div>

    <form action="{{ route('dashboard.store') }}" method="post" enctype="multipart/form-data" class="d-flex flex-column gap-3">
        @csrf

        <!-- Assets -->
        <div class="card">
            <div class="card-body p-3 p-lg-4">
                <h5 class="card-title">Assets</h5>
                <hr class="bg-secondary">
                <div class="mb-3">
                    <label for="thumbnail">Thumbnail</label>
                    <input type="file" name="thumbnail" id="thumbnail" class="form-control" accept=".jpg, .jpeg, .png, .webp" required>
                </div>
            </div>
        </div>

        <!-- Meta -->
        <div class="card">
            <div class="card-body p-3 p-lg-4">
                <h5 class="card-title">Meta</h5>
                <hr class="bg-secondary">
                <div class="mb-3">
                    <label for="author">Author</label>
                    <input type="text" name="author" class="form-control" id="author" placeholder="Masukkan nama penulisnya" autofocus>
                </div>
                <div class="row row-cols-1 row-cols-lg-2 g-3">
                    <div class="col">
                        <label for="source">Sumber <small class="text-secondary">(opsional)</small></label>
                        <input type="text" name="source" class="form-control" id="source" placeholder="ex. tribunnews.com">
                    </div>
                    <div class="col">
                        <label for="date">Date</label>
                        <input type="date" name="date" class="form-control" id="date" required>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data -->
        <div class="card">
            <div class="card-body p-3 p-lg-4">
                <h5 class="card-title">Data</h5>
                <hr class="bg-secondary">
                <div class="mb-3">
                    <label for="title">Judul</label>
                    <input type="text" name="title" class="form-control" id="title"
                        placeholder="Masukkan judul artikelnya" required>
                </div>
                <div class="mb-3">
                    <label for="body">Isi Konten</label>
                    <textarea name="body" id="body" cols="30" rows="10"></textarea>
                </div>
            </div>
        </div>

        <div class="d-grid d-md-flex justify-content-md-end w-100">
            <button class="btn btn-primary" type="submit">Tambah</button>
        </div>
    </form>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
        integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#body').summernote({
                height: 400,
                tabsize: 5
            });
        });
    </script>
@endpush
