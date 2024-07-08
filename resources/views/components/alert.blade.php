{{-- Success --}}
@if (session()->has('success'))
    <div class="alert alert-success alert-dismissible d-flex align-items-center gap-2" role="alert">
        <i class='bx bxs-check-circle text-success fs-4'></i>
        <div>
            {{ session('success') }}
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

{{-- Error --}}
@if (session()->has('error'))
    <div class="alert alert-danger alert-dismissible d-flex align-items-center gap-2" role="alert">
        <i class='bx bxs-error-circle text-error fs-4'></i>
        <div>
            {{ session('error') }}
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif


@if ($errors->has('title'))
    <div class="alert alert-danger alert-dismissible d-flex align-items-center gap-2" role="alert">
        <i class='bx bxs-error-circle text-error fs-4'></i>
        <div>
            {{ $errors->first('title') }}
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

