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