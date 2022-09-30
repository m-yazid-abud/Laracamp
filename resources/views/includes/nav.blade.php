<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container">
        <a class="navbar-brand" href="{{ route('index') }}">
            <img src="{{ Vite::asset('resources/images/logo.png') }}" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Program</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Mentor</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Pricing</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Business</a>
                </li>
            </ul>

            @auth
                <div class="d-flex user-logged dropdown">
                    <a href="#" role="button" id="dropdownMenuDashboard" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Halo, {{ Auth()->user()->name }}
                        @if ($avatar = Auth()->user()->avatar)
                            <img src="{{ $avatar }}" class="user-photo rounded-circle" alt="">
                        @else
                            <img src="https://ui-avatars.com/api/?name=Admin" class="user-photo rounded-circle"
                                alt="">
                        @endif
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuDashboard">
                        <li><a class="dropdown-item" href="{{ route('dashboard') }}">My Dashboard</a></li>
                        <li><a class="dropdown-item" href="#"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit()">Sign
                                Out</a></li>
                        <form action="{{ route('logout') }}" id="logout-form" method="POST" class="d-none">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        </form>
                    </ul>
                </div>
            @else
                <div class="d-flex">
                    <a href="{{ route('login') }}" class="btn btn-master btn-secondary me-3">
                        Sign In
                    </a>
                    <a href="{{ route('login') }}" class="btn btn-master btn-primary">
                        Sign Up
                    </a>
                </div>
            @endauth


        </div>
    </div>
</nav>
