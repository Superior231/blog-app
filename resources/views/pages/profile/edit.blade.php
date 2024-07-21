@extends('layouts.main')

@section('content')
    <div class="title d-flex align-items-center gap-2 mb-4">
        <a href="{{ route('profile.index') }}" class="text-dark d-flex align-items-center" title="Back">
            <i class='bx bx-arrow-back fs-3'></i>
        </a>
        <h3 class="text-dark fw-bold my-0 py-0">Edit Profile</h3>
    </div>
    
    <!-- Danger Zone -->
    <div class="card bg-danger mb-3">
        <div class="card-body p-3 p-lg-4">
            <h5 class="card-title text-light">Danger Zone</h5>
            <hr class="text-light">
            <div class="delete-assets d-flex align-items-center gap-3">
                <form id="delete-avatar-form-{{ Auth::user()->id }}" action="{{ route('delete-avatar', Auth::user()->id) }}" method="POST">
                    @csrf @method('DELETE') 
                    <button class="btn btn-light fs-7" type="button" onclick="deleteAvatar({{ Auth::user()->id }})">Hapus Avatar</button>
                </form>

                <form id="delete-banner-form-{{ Auth::user()->id }}" action="{{ route('delete-banner', Auth::user()->id) }}" method="POST">
                    @csrf @method('DELETE') 
                    <button class="btn btn-light fs-7" type="button" onclick="deleteBanner({{ Auth::user()->id }})">Hapus Banner</button>
                </form>
            </div>
        </div>
    </div>


    <form action="{{ route('profile.update', Auth::user()->id) }}" method="post" enctype="multipart/form-data" class="d-flex flex-column gap-3">
        @csrf @method('PUT')

        <!-- Assets -->
        <div class="card">
            <div class="card-body p-3 p-lg-4">
                <h5 class="card-title">Assets</h5>
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
                <h5 class="card-title">Data</h5>
                <hr class="bg-secondary">
                <div class="mb-3">
                    <label for="name">Nama</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Masukkan namamu" value="{{ Auth::user()->name }}" required>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="gender">Jenis Kelamin</label>
                    <select class="form-select" name="gender" id="gender" aria-label="Default select example">
                        <option value="Pria" {{ Auth::user()->gender === 'Pria' ? 'selected' : '' }}>Pria</option>
                        <option value="Wanita" {{ Auth::user()->gender === 'Wanita' ? 'selected' : '' }}>Wanita</option>
                    </select>
                </div>
                <div class="mb-3">
                    <div class="form-floating">
                        <textarea class="form-control" name="description" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px">{{ Auth::user()->description }}</textarea>
                        <label for="floatingTextarea2">Deskripsi</label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Social Media -->
        <div class="card">
            <div class="card-body p-3 p-lg-4">
                <h5 class="card-title">Social Media</h5>
                <hr class="bg-secondary">
                <div class="input-group mb-3">
                    <span class="input-group-text d-flex align-items-center justify-content-center" id="basic-addon1" style="width: 40px;">
                        <i class="fa-brands fa-facebook-f"></i>
                    </span>
                    <input type="text" name="facebook" class="form-control" value="{{ Auth::user()->facebook }}" placeholder="Masukkan link facebook" aria-describedby="basic-addon1">
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text d-flex align-items-center justify-content-center" id="basic-addon2" style="width: 40px;">
                        <i class="fa-brands fa-x-twitter"></i>
                    </span>
                    <input type="text" name="twitter" class="form-control" value="{{ Auth::user()->twitter }}" placeholder="Masukkan link twitter" aria-describedby="basic-addon2">
                </div>
                <div class="input-group mb-3">
                    <span class="input-group-text d-flex align-items-center justify-content-center" id="basic-addon3" style="width: 40px;">
                        <i class="fa-brands fa-instagram"></i>
                    </span>
                    <input type="text" name="instagram" class="form-control" value="{{ Auth::user()->instagram }}" placeholder="Masukkan link instagram" aria-describedby="basic-addon3">
                </div>
            </div>
        </div>

        <div class="d-grid d-md-flex justify-content-md-end w-100">
            <button class="btn btn-primary" type="submit">Simpan</button>
        </div>
    </form>
@endsection

@push('scripts')
    <script>
        function deleteAvatar(userId) {
            Swal.fire({
                icon: 'question',
                title: 'Anda Yakin?',
                text: 'Apakah Anda yakin ingin menghapus avatar ini?',
                showCancelButton: true,
                confirmButtonText: 'Hapus',
                customClass: {
                    popup: 'sw-popup',
                    title: 'sw-title',
                    htmlContainer: 'sw-text',
                    icon: 'sw-icon',
                    closeButton: 'bg-secondary border-0 shadow-none',
                    confirmButton: 'bg-danger border-0 shadow-none',
                },
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-avatar-form-' + userId).submit();
                }
            });
        }

        function deleteBanner(userId) {
            Swal.fire({
                icon: 'question',
                title: 'Anda Yakin?',
                text: 'Apakah Anda yakin ingin menghapus banner ini?',
                showCancelButton: true,
                confirmButtonText: 'Hapus',
                customClass: {
                    popup: 'sw-popup',
                    title: 'sw-title',
                    htmlContainer: 'sw-text',
                    icon: 'sw-icon',
                    closeButton: 'bg-secondary border-0 shadow-none',
                    confirmButton: 'bg-danger border-0 shadow-none',
                },
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-banner-form-' + userId).submit();
                }
            });
        }
    </script>
@endpush
