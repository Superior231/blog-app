@extends('layouts.home')

@push('styles')
    @livewireStyles()
@endpush

@section('content')
    <section class="bg-soft-blue">
        <div class="container">
            <h1 class="text-dark fw-bold">Blog App</h1>
            <p class="mb-0 text-secondary">Explore Everything: Tech, Entertainment, Food, and More!</p>
        </div>
    </section>

    @livewire('home')
@endsection

@push('scripts')
    @livewireScripts()
@endpush
