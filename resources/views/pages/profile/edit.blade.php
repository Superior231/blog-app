@extends('layouts.main')

@push('styles')
    <style>
        .navbar {
            display: none;
        }
    </style>
@endpush

@section('content')
    <div class="py-3">
        <div class="title d-flex align-items-center gap-2 mb-4">
            <a href="{{ route('profile.index') }}" class="text-dark d-flex align-items-center" title="Back">
                <i class='bx bx-arrow-back fs-3'></i>
            </a>
            <h3 class="text-dark fw-bold my-0 py-0">Edit Profile</h3>
        </div>
        
        <!-- Danger Zone -->
        <div class="card bg-danger mb-3">
            <div class="card-body p-3 p-lg-4">
                <h4 class="card-title text-light">Danger Zone</h4>
                <hr class="text-light">
                <div class="delete-assets d-flex align-items-center gap-3">
                    <form id="delete-avatar-form-{{ Auth::user()->id }}" action="{{ route('delete-avatar', Auth::user()->id) }}" method="POST">
                        @csrf @method('DELETE') 
                        <button class="btn btn-light fs-7 fw-normal" type="button" onclick="deleteAvatar({{ Auth::user()->id }})">Delete Avatar</button>
                    </form>
    
                    <form id="delete-banner-form-{{ Auth::user()->id }}" action="{{ route('delete-banner', Auth::user()->id) }}" method="POST">
                        @csrf @method('DELETE') 
                        <button class="btn btn-light fs-7 fw-normal" type="button" onclick="deleteBanner({{ Auth::user()->id }})">Delete Banner</button>
                    </form>
                </div>
            </div>
        </div>
    
        <form action="{{ route('profile.update', Auth::user()->id) }}" method="post" enctype="multipart/form-data" class="d-flex flex-column gap-3">
            @csrf @method('PUT')
    
            <!-- Assets -->
            <div class="card">
                <div class="card-body p-3 p-lg-4">
                    <h4 class="card-title">Assets</h4>
                    <hr class="bg-secondary">
                    <div class="mb-3">
                        <label for="avatar">Avatar</label>
                        <input type="file" name="avatar" id="avatar" class="form-control" accept=".jpg, .jpeg, .png, .webp">
                    </div>
                    <div class="mb-3">
                        <label for="banner">Banner</label>
                        <input type="file" name="banner" id="banner" class="form-control" accept=".jpg, .jpeg, .png, .webp">
                    </div>
                </div>
            </div>
    
            <!-- Data -->
            <div class="card">
                <div class="card-body p-3 p-lg-4">
                    <h4 class="card-title">Data</h4>
                    <hr class="bg-secondary">
                    <div class="mb-3">
                        <label for="slug">Username</label>
                        <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror" id="slug" placeholder="Enter your username" value="{{ Auth::user()->slug }}" {{ Auth::user()->slug_changed === true ? 'readonly' : '' }} required>
                        @error('slug')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <small class="form-text"><i>You can only change your username once!</i></small>
                    </div>
                    <div class="mb-3">
                        <label for="name">Name</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Enter your name" value="{{ Auth::user()->name }}" required>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="gender">Gender</label>
                        <select class="form-select" name="gender" id="gender" aria-label="Default select example">
                            <option value="Male" {{ Auth::user()->gender === 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ Auth::user()->gender === 'Female' ? 'selected' : '' }}>Female</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <div class="form-floating">
                            <textarea class="form-control" name="description" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px">{{ Auth::user()->description }}</textarea>
                            <label for="floatingTextarea2">Description</label>
                        </div>
                    </div>
                </div>
            </div>
    
            <!-- Social media -->
            <div class="card">
                <div class="card-body p-3 p-lg-4">
                    <h4 class="card-title">Social media</h4>
                    <hr class="bg-secondary">
                    <div class="input-group mb-3">
                        <span class="input-group-text d-flex align-items-center justify-content-center" id="basic-addon1" style="width: 40px;">
                            <i class="fa-brands fa-facebook"></i>
                        </span>
                        <input type="text" name="facebook" class="form-control" value="{{ Auth::user()->facebook }}" placeholder="Facebook" aria-describedby="basic-addon1">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text d-flex align-items-center justify-content-center" id="basic-addon2" style="width: 40px;">
                            <i class="fa-brands fa-x-twitter"></i>
                        </span>
                        <input type="text" name="twitter" class="form-control" value="{{ Auth::user()->twitter }}" placeholder="Twitter" aria-describedby="basic-addon2">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text d-flex align-items-center justify-content-center" id="basic-addon3" style="width: 40px;">
                            <i class="fa-brands fa-instagram"></i>
                        </span>
                        <input type="text" name="instagram" class="form-control" value="{{ Auth::user()->instagram }}" placeholder="Instagram" aria-describedby="basic-addon3">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text d-flex align-items-center justify-content-center" id="basic-addon4" style="width: 40px;">
                            <i class="fa-brands fa-youtube"></i>
                        </span>
                        <input type="text" name="youtube" class="form-control" value="{{ Auth::user()->youtube }}" placeholder="YouTube" aria-describedby="basic-addon4">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text d-flex align-items-center justify-content-center" id="basic-addon5" style="width: 40px;">
                            <i class="fa-brands fa-linkedin"></i>
                        </span>
                        <input type="text" name="linkedin" class="form-control" value="{{ Auth::user()->linkedin }}" placeholder="LinkedIn" aria-describedby="basic-addon5">
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text d-flex align-items-center justify-content-center" id="basic-addon6" style="width: 40px;">
                            <i class="fa-brands fa-github"></i>
                        </span>
                        <input type="text" name="github" class="form-control" value="{{ Auth::user()->github }}" placeholder="GitHub" aria-describedby="basic-addon6">
                    </div>
                </div>
            </div>
    
            <!-- Change password -->
            <div class="card">
                <div class="p-3 card-body p-lg-4">
                    <h4 class="card-title">Change password</h4>
                    <hr class="bg-secondary">
                    <div class="input-group mb-3">
                        <span class="input-group-text d-flex align-items-center justify-content-center" id="basic-addon4" style="width: 40px;">
                            <i class="fa-solid fa-lock"></i>
                        </span>
                        <input type="password" name="password"
                            class="form-control @error('password') is-invalid @enderror" id="password"
                            aria-describedby="basic-addon4"
                            placeholder="New password">
                        <div class="showPass d-flex align-items-center justify-content-center position-absolute end-0 h-100"
                            id="showPass" style="cursor: pointer; width: 50px; border-radius: 0px 10px 10px 0px;"
                            onclick="showPass()">
                            <i class="fa-regular fa-eye-slash"></i>
                        </div>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
    
            <div class="d-grid d-md-flex justify-content-md-end w-100">
                <button class="btn btn-primary rounded-pill px-4 py-2" type="submit">Save</button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script src="{{ url('assets/js/profile.js') }}"></script>

    <script>
        function showPass() {
            const passwordInput = document.getElementById("password");
            const passwordType = passwordInput.type;

            if (passwordType === "password") {
                passwordInput.type = "text";
                document.getElementById("showPass").innerHTML = '<i class="fa-regular fa-eye"></i>';
            } else {
                passwordInput.type = "password";
                document.getElementById("showPass").innerHTML = '<i class="fa-regular fa-eye-slash"></i>';
            }
        }
    </script>
@endpush
