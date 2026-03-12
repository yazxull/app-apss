@extends('layouts.auth')

@section('title', 'Login Admin')

@section('content')
    <div class="card shadow-sm" style="width: 400px">
        <div class="card-header text-center">
            <h5 class="card-title mb-0">Login Admin</h5>
        </div>

        <form class="card-body" method="post" action="{{ route('admin.login') }}">
            @csrf

            {{-- Username --}}
            <div class="mb-3">
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-person"></i>
                    </span>
                    <input type="text"
                           class="form-control @error('username') is-invalid @enderror"
                           name="username"
                           placeholder="Username">
                </div>
                @error('username')
                    <div class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Password --}}
            <div class="mb-3">
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-key"></i>
                    </span>

                    <input type="password"
                           id="password"
                           class="form-control @error('password') is-invalid @enderror"
                           name="password"
                           placeholder="Password">

                    <span class="input-group-text"
                          style="cursor: pointer"
                          onclick="togglePassword()">
                        <i id="icon-password" class="bi bi-eye"></i>
                    </span>
                </div>

                @error('password')
                    <div class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="d-grid mb-2">
                <button type="submit" class="btn btn-primary">
                    Login
                </button>
            </div>
        </form>
    </div>
@endsection

@push('js')
<script>
    function togglePassword() {
        const password = document.getElementById('password');
        const icon = document.getElementById('icon-password');

        if (password.type === 'password') {
            password.type = 'text';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        } else {
            password.type = 'password';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
    }
</script>
@endpush
