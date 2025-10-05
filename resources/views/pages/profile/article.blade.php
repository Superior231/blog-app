@extends('layouts.main')

@push('styles')
    @livewireStyles()
@endpush

@section('content')
    @livewire('user-article', ['slug' => $user->slug, 'id' => $user->id])
@endsection

@push('scripts')
    @livewireScripts()
@endpush
