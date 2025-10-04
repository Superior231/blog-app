@extends('layouts.main')

@push('styles')
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/42.0.2/ckeditor5.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        .navbar {
            display: none;
        }
    </style>
@endpush

@section('content')
    <div class="title d-flex align-items-center gap-2 mb-4">
        <a href="{{ route('dashboard.index') }}" class="text-dark d-flex align-items-center" title="Back">
            <i class='bx bx-arrow-back fs-3'></i>
        </a>
        <h3 class="text-dark fw-bold my-0 py-0">{{ $navTitle }}</h3>
    </div>

    <form action="{{ route('dashboard.store') }}" method="post" enctype="multipart/form-data" class="d-flex flex-column gap-3">
        @csrf

        <!-- Assets -->
        <div class="card">
            <div class="card-body p-3 p-lg-4">
                <h4 class="card-title">Assets</h4>
                <hr class="bg-secondary">
                <div class="user d-flex align-items-center justify-content-center">
                    <div class="rounded thumbnail-preview">
                        <img src="{{ asset('assets/images/banner.png') }}" alt="thumbnail" id="image-preview" width="100%">
                    </div>
                </div>
                <div class="my-3">
                    <label for="image-input">Upload thumbnail</label>
                    <input type="file" name="thumbnail" id="image-input" class="form-control @error('thumbnail') is-invalid @enderror"
                        accept=".jpg, .jpeg, .png, .webp" required>
                    @error('thumbnail')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Data -->
        <div class="card">
            <div class="card-body p-3 p-lg-4">
                <h4 class="card-title">Data</h4>
                <hr class="bg-secondary">
                <div class="mb-3">
                    <label for="title">Categories</label>
                    <select class="form-select" id="category-select" multiple="multiple" required>
                        @foreach ($categories as $item)
                            <option value="{{ $item->title }}">{{ $item->title }}</option>
                        @endforeach
                    </select>
                    <input type="hidden" name="category" id="category-input" value="">
                </div>
                <div class="mb-3">
                    <label for="title">Title</label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" id="title" value="{{ old('title') }}" placeholder="Enter your title" required>
                    @error('title')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <div id="editor-container">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <label for="body" class="text-dark">Content</label>
                            <button onclick="toggleFullScreen()" type="button" class="bg-transparent border-0 d-flex align-items-center gap-1">
                                <i class="bx bx-fullscreen py-0 my-0 text-dark" id="fullscreen-icon"></i>
                                <span class="text-dark" id="fullscreen-text">Fullscreen</span>
                            </button>
                        </div>
                        <textarea name="body" id="body">{{ old('body') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-grid d-md-flex justify-content-md-end w-100">
            <button class="btn btn-primary rounded-pill px-4 py-2" type="submit">Create</button>
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
    
    <script>
        let isFullscreen = false;
    
        function toggleFullScreen() {
            const container = document.getElementById('editor-container');
            const icon = document.getElementById('fullscreen-icon');
            const text = document.getElementById('fullscreen-text');
    
            isFullscreen = !isFullscreen;
    
            if (isFullscreen) {
                container.classList.add('editor-fullscreen');
                icon.classList.remove('bx-fullscreen');
                icon.classList.add('bx-x');
                text.textContent = 'Close';
            } else {
                container.classList.remove('editor-fullscreen');
                icon.classList.remove('bx-x');
                icon.classList.add('bx-fullscreen');
                text.textContent = 'Fullscreen';
            }
        }
    </script>
@endpush
