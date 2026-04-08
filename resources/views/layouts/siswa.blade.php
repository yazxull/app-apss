@extends('layouts.main')
@section('body')
@include('layouts.navbar.siswa')

<main style="{{ request()->routeIs('welcome') ? '' : 'padding-top: 66px;' }} min-height: 100vh;">
    @if(request()->routeIs('welcome'))
        @yield('content')
    @else
        <div class="container py-4">
            @yield('content')
        </div>
    @endif
</main>
@endsection
