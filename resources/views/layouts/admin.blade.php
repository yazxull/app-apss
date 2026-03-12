@extends('layouts.main')
@section('body')
@include('layouts.navbar.admin')
<div class="container">
    @yield('content')
</div>
@endsection