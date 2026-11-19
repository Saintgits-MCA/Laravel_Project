
<nav class="navbar navbar-expand-lg custom-navbar">
    <div class="container">

        <!-- Brand -->
        <a class="navbar-brand fw-bold" href="{{ route('home') }}">
            <span class="brand-icon">E</span>
            Element<span class="brand-dot">.</span>
        </a>

        <!-- Mobile toggle -->
        <button class="navbar-toggler" type="button"
            data-bs-toggle="collapse"
            data-bs-target="#mainNavbar"
            aria-controls="mainNavbar"
            aria-expanded="false"
            aria-label="Toggle navigation">

            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navigation links -->
        <div class="collapse navbar-collapse" id="mainNavbar">

            <ul class="navbar-nav mx-auto gap-lg-3">

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
                       href="{{ route('home') }}">
                        Home
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('user_index') ? 'active' : '' }}"
                       href="{{ route('user_index') }}">
                        Users List
                    </a>
                </li>
                <li class="nav-item">
    <a class="nav-link {{ request()->routeIs('students.*','students') ? 'active' : '' }}"
       href="{{ route('students') }}">
        Students
    </a>
</li>
<li class="nav-item">
    <a class="nav-link {{ request()->routeIs('schools.*') ? 'active' : '' }}"
       href="{{ route('schools.index') }}">
        Schools
    </a>
   
</li>
            </ul>

              <!-- Right Side -->
            <div class="d-flex align-items-center gap-3">

                @guest

                    <!-- Login Button -->
                    <a href="{{ route('login') }}"
                       class="btn btn-register">
                        Login <span>→</span>
                    </a>

                @endguest
                  {{-- Show Logout when logged in --}}
  @auth

        <div class="dropdown">

            <button class="btn btn-register dropdown-toggle"
                    type="button"
                    id="userDropdown"
                    data-bs-toggle="dropdown"
                    aria-expanded="false">

                <i class="bi bi-person-circle me-1"></i>
                {{ Auth::user()->name }}

            </button>

            <ul class="dropdown-menu dropdown-menu-end"
                aria-labelledby="userDropdown">

                {{-- Dashboard --}}
                <li>
                    <a class="dropdown-item"
                       href="{{ route('dashboard') }}">

                        <i class="bi bi-speedometer2 me-2"></i>
                        Dashboard

                    </a>
                </li>

                <li><hr class="dropdown-divider"></li>

                {{-- Logout --}}
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf

                        <button type="submit" class="dropdown-item text-danger">

                            <i class="bi bi-box-arrow-right me-2"></i>
                            Logout

                        </button>
                    </form>
                </li>

            </ul>

        </div>

    @endauth


                 

            </div>
        </div>
    </div>
</nav>
