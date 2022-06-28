<header id="header" class="header fixed-top d-flex align-items-center">
    <div class="d-flex align-items-center justify-content-between">
        <a href="{{ route('home') }}" class="logo">
            <span class="d-none d-lg-block">@lang('student manage')</span>
        </a>
        <i class="fa-solid fa-bars toggle-sidebar-btn"></i>
    </div>
    <div class="search-bar">
        <form class="search-form d-flex align-items-center" method="POST" action="#">
            <input type="text" name="query" placeholder="Search" title="Enter search keyword">
            <button type="submit" title="Search"><i class="fa-solid fa-magnifying-glass"></i></button>
        </form>
    </div>
    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">
            <li class="nav-item d-block">
                <div class="dropdown ms-3">
                    <a class="btn btn-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        @lang('languages')
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <li><a class="dropdown-item" href="{{ route('locale', ['locale' => 'en']) }}"><img
                                    src="https://cdn-icons-png.flaticon.com/512/330/330425.png" width="20px">
                                English</a></li>
                        <li><a class="dropdown-item" href="{{ route('locale', ['locale' => 'vi']) }}"><img
                                    src="https://cdn-icons-png.flaticon.com/512/206/206632.png" width="20px">
                                Vietnamese</a></li>
                    </ul>
                </div>
            </li><!-- End Search Icon-->
            <li class="nav-item dropdown">
                <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                    <i class="fa-solid fa-bell"></i>
                    <span class="badge bg-primary badge-number">4</span>
                </a><!-- End Notification Icon -->
            </li><!-- End Notification Nav -->
            <li class="nav-item dropdown">
                <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                    <i class="fa-brands fa-rocketchat"></i>
                    <span class="badge bg-success badge-number">3</span>
                </a><!-- End Messages Icon -->
            </li><!-- End Messages Nav -->
            @auth
                <li class="nav-item dropdown pe-3">
                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#"
                        data-bs-toggle="dropdown">
                        <h4><i class="fa-solid fa-user-astronaut"></i></h4>
                        <span
                            class="d-none d-md-block dropdown-toggle ps-2">{{ Auth::check() ? auth()->user()->name : "Admin's name" }}</span>
                    </a><!-- End Profile Iamge Icon -->
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                                <i class="fa-solid fa-user"></i>
                                <span>My Profile</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                                <i class="fa-solid fa-gear"></i>
                                <span>Account Settings</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="pages-faq.html">
                                <i class="fa-solid fa-circle-question"></i>
                                <span>Need Help?</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ route('signout') }}">
                                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                                <span>Sign Out</span>
                            </a>
                        </li>
                    </ul><!-- End Profile Dropdown Items -->
                </li>
            @else
                <div class="me-5">
                    <a href="{{ route('signout') }}">| Login | </a>
                    <a href="#">Register</a>
                </div>
            @endauth
            <!-- End Profile Nav -->
        </ul>
    </nav><!-- End Icons Navigation -->
</header><!-- End Header -->
<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-item">
            <a class="nav-link " href="{{ route('home') }}">
                <i class="fa-solid fa-align-justify"></i>
                <span>@lang('dashboard')</span>
            </a>
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('students.index') }}">
                <i class="fa-solid fa-users"></i><span>@lang('student list')</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('faculties.index') }}">
                <i class="fa-solid fa-house"></i><span>@lang('faculty list')</span></a>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('subjects.index') }}">
                <i class="fa-solid fa-book"></i><span>@lang('subject list')</span></a>
        </li><!-- End Tables Nav -->
    </ul>
</aside>
