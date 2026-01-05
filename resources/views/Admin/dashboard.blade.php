<x-app-layout>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <div class="container-fluid py-4 px-5">
            <!-- Page Header -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card border shadow-xs bg-gradient-primary">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <h1 class="h4 text-white mb-1">Admin Dashboard</h1>
                                    <p class="text-white-70 mb-0">Welcome back! Here's what's happening with your system today.</p>
                                </div>
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-white text-success me-3">
                                        <i class="fas fa-circle me-1" style="font-size: 8px;"></i>
                                        System Online
                                    </span>
                                    <span class="text-sm text-white-80">{{ now()->format('l, F j, Y') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-xl-3 col-sm-6 mb-4">
                    <div class="card border shadow-xs h-100 overflow-hidden">
                        <div class="card-body p-4 position-relative">
                            <div class="position-absolute top-0 end-0 p-2">
                                <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle opacity-10">
                                    <i class="fas fa-users text-white" style="font-size: 2rem;"></i>
                                </div>
                            </div>
                            <div class="mb-3">
                                <h6 class="card-title text-muted text-uppercase mb-1">Total Users</h6>
                                <h2 class="font-weight-bolder text-primary mb-0">{{ $stats['total_users'] }}</h2>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="badge bg-light text-primary me-2">
                                        <i class="fas fa-user-graduate me-1"></i>
                                        {{ $stats['total_students'] }} Students
                                    </span>
                                    <span class="badge bg-light text-primary">
                                        <i class="fas fa-user-tie me-1"></i>
                                        {{ $stats['total_users'] - $stats['total_students'] }} Admins
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-sm-6 mb-4">
                    <div class="card border shadow-xs h-100 overflow-hidden">
                        <div class="card-body p-4 position-relative">
                            <div class="position-absolute top-0 end-0 p-2">
                                <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle opacity-10">
                                    <i class="fas fa-people-group text-white" style="font-size: 2rem;"></i>
                                </div>
                            </div>
                            <div class="mb-3">
                                <h6 class="card-title text-muted text-uppercase mb-1">Total Teams</h6>
                                <h2 class="font-weight-bolder text-success mb-0">{{ $stats['total_teams'] }}</h2>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted text-sm">Active teams in system</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-sm-6 mb-4">
                    <div class="card border shadow-xs h-100 overflow-hidden">
                        <div class="card-body p-4 position-relative">
                            <div class="position-absolute top-0 end-0 p-2">
                                <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle opacity-10">
                                    <i class="fas fa-file-alt text-white" style="font-size: 2rem;"></i>
                                </div>
                            </div>
                            <div class="mb-3">
                                <h6 class="card-title text-muted text-uppercase mb-1">Total Proposals</h6>
                                <h2 class="font-weight-bolder text-warning mb-0">{{ $stats['total_proposals'] }}</h2>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge bg-light text-warning">
                                    <i class="fas fa-clock me-1"></i>
                                    {{ $stats['pending_proposals'] }} Pending Review
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-sm-6 mb-4">
                    <div class="card border shadow-xs h-100 overflow-hidden">
                        <div class="card-body p-4 position-relative">
                            <div class="position-absolute top-0 end-0 p-2">
                                <div class="icon icon-shape bg-gradient-info shadow-info text-center rounded-circle opacity-10">
                                    <i class="fas fa-chart-bar text-white" style="font-size: 2rem;"></i>
                                </div>
                            </div>
                            <div class="mb-3">
                                <h6 class="card-title text-muted text-uppercase mb-1">Total Reports</h6>
                                <h2 class="font-weight-bolder text-info mb-0">{{ $stats['total_reports'] }}</h2>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge bg-light text-info">
                                    <i class="fas fa-clock me-1"></i>
                                    {{ $stats['pending_reports'] }} Pending Review
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card border shadow-xs">
                        <div class="card-header bg-white border-0 pb-3">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <h5 class="mb-1">Quick Actions</h5>
                                    <p class="text-sm text-muted mb-0">Frequently used administrative tasks</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-3 col-6">
                                    <a href="{{ route('admin.proposals') }}" class="card action-card border-0 shadow-sm text-decoration-none h-100">
                                        <div class="card-body text-center p-4">
                                            <div class="icon icon-shape bg-gradient-warning shadow-warning rounded-circle mx-auto mb-3">
                                                <i class="fas fa-file-alt text-white"></i>
                                            </div>
                                            <h6 class="mb-2 text-dark">Review Proposals</h6>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-3 col-6">
                                    <a href="{{ route('admin.reports') }}" class="card action-card border-0 shadow-sm text-decoration-none h-100">
                                        <div class="card-body text-center p-4">
                                            <div class="icon icon-shape bg-gradient-info shadow-info rounded-circle mx-auto mb-3">
                                                <i class="fas fa-chart-bar text-white"></i>
                                            </div>
                                            <h6 class="mb-2 text-dark">Review Reports</h6>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-3 col-6">
                                    <a href="{{ route('admin.presentation-schedules') }}" class="card action-card border-0 shadow-sm text-decoration-none h-100">
                                        <div class="card-body text-center p-4">
                                            <div class="icon icon-shape bg-gradient-success shadow-success rounded-circle mx-auto mb-3">
                                                <i class="fas fa-calendar-alt text-white"></i>
                                            </div>
                                            <h6 class="mb-2 text-dark">Manage Schedule</h6>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="row">
                <!-- Recent Proposals -->
                <div class="col-lg-6 mb-4">
                    <div class="card border shadow-xs h-100">
                        <div class="card-header bg-white border-0 pb-3">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <h5 class="mb-1">Recent Proposals</h5>
                                    <p class="text-sm text-muted mb-0">Latest proposal submissions</p>
                                </div>
                                <a href="{{ route('admin.proposals') }}" class="btn btn-sm btn-outline-primary">
                                    View All <i class="fas fa-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="list-group list-group-flush">
                                @forelse($recentProposals as $proposal)
                                <div class="list-group-item border-0 px-4 py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1 text-dark">{{ $proposal->title }}</h6>
                                            <div class="d-flex align-items-center text-sm text-muted">
                                                <span class="me-3">
                                                    <i class="fas fa-user me-1"></i>
                                                    {{ $proposal->user->name }}
                                                </span>
                                                <span>
                                                    <i class="fas fa-users me-1"></i>
                                                    {{ $proposal->team->name }}
                                                </span>
                                            </div>
                                            <p class="text-sm mb-0 mt-1">{{ Str::limit($proposal->summary, 80) }}</p>
                                        </div>
                                        <div class="text-end">
                                            <span class="badge badge-sm 
                                                @if($proposal->status === 'approved') bg-gradient-success
                                                @elseif($proposal->status === 'rejected') bg-gradient-danger
                                                @else bg-gradient-warning @endif">
                                                {{ ucfirst($proposal->status) }}
                                            </span>
                                            <div class="text-xs text-muted mt-1">
                                                {{ $proposal->created_at->diffForHumans() }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <div class="text-center py-5">
                                    <div class="icon icon-shape bg-gradient-secondary shadow text-center rounded-circle mx-auto mb-3" style="width: 60px; height: 60px;">
                                        <i class="fas fa-file-alt text-white text-lg"></i>
                                    </div>
                                    <h6 class="text-muted">No proposals submitted yet</h6>
                                    <p class="text-sm text-muted mb-0">Proposals will appear here once submitted</p>
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Reports -->
                <div class="col-lg-6 mb-4">
                    <div class="card border shadow-xs h-100">
                        <div class="card-header bg-white border-0 pb-3">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <h5 class="mb-1">Recent Reports</h5>
                                    <p class="text-sm text-muted mb-0">Latest report submissions</p>
                                </div>
                                <a href="{{ route('admin.reports') }}" class="btn btn-sm btn-outline-primary">
                                    View All <i class="fas fa-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="list-group list-group-flush">
                                @forelse($recentReports as $report)
                                <div class="list-group-item border-0 px-4 py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1 text-dark">{{ $report->title }}</h6>
                                            <div class="d-flex align-items-center text-sm text-muted">
                                                <span class="me-3">
                                                    <i class="fas fa-user me-1"></i>
                                                    {{ $report->user->name }}
                                                </span>
                                                <span>
                                                    <i class="fas fa-users me-1"></i>
                                                    {{ $report->team->name }}
                                                </span>
                                            </div>
                                            <p class="text-sm mb-0 mt-1">{{ Str::limit($report->summary, 80) }}</p>
                                        </div>
                                        <div class="text-end">
                                            <span class="badge badge-sm 
                                                @if($report->status === 'approved') bg-gradient-success
                                                @elseif($report->status === 'rejected') bg-gradient-danger
                                                @else bg-gradient-warning @endif">
                                                {{ ucfirst($report->status) }}
                                            </span>
                                            <div class="text-xs text-muted mt-1">
                                                {{ $report->created_at->diffForHumans() }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <div class="text-center py-5">
                                    <div class="icon icon-shape bg-gradient-secondary shadow text-center rounded-circle mx-auto mb-3" style="width: 60px; height: 60px;">
                                        <i class="fas fa-chart-bar text-white text-lg"></i>
                                    </div>
                                    <h6 class="text-muted">No reports submitted yet</h6>
                                    <p class="text-sm text-muted mb-0">Reports will appear here once submitted</p>
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --success-gradient: linear-gradient(135deg, #13B497 0%, #1BCFB4 100%);
        --warning-gradient: linear-gradient(135deg, #F2994A 0%, #F2C94C 100%);
        --info-gradient: linear-gradient(135deg, #4FACFE 0%, #00F2FE 100%);
        --danger-gradient: linear-gradient(135deg, #F53844 0%, #FF6B6B 100%);
    }
    
    body {
        background-color: #f8f9fa;
    }
    
    .card {
        border-radius: 0.75rem;
        transition: all 0.3s ease;
    }
    
    .shadow-xs {
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06) !important;
    }
    
    .action-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
    }
    
    .icon {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .icon-sm {
        width: 40px;
        height: 40px;
    }
    
    .list-group-item {
        border-bottom: 1px solid #f0f2f5;
        transition: all 0.2s ease;
    }
    
    .list-group-item:hover {
        background-color: rgba(94, 114, 228, 0.04);
        transform: translateX(5px);
    }
    
    .text-gradient {
        background: var(--primary-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }
    
    .bg-gradient-primary {
        background: var(--primary-gradient);
    }
    
    .bg-gradient-success {
        background: var(--success-gradient);
    }
    
    .bg-gradient-warning {
        background: var(--warning-gradient);
    }
    
    .bg-gradient-info {
        background: var(--info-gradient);
    }
    
    .bg-gradient-danger {
        background: var(--danger-gradient);
    }
    
    .progress {
        border-radius: 10px;
        background-color: #f0f2f5;
        overflow: hidden;
    }
    
    .progress-bar {
        border-radius: 10px;
        transition: width 1s ease;
    }
    
    .badge {
        font-weight: 500;
        padding: 0.5em 0.75em;
    }
    
    .badge-sm {
        font-size: 0.75rem;
        padding: 0.25em 0.5rem;
    }
    
    .card-header {
        background-color: transparent;
        border-bottom: 1px solid #f0f2f5;
    }
    
    .btn-outline-primary {
        border-color: #667eea;
        color: #667eea;
    }
    
    .btn-outline-primary:hover {
        background-color: #667eea;
        border-color: #667eea;
    }
    
    .text-white-70 {
        color: rgba(255, 255, 255, 0.7) !important;
    }
    
    .text-white-80 {
        color: rgba(255, 255, 255, 0.8) !important;
    }
    
    .card-body {
        padding: 1.5rem;
    }
    
    .h4 {
        font-weight: 600;
    }
    
    .h6 {
        font-weight: 500;
    }
    
    .font-weight-bolder {
        font-weight: 700;
    }
    
    .text-muted {
        color: #6c757d !important;
    }
    
    .text-primary {
        color: #667eea !important;
    }
    
    .text-success {
        color: #13B497 !important;
    }
    
    .text-warning {
        color: #F2994A !important;
    }
    
    .text-info {
        color: #4FACFE !important;
    }
    
    .text-danger {
        color: #F53844 !important;
    }
    
    .bg-light {
        background-color: #f8f9fa !important;
    }
    
    .border-0 {
        border: 0 !important;
    }
    
    .overflow-hidden {
        overflow: hidden;
    }
    
    .position-absolute {
        position: absolute;
    }
    
    .top-0 {
        top: 0;
    }
    
    .end-0 {
        right: 0;
    }
    
    .opacity-10 {
        opacity: 0.1;
    }
    
    /* Animation for progress bars */
    .progress-bar {
        animation: progressAnimation 2s ease-in-out;
    }
    
    @keyframes progressAnimation {
        0% {
            width: 0;
        }
    }
    
    /* Hover effect for cards */
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }
    
    /* Enhanced badge styles */
    .badge {
        letter-spacing: 0.5px;
    }
    
    /* Improved button styles */
    .btn {
        font-weight: 500;
        letter-spacing: 0.5px;
        border-radius: 0.375rem;
    }
    
    /* Enhanced dropdown menu */
    .dropdown-menu {
        border: none;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        border-radius: 0.5rem;
    }
    
    .dropdown-item {
        padding: 0.5rem 1rem;
        transition: all 0.2s ease;
    }
    
    .dropdown-item:hover {
        background-color: #f8f9fa;
        color: #667eea;
    }
    </style>
</x-app-layout>