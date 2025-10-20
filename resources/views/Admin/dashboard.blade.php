<x-app-layout>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <div class="container-fluid py-4 px-5">
            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card border shadow-xs">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Users</p>
                                        <h5 class="font-weight-bolder mb-0">
                                            {{ $stats['total_users'] }}
                                        </h5>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="text-white mt-2">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-6">
                                    <span class="text-success text-sm font-weight-bolder">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="d-inline me-1">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                        {{ $stats['total_students'] }} Students
                                    </span>
                                </div>
                                <div class="col-6 text-end">
                                    <span class="text-info text-sm font-weight-bolder">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="d-inline me-1">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                                        </svg>
                                        {{ $stats['total_users'] - $stats['total_students'] }} Admins
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card border shadow-xs">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Teams</p>
                                        <h5 class="font-weight-bolder mb-0">
                                            {{ $stats['total_teams'] }}
                                        </h5>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="text-white mt-2">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12">
                                    <span class="text-secondary text-sm">Active teams in system</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card border shadow-xs">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Proposals</p>
                                        <h5 class="font-weight-bolder mb-0">
                                            {{ $stats['total_proposals'] }}
                                        </h5>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="text-white mt-2">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12">
                                    <span class="text-warning text-sm font-weight-bolder">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="d-inline me-1">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        {{ $stats['pending_proposals'] }} Pending
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6">
                    <div class="card border shadow-xs">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                        <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Reports</p>
                                        <h5 class="font-weight-bolder mb-0">
                                            {{ $stats['total_reports'] }}
                                        </h5>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div class="icon icon-shape bg-gradient-info shadow-info text-center rounded-circle">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="text-white mt-2">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12">
                                    <span class="text-warning text-sm font-weight-bolder">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="d-inline me-1">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        {{ $stats['pending_reports'] }} Pending
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions & System Status -->
            <div class="row mb-4">
                <div class="col-lg-6 col-md-6">
                    <div class="card border shadow-xs mb-4">
                        <div class="card-header border-bottom pb-0">
                            <div class="d-sm-flex align-items-center">
                                <div>
                                    <h6 class="font-weight-semibold text-lg mb-0">Quick Actions</h6>
                                    <p class="text-sm">Manage your system quickly</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6 mb-3">
                                    <a href="{{ route('admin.users') }}" class="card border shadow-xs h-100 text-decoration-none">
                                        <div class="card-body text-center p-3">
                                            <div class="icon icon-shape bg-gradient-primary shadow-primary rounded-circle mx-auto mb-2">
                                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="text-white mt-1">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                                                </svg>
                                            </div>
                                            <h6 class="mb-0 text-dark">Manage Users</h6>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-6 mb-3">
                                    <a href="{{ route('admin.teams') }}" class="card border shadow-xs h-100 text-decoration-none">
                                        <div class="card-body text-center p-3">
                                            <div class="icon icon-shape bg-gradient-success shadow-success rounded-circle mx-auto mb-2">
                                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="text-white mt-1">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                                </svg>
                                            </div>
                                            <h6 class="mb-0 text-dark">Manage Teams</h6>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="{{ route('admin.proposals') }}" class="card border shadow-xs h-100 text-decoration-none">
                                        <div class="card-body text-center p-3">
                                            <div class="icon icon-shape bg-gradient-warning shadow-warning rounded-circle mx-auto mb-2">
                                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="text-white mt-1">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                </svg>
                                            </div>
                                            <h6 class="mb-0 text-dark">Review Proposals</h6>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="{{ route('admin.reports') }}" class="card border shadow-xs h-100 text-decoration-none">
                                        <div class="card-body text-center p-3">
                                            <div class="icon icon-shape bg-gradient-info shadow-info rounded-circle mx-auto mb-2">
                                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="text-white mt-1">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                                </svg>
                                            </div>
                                            <h6 class="mb-0 text-dark">Review Reports</h6>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="card border shadow-xs mb-4">
                        <div class="card-header border-bottom pb-0">
                            <div class="d-sm-flex align-items-center">
                                <div>
                                    <h6 class="font-weight-semibold text-lg mb-0">System Status</h6>
                                    <p class="text-sm">Current system performance</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="mb-4">
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="text-sm font-weight-semibold">Storage Usage</span>
                                    <span class="text-sm text-secondary">Normal</span>
                                </div>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            <div class="mb-4">
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="text-sm font-weight-semibold">System Load</span>
                                    <span class="text-sm text-secondary">Low</span>
                                </div>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 15%" aria-valuenow="15" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            <div>
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="text-sm font-weight-semibold">Active Sessions</span>
                                    <span class="text-sm text-secondary">{{ $stats['total_users'] > 0 ? ceil($stats['total_users'] * 0.1) : 0 }}</span>
                                </div>
                                <div class="progress" style="height: 6px;">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: 10%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="card border shadow-xs mb-4">
                        <div class="card-header border-bottom pb-0">
                            <div class="d-sm-flex align-items-center">
                                <div>
                                    <h6 class="font-weight-semibold text-lg mb-0">Recent Proposals</h6>
                                    <p class="text-sm">Latest proposal submissions</p>
                                </div>
                                <div class="ms-auto">
                                    <a href="{{ route('admin.proposals') }}" class="btn btn-sm btn-white mb-0">View All</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="list-group list-group-flush">
                                @forelse($recentProposals as $proposal)
                                <div class="list-group-item px-0 py-3">
                                    <div class="d-flex align-items-start">
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="text-dark mb-1">{{ $proposal->title }}</h6>
                                            <p class="text-secondary mb-1">By {{ $proposal->user->name }} • {{ $proposal->team->name }}</p>
                                            <p class="text-sm mb-0">{{ Str::limit($proposal->summary, 60) }}</p>
                                        </div>
                                        <div class="text-end">
                                            <span class="badge badge-sm 
                                                @if($proposal->status === 'approved') bg-success
                                                @elseif($proposal->status === 'rejected') bg-danger
                                                @else bg-warning @endif">
                                                {{ ucfirst($proposal->status) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <div class="text-center py-4">
                                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="text-secondary mb-2">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <p class="text-secondary mb-0">No proposals submitted yet</p>
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="card border shadow-xs mb-4">
                        <div class="card-header border-bottom pb-0">
                            <div class="d-sm-flex align-items-center">
                                <div>
                                    <h6 class="font-weight-semibold text-lg mb-0">Recent Reports</h6>
                                    <p class="text-sm">Latest report submissions</p>
                                </div>
                                <div class="ms-auto">
                                    <a href="{{ route('admin.reports') }}" class="btn btn-sm btn-white mb-0">View All</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="list-group list-group-flush">
                                @forelse($recentReports as $report)
                                <div class="list-group-item px-0 py-3">
                                    <div class="d-flex align-items-start">
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="text-dark mb-1">{{ $report->title }}</h6>
                                            <p class="text-secondary mb-1">By {{ $report->user->name }} • {{ $report->team->name }}</p>
                                            <p class="text-sm mb-0">{{ Str::limit($report->summary, 60) }}</p>
                                        </div>
                                        <div class="text-end">
                                            <span class="badge badge-sm 
                                                @if($report->status === 'approved') bg-success
                                                @elseif($report->status === 'rejected') bg-danger
                                                @else bg-warning @endif">
                                                {{ ucfirst($report->status) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <div class="text-center py-4">
                                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="text-secondary mb-2">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                    </svg>
                                    <p class="text-secondary mb-0">No reports submitted yet</p>
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-app-layout>