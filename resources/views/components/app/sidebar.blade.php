<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 bg-slate-900 fixed-start" id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand d-flex align-items-center justify-content-center m-0" href="{{ route('dashboard') }}">
            <div class="brand-logo">
                <span class="font-weight-bold text-lg text-white">GISO 360</span>
            </div>
        </a>
    </div>
    
    <div class="collapse navbar-collapse px-3 w-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            {{-- Dashboard - For Both Admin and Student --}}
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('dashboard') || request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                    href="{{ Auth::user()->role === 'admin' ? route('admin.dashboard') : route('dashboard') }}">
                    <i class="fas fa-home nav-icon"></i>
                    <span class="nav-link-text">Dashboard</span>
                </a>
            </li>

            {{-- Student Only Menu Items --}}
            @if(Auth::user()->role === 'student')
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('teams.*') ? 'active' : '' }}"
                    href="{{ route('teams.index') }}">
                        <i class="fas fa-users nav-icon"></i>
                        <span class="nav-link-text">Team</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('presentation-schedules.*') ? 'active' : '' }}"
                    href="{{ route('presentation-schedules.index') }}">
                        <i class="fas fa-calendar-alt nav-icon"></i>
                        <span class="nav-link-text">Schedule</span>
                    </a>
                </li>
            @endif

            {{-- Admin Only Menu Items --}}
            @if(Auth::user()->role === 'admin')
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.presentation-schedules*') ? 'active' : '' }}"
                    href="{{ route('admin.presentation-schedules') }}">
                        <i class="fas fa-calendar-check nav-icon"></i>
                        <span class="nav-link-text">Manage Schedule</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.proposals*') ? 'active' : '' }}"
                    href="{{ route('admin.proposals') }}">
                        <i class="fas fa-file-alt nav-icon"></i>
                        <span class="nav-link-text">Proposals</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.reports*') ? 'active' : '' }}"
                    href="{{ route('admin.reports') }}">
                        <i class="fas fa-chart-bar nav-icon"></i>
                        <span class="nav-link-text">Reports</span>
                    </a>
                </li>
            @endif

            <li class="nav-item mt-2">
                <hr class="horizontal light my-2" />
            </li>

            {{-- Account Pages Section (For Both) --}}
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('profile') ? 'active' : '' }}"
                    href="{{ route('profile') }}">
                    <i class="fas fa-user nav-icon"></i>
                    <span class="nav-link-text">Profile</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('signin') ? 'active' : '' }}"
                    href="{{ route('signin') }}">
                    <i class="fas fa-sign-in-alt nav-icon"></i>
                    <span class="nav-link-text">Sign In</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('signup') ? 'active' : '' }}"
                    href="{{ route('signup') }}">
                    <i class="fas fa-user-plus nav-icon"></i>
                    <span class="nav-link-text">Sign Up</span>
                </a>
            </li>
        </ul>
    </div>
</aside>

<style>
/* Compact Sidebar Styles */
.sidenav {
    width: 250px !important;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 10px 30px -12px rgba(50, 50, 93, 0.25), 
                0 4px 25px 0 rgba(0, 0, 0, 0.1), 
                0 10px 10px -5px rgba(50, 50, 93, 0.2);
    height: 100vh;
    overflow-y: auto;
    overflow-x: hidden;
}

.sidenav-header {
    padding: 1rem 0;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    margin-bottom: 0.5rem;
}

.brand-logo {
    display: flex;
    align-items: center;
    justify-content: center;
}

.brand-logo i {
    font-size: 1.3rem;
}

.navbar-collapse {
    padding: 0;
}

.navbar-nav {
    width: 100%;
}

.nav-item {
    margin: 0;
}

.nav-link {
    display: flex;
    align-items: center;
    padding: 0.6rem 1rem;
    margin: 0.1rem 0.5rem;
    border-radius: 0.4rem;
    transition: all 0.2s ease;
    color: rgba(255, 255, 255, 0.7);
    font-weight: 500;
    font-size: 0.85rem;
    position: relative;
}

.nav-link:hover {
    background-color: rgba(255, 255, 255, 0.08);
    color: white;
    transform: translateX(3px);
}

.nav-link.active {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    box-shadow: 0 3px 15px rgba(102, 126, 234, 0.3);
}

.nav-link.active::before {
    content: '';
    position: absolute;
    left: -1rem;
    top: 50%;
    transform: translateY(-50%);
    width: 4px;
    height: 70%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 0 4px 4px 0;
}

.nav-icon {
    width: 18px;
    text-align: center;
    margin-right: 0.75rem;
    font-size: 0.9rem;
}

.nav-link-text {
    font-size: 0.85rem;
    white-space: nowrap;
}

.horizontal.light {
    background-image: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.15), transparent);
    height: 1px;
    margin: 0.5rem 1rem;
    border: none;
}

/* Scrollbar Styling */
.sidenav::-webkit-scrollbar {
    width: 4px;
}

.sidenav::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.05);
}

.sidenav::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.2);
    border-radius: 2px;
}

.sidenav::-webkit-scrollbar-thumb:hover {
    background: rgba(255, 255, 255, 0.3);
}

/* Responsive adjustments */
@media (max-width: 1200px) {
    .sidenav {
        transform: translateX(-100%);
        z-index: 1050;
    }
    
    .g-sidenav-show .sidenav {
        transform: translateX(0);
    }
}

@media (min-height: 600px) {
    .sidenav {
        overflow-y: visible;
    }
}

/* Ensure all items fit on standard screens */
@media (min-height: 768px) {
    .sidenav {
        height: 100vh;
        overflow-y: visible;
    }
    
    .navbar-collapse {
        max-height: calc(100vh - 80px);
        overflow-y: visible;
    }
}
</style>

<script>
// Optional: Add JavaScript for enhanced active state detection
document.addEventListener('DOMContentLoaded', function() {
    // Get current URL path
    const currentPath = window.location.pathname;
    const navLinks = document.querySelectorAll('.nav-link');
    
    navLinks.forEach(link => {
        const href = link.getAttribute('href');
        
        // Check if current path starts with the link href
        if (currentPath.startsWith(href) && href !== '/') {
            link.classList.add('active');
        }
    });
});
</script>