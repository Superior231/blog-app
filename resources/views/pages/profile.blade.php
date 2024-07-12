@extends('layouts.main')

@section('content')

    @include('components.alert')

    <div class="row row-cols-1 row-cols-lg-2 pb-5 g-3">
        <div class="col col-lg-4">
            <div class="card">
                <div class="card-body d-flex flex-column gap-0 py-4 p-3 p-lg-4">
                    <figure class="profile d-flex flex-column justify-content-center align-items-center gap-3">
                        <div class="profile-image" style="width: 120px; height: 120px;">
                            @if (!empty(Auth::user()->avatar))
                                <img class="img" src="{{ asset('storage/avatars/' . Auth::user()->avatar) }}">
                            @elseif (!empty(Auth::user()->avatar_google))
                                <img class="img" src="{{ Auth::user()->avatar_google }}">
                            @else
                                <img class="img" src="https://ui-avatars.com/api/?background=random&name={{ urlencode(Auth::user()->name) }}">
                            @endif
                        </div>
                        <figcaption class="text-center fs-3 fw-bold w-75">{{ Auth::user()->name }}</figcaption>
                    </figure>

                    <div class="profile-details table-responsive">
                        <table class="table table-borderless" id="table-profile">
                            <tr>
                                <td>
                                    <span>Username</span>
                                </td>
                                <td>
                                    <span>:&nbsp;</span>
                                </td>
                                <td>
                                    <span>{{ Auth::user()->name }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span>Email</span>
                                </td>
                                <td>
                                    <span>:&nbsp;</span>
                                </td>
                                <td>
                                    <span>{{ Auth::user()->email }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span>Articles</span>
                                </td>
                                <td>
                                    <span>:&nbsp;</span>
                                </td>
                                <td>
                                    <span>{{ $myArticles }}</span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col col-lg-8 d-flex flex-column gap-2">
            <div class="card" data-bs-toggle="modal" data-bs-target="#edit-profile">
                <a href="#" class="row card-body d-flex p-4 justify-content-between text-decoration-none">
                    <div class="col d-flex align-items-center gap-3">
                        <i class='bx bxs-user fs-2'></i>
                        <h5 class="py-0 my-0 fw-semibold">Edit profile</h5>
                    </div>
                </a>
            </div>

            <a id="logout-confirmation" href="{{ route('logout') }}" class="logout card text-decoration-none" onclick="event.preventDefault(); logout();">
                <div class="row card-body p-4 d-flex justify-content-between">
                    <div class="col d-flex align-items-center gap-3">
                        <i class='bx bx-arrow-from-left text-danger fs-2'></i>
                        <h5 class="py-0 my-0 text-danger fw-bold">Logout</h5>
                    </div>
                </div>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
    </div>


    <!-- Modal -->
        <!-- modal edit profile -->
        <div class="modal fade" id="edit-profile" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-body-dark">
                <div class="modal-content">
                    <div class="modal-header border-0 d-flex align-items-center justify-content-between">
                        <h3 class="modal-title" id="edit-profile-label">Edit profile</h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="delete-btn position-relative">
                        <form id="delete-avatar-form-{{ $user->id }}" action="{{ route('delete-avatar', $user->id) }}" method="POST" class="position-absolute top-0 end-0" style="z-index: 900;">
                            @csrf @method('DELETE') 
                            <button type="button" class="bg-primary border-none border-0 text-light px-3 py-2" style="border-radius: 10px 0px 0px 10px;" onclick="deleteAvatar({{ $user->id }})">Hapus</button>
                        </form>
                    </div>
                    
                    <form action="{{ route('profile.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf @method('PUT')

                        <div class="modal-body">
                            <figure class="profile d-flex flex-column justify-content-center align-items-center gap-3 mb-4">
                                <div class="profile-image" style="width: 120px; height: 120px;">
                                    @if (!empty(Auth::user()->avatar))
                                        <img class="img img-avatar" id="edit-avatar" src="{{ asset('storage/avatars/' . Auth::user()->avatar) }}">
                                    @elseif (!empty(Auth::user()->avatar_google))
                                        <img class="img img-avatar" id="edit-avatar" src="{{ Auth::user()->avatar_google }}">
                                    @else
                                        <img class="img img-avatar" id="edit-avatar" src="https://ui-avatars.com/api/?background=random&name={{ urlencode(Auth::user()->name) }}">
                                    @endif
                                </div>
                            </figure>
                            <label for="edit-avatar-input" class="mb-2">Upload avatar (max. 5MB)</label>
                            <input type="file" class="form-control @error('avatar') is-invalid @enderror" name="avatar" id="edit-avatar-input" accept=".jpg, .jpeg, .png, .webp">
                            @error('avatar')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
    
                            <div class="edit-username-error-message-container d-flex align-items-center gap-2 mb-2 mt-3">
                                <label for="edit-username">Username</label>
                                <p class="text-size text-danger fw-bolder py-0 my-0" id="edit-profile-error-message-username"></p>
                            </div>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="edit-username" placeholder="Namanya jangan sara yaa" value="{{ Auth::user()->name }}" autocomplete="off" required>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="modal-footer border-0">
                            <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary px-4" id="simpan-edit-profile-btn">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- modal edit profile end -->
    <!-- Modal End -->
@endsection

@push('scripts')
    <!-- Jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

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
    </script>
@endpush
