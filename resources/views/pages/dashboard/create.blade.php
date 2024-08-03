@extends('layouts.main')

@push('styles')
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/42.0.2/ckeditor5.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
                    <input type="file" name="thumbnail" id="thumbnail" class="form-control @error('thumbnail') is-invalid @enderror" accept=".jpg, .jpeg, .png, .webp" required>
                    @error('thumbnail')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Data -->
        <div class="card">
            <div class="card-body p-3 p-lg-4">
                <h5 class="card-title">Data</h5>
                <hr class="bg-secondary">
                <div class="mb-3">
                    <label for="title">Kategori</label>
                    <select class="form-select" id="category-select" multiple="multiple" required>
                        @foreach ($categories as $item)
                            <option value="{{ $item->title }}">{{ $item->title }}</option>
                        @endforeach
                    </select>
                    <input type="hidden" name="category" id="category-input" value="">
                </div>
                <div class="mb-3">
                    <label for="title">Judul</label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" id="title" value="{{ old('title') }}" placeholder="Masukkan judul artikelnya" required>
                    @error('title')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="body">Isi Konten</label>
                    <textarea name="body" id="body">{{ old('body') }}</textarea>
                </div>
            </div>
        </div>

        <div class="d-grid d-md-flex justify-content-md-end w-100">
            <button class="btn btn-primary" type="submit">Tambah</button>
        </div>
    </form>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $('#category-select').select2({
            tags: true,
            placeholder: "Select Categories"
        });
        $('#category-select').change(function() {
            var selectedValues = $(this).val();
            $('#category-input').val(selectedValues);
        });
    </script>

    <script type="importmap">
        {
            "imports": {
                "ckeditor5": "https://cdn.ckeditor.com/ckeditor5/42.0.2/ckeditor5.js",
                "ckeditor5/": "https://cdn.ckeditor.com/ckeditor5/42.0.2/"
            }
        }
    </script>
    <script type="module" src="{{ url('assets/js/ckeditor.js') }}"></script>
@endpush
