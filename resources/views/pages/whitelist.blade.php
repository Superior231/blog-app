@extends('layouts.main')

@push('styles')
    @livewireStyles()
@endpush

@section('content')
    <section class="whitelist py-0">
        <h3 class="text-dark fw-bold">My Whitelists</h3>
        @livewire('whitelist')
    </section>
@endsection

@push('scripts')
    @livewireScripts()
@endpush
