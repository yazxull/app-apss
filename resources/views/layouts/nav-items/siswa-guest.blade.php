@guest('siswa')
    <li class="nav-item">
        <a class="nav-link" href="{{ route('siswa.login') }}">Login</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('siswa.register') }}">Register</a>
    </li>
@endguest