<!-- Navbar -->
<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
    <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                <li class="breadcrumb-item text-sm">
                    <a class="opacity-5 text-dark" href="{{ Auth::user()->role === 'admin' ? route('admin.dashboard') : route('dashboard') }}">
                        Dashboard
                    </a>
                </li>
                @if(Request::route()->getName() !== 'dashboard' && Request::route()->getName() !== 'admin.dashboard')
                    <li class="breadcrumb-item text-sm text-dark active" aria-current="page">
                        @php
                            $routeName = Request::route()->getName();
                            $routeParts = explode('.', $routeName);
                            $pageName = end($routeParts);
                            $pageName = str_replace('-', ' ', $pageName);
                            $pageName = ucwords($pageName);
                            
                            // Handle specific route names
                            if ($routeName === 'teams.index') {
                                $pageName = 'My Teams';
                            } elseif ($routeName === 'teams.show') {
                                $pageName = 'Team Details';
                            } elseif ($routeName === 'presentation-schedules.index') {
                                $pageName = 'Presentation Schedule';
                            } elseif ($routeName === 'teams.finance') {
                                $pageName = 'Finance Management';
                            } elseif ($routeName === 'admin.presentation-schedules') {
                                $pageName = 'Manage Schedule';
                            } elseif ($routeName === 'admin.proposals') {
                                $pageName = 'Review Proposals';
                            } elseif ($routeName === 'admin.reports') {
                                $pageName = 'Review Reports';
                            } elseif ($routeName === 'admin.users') {
                                $pageName = 'User Management';
                            } elseif ($routeName === 'admin.teams') {
                                $pageName = 'Team Management';
                            } elseif ($routeName === 'admin.expenses') {
                                $pageName = 'Expense Management';
                            } elseif ($routeName === 'profile') {
                                $pageName = 'Profile';
                            }
                        @endphp
                        {{ $pageName }}
                    </li>
                @endif
            </ol>
            <h6 class="font-weight-bolder mb-0">
                @php
                    $routeName = Request::route()->getName();
                    if ($routeName === 'dashboard' || $routeName === 'admin.dashboard') {
                        echo 'Dashboard';
                    } elseif ($routeName === 'teams.index') {
                        echo 'My Teams';
                    } elseif ($routeName === 'teams.show') {
                        echo 'Team Details';
                    } elseif ($routeName === 'presentation-schedules.index') {
                        echo 'Presentation Schedule';
                    } elseif ($routeName === 'teams.finance') {
                        echo 'Finance Management';
                    } elseif ($routeName === 'admin.presentation-schedules') {
                        echo 'Manage Schedule';
                    } elseif ($routeName === 'admin.proposals') {
                        echo 'Review Proposals';
                    } elseif ($routeName === 'admin.reports') {
                        echo 'Review Reports';
                    } elseif ($routeName === 'admin.users') {
                        echo 'User Management';
                    } elseif ($routeName === 'admin.teams') {
                        echo 'Team Management';
                    } elseif ($routeName === 'admin.expenses') {
                        echo 'Expense Management';
                    } elseif ($routeName === 'profile') {
                        echo 'My Profile';
                    } else {
                        echo 'Dashboard';
                    }
                @endphp
            </h6>
        </nav>
        
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <ul class="navbar-nav ms-md-auto justify-content-end d-flex align-items-center">
                <!-- User Profile -->
                <li class="nav-item ps-2 d-flex align-items-center">
                    <a href="{{ route('profile') }}" class="nav-link text-body p-0 d-flex align-items-center me-3">
                        @if(auth()->user()->avatar)
                            <img src="{{ Storage::url(auth()->user()->avatar) }}" class="avatar avatar-sm me-2 border-radius-lg" alt="profile">
                        @else
                            <div class="avatar avatar-sm me-2 bg-gradient-dark border-radius-lg d-flex align-items-center justify-content-center">
                                <span class="text-white text-sm font-weight-bold">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </span>
                            </div>
                        @endif
                        <span class="d-sm-inline d-none">
                            {{ auth()->user()->name }}
                        </span>
                    </a>
                </li>

                <!-- Logout Button -->
                <li class="nav-item ps-2 d-flex align-items-center">
                    <form method="POST" action="{{ route('logout') }}" class="mb-0">
                        @csrf
                        <a href="javascript:;" onclick="event.preventDefault(); this.closest('form').submit();" 
                           class="nav-link text-body p-0" title="Logout">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="me-2">
                                <path d="M9 21H5C4.46957 21 3.96086 20.7893 3.58579 20.4142C3.21071 20.0391 3 19.5304 3 19V5C3 4.46957 3.21071 3.96086 3.58579 3.58579C3.96086 3.21071 4.46957 3 5 3H9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M16 17L21 12L16 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M21 12H9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </a>
                    </form>
                </li>

                <!-- Notifications -->
                <li class="nav-item dropdown pe-2 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0 position-relative" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        <svg height="20" width="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.25 9a6.75 6.75 0 0113.5 0v.75c0 2.123.8 4.057 2.118 5.52a.75.75 0 01-.297 1.206c-1.544.57-3.16.99-4.831 1.243a3.75 3.75 0 11-7.48 0 24.585 24.585 0 01-4.831-1.244.75.75 0 01-.298-1.205A8.217 8.217 0 005.25 9.75V9zm4.502 8.9a2.25 2.25 0 104.496 0 25.057 25.057 0 01-4.496 0z" clip-rule="evenodd" />
                        </svg>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-gradient-danger">
                            3
                            <span class="visually-hidden">unread notifications</span>
                        </span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end px-2 py-3 me-sm-n4" aria-labelledby="dropdownMenuButton">
                        <li class="mb-2">
                            <a class="dropdown-item border-radius-md" href="javascript:;">
                                <div class="d-flex py-1">
                                    <div class="my-auto">
                                        <img src="../assets/img/team-2.jpg" class="avatar avatar-sm border-radius-sm me-3">
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="text-sm font-weight-normal mb-1">
                                            <span class="font-weight-bold">New message</span> from Laur
                                        </h6>
                                        <p class="text-xs text-secondary mb-0">
                                            <i class="fa fa-clock me-1"></i>
                                            13 minutes ago
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="mb-2">
                            <a class="dropdown-item border-radius-md" href="javascript:;">
                                <div class="d-flex py-1">
                                    <div class="my-auto">
                                        <img src="../assets/img/small-logos/logo-google.svg" class="avatar avatar-sm border-radius-sm bg-gradient-dark p-2 me-3">
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="text-sm font-weight-normal mb-1">
                                            <span class="font-weight-bold">New report</span> by Google
                                        </h6>
                                        <p class="text-xs text-secondary mb-0">
                                            <i class="fa fa-clock me-1"></i>
                                            1 day
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item border-radius-md" href="javascript:;">
                                <div class="d-flex py-1">
                                    <div class="avatar avatar-sm border-radius-sm bg-slate-800 me-3 my-auto">
                                        <svg width="12px" height="12px" viewBox="0 0 43 36" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                            <title>credit-card</title>
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <g transform="translate(-2169.000000, -745.000000)" fill="#FFFFFF" fill-rule="nonzero">
                                                    <g transform="translate(1716.000000, 291.000000)">
                                                        <g transform="translate(453.000000, 454.000000)">
                                                            <path class="color-background" d="M43,10.7482083 L43,3.58333333 C43,1.60354167 41.3964583,0 39.4166667,0 L3.58333333,0 C1.60354167,0 0,1.60354167 0,3.58333333 L0,10.7482083 L43,10.7482083 Z" opacity="0.593633743"></path>
                                                            <path class="color-background" d="M0,16.125 L0,32.25 C0,34.2297917 1.60354167,35.8333333 3.58333333,35.8333333 L39.4166667,35.8333333 C41.3964583,35.8333333 43,34.2297917 43,32.25 L43,16.125 L0,16.125 Z M19.7083333,26.875 L7.16666667,26.875 L7.16666667,23.2916667 L19.7083333,23.2916667 L19.7083333,26.875 Z M35.8333333,26.875 L28.6666667,26.875 L28.6666667,23.2916667 L35.8333333,23.2916667 L35.8333333,26.875 Z"></path>
                                                        </g>
                                                    </g>
                                                </g>
                                            </g>
                                        </svg>
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="text-sm font-weight-normal mb-1">
                                            Payment successfully completed
                                        </h6>
                                        <p class="text-xs text-secondary mb-0">
                                            <i class="fa fa-clock me-1"></i>
                                            2 days
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Mobile Sidenav Toggler -->
                <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- End Navbar -->