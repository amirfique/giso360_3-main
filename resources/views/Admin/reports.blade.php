<x-app-layout>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <div class="container-fluid py-4 px-5">
            <!-- Success Message -->
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <span class="alert-icon"><i class="ni ni-like-2"></i></span>
                <span class="alert-text">{{ session('success') }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card border-0 shadow-sm bg-gradient-primary">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <h1 class="h4 text-white mb-2">Reports Review</h1>
                                    <p class="text-white-80 mb-0">Manage reports for all GISO teams</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reports table with tabs -->
            <div class="row">
                <div class="col-12">
                    <div class="card border shadow-xs mb-4">
                        <div class="card-header border-bottom pb-0">
                            <!-- Tab Navigation -->
                            <ul class="nav nav-tabs" id="reportTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending" type="button" role="tab" aria-controls="pending" aria-selected="true">
                                        <i class="fas fa-clock me-2"></i>Pending
                                        <span class="badge bg-warning ms-2">{{ $reports->where('status', 'pending')->count() }}</span>
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="approved-tab" data-bs-toggle="tab" data-bs-target="#approved" type="button" role="tab" aria-controls="approved" aria-selected="false">
                                        <i class="fas fa-check-circle me-2"></i>Approved
                                        <span class="badge bg-success ms-2">{{ $reports->where('status', 'approved')->count() }}</span>
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="rejected-tab" data-bs-toggle="tab" data-bs-target="#rejected" type="button" role="tab" aria-controls="rejected" aria-selected="false">
                                        <i class="fas fa-times-circle me-2"></i>Rejected
                                        <span class="badge bg-danger ms-2">{{ $reports->where('status', 'rejected')->count() }}</span>
                                    </button>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body px-0 py-0">
                            <!-- Filter Controls -->
                            <div class="border-bottom py-3 px-3">
                                <div class="row align-items-center">
                                    <div class="col-md-3 mb-2 mb-md-0">
                                        <label class="form-label text-sm mb-1">Search</label>
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text text-body">
                                                <i class="fas fa-search"></i>
                                            </span>
                                            <input type="text" class="form-control" id="searchInput" placeholder="Search by ID, team or email">
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-2 mb-md-0">
                                        <label class="form-label text-sm mb-1">Date Range</label>
                                        <select class="form-select form-select-sm" id="dateFilter">
                                            <option value="">All Dates</option>
                                            <option value="today">Today</option>
                                            <option value="week">This Week</option>
                                            <option value="month">This Month</option>
                                            <option value="quarter">This Quarter</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-2 mb-md-0">
                                        <label class="form-label text-sm mb-1">Team</label>
                                        <select class="form-select form-select-sm" id="teamFilter">
                                            <option value="">All Teams</option>
                                            @php
                                                $uniqueTeams = $reports->pluck('team.name', 'team.id')->unique();
                                            @endphp
                                            @foreach($uniqueTeams as $teamId => $teamName)
                                            <option value="{{ $teamId }}">{{ $teamName }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-2 mb-md-0">
                                        <label class="form-label text-sm mb-1">Sort By</label>
                                        <select class="form-select form-select-sm" id="sortBy">
                                            <option value="newest">Newest First</option>
                                            <option value="oldest">Oldest First</option>
                                            <option value="team">Team Name</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Tab Content -->
                            <div class="tab-content" id="reportTabsContent">
                                <!-- Pending Reports Tab -->
                                <div class="tab-pane fade show active" id="pending" role="tabpanel" aria-labelledby="pending-tab">
                                    <div class="table-responsive p-0">
                                        <table class="table align-items-center mb-0 table-hover">
                                            <thead class="bg-gray-100">
                                                <tr>
                                                    <th class="text-secondary text-xs font-weight-semibold opacity-7">No.</th>
                                                    <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Report ID</th>
                                                    <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">GISO Team ID</th>
                                                    <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">GISO Team Name</th>
                                                    <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">Date Sent</th>
                                                    <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">Sender's Email</th>
                                                    <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">File</th>
                                                    <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">Status</th>
                                                    <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">Note</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($reports->where('status', 'pending') as $index => $report)
                                                <tr data-report-id="{{ $report->id }}" data-team-name="{{ $report->team->name }}" data-email="{{ $report->user->email }}" data-date="{{ $report->created_at->format('Y-m-d') }}">
                                                    <td class="align-middle text-center">
                                                        <span class="text-secondary text-sm font-weight-normal">{{ $index + 1 }}</span>
                                                    </td>
                                                    <td class="align-middle">
                                                        <span class="text-sm font-weight-semibold">#{{ $report->id }}</span>
                                                    </td>
                                                    <td class="align-middle">
                                                        <span class="text-sm">{{ $report->team->id }}</span>
                                                    </td>
                                                    <td class="align-middle">
                                                        <span class="text-sm font-weight-semibold">{{ $report->team->name }}</span>
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <span class="text-secondary text-sm font-weight-normal">
                                                            {{ $report->created_at->format('d/m/Y') }}
                                                        </span>
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <span class="text-sm">{{ $report->user->email }}</span>
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <a href="{{ route('reports.download', $report) }}" 
                                                           class="btn btn-sm btn-outline-dark mb-0"
                                                           target="_blank">
                                                            <i class="fas fa-download me-1"></i>Download
                                                        </a>
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <form action="{{ route('admin.reports.updateStatus', $report) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <select name="status" 
                                                                    class="form-select status-select text-xs border-0 p-2 rounded" 
                                                                    onchange="this.form.submit()"
                                                                    style="
                                                                        background-color: #f3f4f6; color: #6b7280;
                                                                        font-weight: 600;">
                                                        <option value="pending" {{ $report->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                                        <option value="approved" {{ $report->status === 'approved' ? 'selected' : '' }}>Approved</option>
                                                        <option value="rejected" {{ $report->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                                    </select>
                                                        </form>
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <button type="button" 
                                                                class="btn btn-sm btn-outline-primary mb-0"
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#noteModal{{ $report->id }}">
                                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                                <path d="M12 20h9"></path>
                                                                <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                                                            </svg>
                                                            Note
                                                        </button>

                                                        <!-- Note Modal for each report -->
                                                        <div class="modal fade" id="noteModal{{ $report->id }}" tabindex="-1" aria-labelledby="noteModalLabel{{ $report->id }}" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="noteModalLabel{{ $report->id }}">Add Note for Report #{{ $report->id }}</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <form action="{{ route('admin.reports.updateNote', $report) }}" method="POST">
                                                                        @csrf
                                                                        @method('PATCH')
                                                                        <div class="modal-body">
                                                                            <div class="mb-3">
                                                                                <label for="noteText{{ $report->id }}" class="form-label">Note for this report:</label>
                                                                                <textarea class="form-control" id="noteText{{ $report->id }}" name="note" rows="4" placeholder="Enter your notes or feedback for team...">{{ $report->admin_note ?? '' }}</textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-sm btn-white" data-bs-dismiss="modal">Cancel</button>
                                                                            <button type="submit" class="btn btn-sm btn-dark">Save Note</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Approved Reports Tab -->
                                <div class="tab-pane fade" id="approved" role="tabpanel" aria-labelledby="approved-tab">
                                    <div class="table-responsive p-0">
                                        <table class="table align-items-center mb-0 table-hover">
                                            <thead class="bg-gray-100">
                                                <tr>
                                                    <th class="text-secondary text-xs font-weight-semibold opacity-7">No.</th>
                                                    <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Report ID</th>
                                                    <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">GISO Team ID</th>
                                                    <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">GISO Team Name</th>
                                                    <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">Date Sent</th>
                                                    <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">Sender's Email</th>
                                                    <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">File</th>
                                                    <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">Note</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($reports->where('status', 'approved') as $index => $report)
                                                <tr data-report-id="{{ $report->id }}" data-team-name="{{ $report->team->name }}" data-email="{{ $report->user->email }}" data-date="{{ $report->created_at->format('Y-m-d') }}">
                                                    <td class="align-middle text-center">
                                                        <span class="text-secondary text-sm font-weight-normal">{{ $index + 1 }}</span>
                                                    </td>
                                                    <td class="align-middle">
                                                        <span class="text-sm font-weight-semibold">#{{ $report->id }}</span>
                                                    </td>
                                                    <td class="align-middle">
                                                        <span class="text-sm">{{ $report->team->id }}</span>
                                                    </td>
                                                    <td class="align-middle">
                                                        <span class="text-sm font-weight-semibold">{{ $report->team->name }}</span>
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <span class="text-secondary text-sm font-weight-normal">
                                                            {{ $report->created_at->format('d/m/Y') }}
                                                        </span>
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <span class="text-sm">{{ $report->user->email }}</span>
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <a href="{{ route('reports.download', $report) }}" 
                                                           class="btn btn-sm btn-outline-dark mb-0"
                                                           target="_blank">
                                                            <i class="fas fa-download me-1"></i>Download
                                                        </a>
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        @if($report->admin_note)
                                                        <button type="button" 
                                                                class="btn btn-sm btn-outline-primary mb-0"
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#noteModal{{ $report->id }}">
                                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                                <path d="M12 20h9"></path>
                                                                <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                                                            </svg>
                                                            View Note
                                                        </button>
                                                        @else
                                                        <span class="text-muted text-sm">No note</span>
                                                        @endif

                                                        <!-- Note Modal for each report -->
                                                        <div class="modal fade" id="noteModal{{ $report->id }}" tabindex="-1" aria-labelledby="noteModalLabel{{ $report->id }}" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="noteModalLabel{{ $report->id }}">Note for Report #{{ $report->id }}</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <form action="{{ route('admin.reports.updateNote', $report) }}" method="POST">
                                                                        @csrf
                                                                        @method('PATCH')
                                                                        <div class="modal-body">
                                                                            <div class="mb-3">
                                                                                <label for="noteText{{ $report->id }}" class="form-label">Note for this report:</label>
                                                                                <textarea class="form-control" id="noteText{{ $report->id }}" name="note" rows="4" placeholder="Enter your notes or feedback for team...">{{ $report->admin_note ?? '' }}</textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-sm btn-white" data-bs-dismiss="modal">Cancel</button>
                                                                            <button type="submit" class="btn btn-sm btn-dark">Save Note</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Rejected Reports Tab -->
                                <div class="tab-pane fade" id="rejected" role="tabpanel" aria-labelledby="rejected-tab">
                                    <div class="table-responsive p-0">
                                        <table class="table align-items-center mb-0 table-hover">
                                            <thead class="bg-gray-100">
                                                <tr>
                                                    <th class="text-secondary text-xs font-weight-semibold opacity-7">No.</th>
                                                    <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Report ID</th>
                                                    <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">GISO Team ID</th>
                                                    <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">GISO Team Name</th>
                                                    <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">Date Sent</th>
                                                    <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">Sender's Email</th>
                                                    <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">File</th>
                                                    <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">Note</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($reports->where('status', 'rejected') as $index => $report)
                                                <tr data-report-id="{{ $report->id }}" data-team-name="{{ $report->team->name }}" data-email="{{ $report->user->email }}" data-date="{{ $report->created_at->format('Y-m-d') }}">
                                                    <td class="align-middle text-center">
                                                        <span class="text-secondary text-sm font-weight-normal">{{ $index + 1 }}</span>
                                                    </td>
                                                    <td class="align-middle">
                                                        <span class="text-sm font-weight-semibold">#{{ $report->id }}</span>
                                                    </td>
                                                    <td class="align-middle">
                                                        <span class="text-sm">{{ $report->team->id }}</span>
                                                    </td>
                                                    <td class="align-middle">
                                                        <span class="text-sm font-weight-semibold">{{ $report->team->name }}</span>
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <span class="text-secondary text-sm font-weight-normal">
                                                            {{ $report->created_at->format('d/m/Y') }}
                                                        </span>
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <span class="text-sm">{{ $report->user->email }}</span>
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <a href="{{ route('reports.download', $report) }}" 
                                                           class="btn btn-sm btn-outline-dark mb-0"
                                                           target="_blank">
                                                            <i class="fas fa-download me-1"></i>Download
                                                        </a>
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        @if($report->admin_note)
                                                        <button type="button" 
                                                                class="btn btn-sm btn-outline-primary mb-0"
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#noteModal{{ $report->id }}">
                                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                                <path d="M12 20h9"></path>
                                                                <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path>
                                                            </svg>
                                                            View Note
                                                        </button>
                                                        @else
                                                        <span class="text-muted text-sm">No note</span>
                                                        @endif

                                                        <!-- Note Modal for each report -->
                                                        <div class="modal fade" id="noteModal{{ $report->id }}" tabindex="-1" aria-labelledby="noteModalLabel{{ $report->id }}" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="noteModalLabel{{ $report->id }}">Note for Report #{{ $report->id }}</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <form action="{{ route('admin.reports.updateNote', $report) }}" method="POST">
                                                                        @csrf
                                                                        @method('PATCH')
                                                                        <div class="modal-body">
                                                                            <div class="mb-3">
                                                                                <label for="noteText{{ $report->id }}" class="form-label">Note for this report:</label>
                                                                                <textarea class="form-control" id="noteText{{ $report->id }}" name="note" rows="4" placeholder="Enter your notes or feedback for team...">{{ $report->admin_note ?? '' }}</textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-sm btn-white" data-bs-dismiss="modal">Cancel</button>
                                                                            <button type="submit" class="btn btn-sm btn-dark">Save Note</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Pagination -->
                            @if($reports->hasPages())
                            <div class="border-top py-3 px-3 d-flex align-items-center">
                                <p class="font-weight-semibold mb-0 text-dark text-sm">
                                    Page {{ $reports->currentPage() }} of {{ $reports->lastPage() }}
                                </p>
                                <div class="ms-auto">
                                    @if($reports->onFirstPage())
                                        <button class="btn btn-sm btn-white mb-0" disabled>Previous</button>
                                    @else
                                        <a href="{{ $reports->previousPageUrl() }}" class="btn btn-sm btn-white mb-0">Previous</a>
                                    @endif
                                    
                                    @if($reports->hasMorePages())
                                        <a href="{{ $reports->nextPageUrl() }}" class="btn btn-sm btn-white mb-0">Next</a>
                                    @else
                                        <button class="btn btn-sm btn-white mb-0" disabled>Next</button>
                                    @endif
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

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
                border: none;
            }
            
            .shadow-sm {
                box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
            }
            
            .icon {
                width: 48px;
                height: 48px;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            
            .icon-sm {
                width: 32px;
                height: 32px;
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
            
            .badge {
                font-weight: 500;
                padding: 0.5em 0.75em;
                border-radius: 0.375rem;
            }
            
            .card-header {
                background-color: transparent;
                border-bottom: 1px solid #f0f2f5;
            }
            
            .text-white-70 {
                color: rgba(255, 255, 255, 0.7) !important;
            }
            
            .text-white-80 {
                color: rgba(255, 255, 255, 0.8) !important;
            }
            
            .table {
                margin-bottom: 0;
            }
            
            .table thead th {
                border-bottom: 1px solid #f0f2f5;
                padding: 0.75rem;
            }
            
            .table td {
                padding: 0.75rem;
                vertical-align: middle;
            }
            
            .hover-row {
                transition: all 0.2s ease;
            }
            
            .hover-row:hover {
                background-color: rgba(94, 114, 228, 0.04);
            }
            
            .form-control, .form-select {
                border-radius: 0.375rem;
                border: 1px solid #d2d6da;
                transition: all 0.2s ease;
            }
            
            .form-control:focus, .form-select:focus {
                border-color: #667eea;
                box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
            }
            
            .btn {
                font-weight: 500;
                letter-spacing: 0.5px;
                border-radius: 0.375rem;
                transition: all 0.3s ease;
            }
            
            .btn:hover {
                transform: translateY(-2px);
            }
            
            .btn-outline-primary {
                border-color: #667eea;
                color: #667eea;
            }
            
            .btn-outline-primary:hover {
                background-color: #667eea;
                border-color: #667eea;
                color: white;
            }
            
            .input-group-outline {
                position: relative;
            }
            
            .input-group-outline .form-control {
                background: transparent;
                border: none;
                border-bottom: 1px solid #d2d6da;
                border-radius: 0;
                padding: 0;
                transition: all 0.2s ease;
            }
            
            .input-group-outline .form-control:focus {
                border-bottom: 1px solid #667eea;
                box-shadow: none;
            }
            
            .input-group-outline .form-label {
                position: absolute;
                top: 0;
                left: 0;
                transition: all 0.2s ease;
                pointer-events: none;
                color: #adb5bd;
            }
            
            .input-group-outline .form-control:focus + .form-label,
            .input-group-outline .form-control:not(:placeholder-shown) + .form-label {
                font-size: 0.8rem;
                transform: translateY(-25px);
                color: #667eea;
            }
            
            .pagination-wrapper {
                display: flex;
                align-items: center;
            }
            
            .toast {
                min-width: 300px;
            }
            
            /* Animation for cards */
            .card {
                animation: fadeInUp 0.5s ease;
            }
            
            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
            
            /* Custom styles for tabs - matching your style */
            .nav-tabs {
                border-bottom: 1px solid #dee2e6;
            }
            
            .nav-tabs .nav-link {
                border: none;
                color: #6c757d;
                font-weight: 500;
                padding: 0.75rem 1.5rem;
                border-radius: 0.5rem 0.5rem 0 0;
                margin-bottom: -1px;
            }
            
            .nav-tabs .nav-link:hover {
                border: none;
                color: #5e72e4;
            }
            
            .nav-tabs .nav-link.active {
                color: #fefefe;
                background-color: #fff;
                border-bottom: 2px solid #5e72e4;
                font-weight: 600;
            }
            
            .tab-content {
                background-color: #fff;
            }
            
            .tab-pane {
                min-height: 400px;
            }
            
            .table-hover tbody tr:hover {
                background-color: rgba(0, 0, 0, 0.02);
            }
            
            /* Avatar styles */
            .avatar {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                font-size: 0.875rem;
                font-weight: 600;
                color: #fff;
                text-transform: uppercase;
            }
            
            .avatar-initials {
                font-size: 0.75rem;
            }
            
            /* Modal styles - matching your style */
            .modal-content {
                border-radius: 1rem;
                overflow: hidden;
            }

            .modal-header {
                border-bottom: none;
                padding: 1.5rem;
            }

            .modal-header .icon {
                width: 40px;
                height: 40px;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .steps-progress {
                position: relative;
            }

            .steps {
                display: flex;
                justify-content: space-between;
                position: relative;
            }

            .steps::before {
                content: '';
                position: absolute;
                top: 15px;
                left: 0;
                right: 0;
                height: 2px;
                background-color: #e9ecef;
                z-index: 1;
            }

            .step {
                display: flex;
                flex-direction: column;
                align-items: center;
                position: relative;
                z-index: 2;
            }

            .step-number {
                width: 32px;
                height: 32px;
                border-radius: 50%;
                background-color: #e9ecef;
                color: #6c757d;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 0.875rem;
                font-weight: 600;
                margin-bottom: 0.5rem;
                transition: all 0.3s ease;
            }

            .step.active .step-number {
                background-color: #5e72e4;
                color: white;
                box-shadow: 0 4px 6px rgba(94, 114, 228, 0.3);
            }

            .step-label {
                font-size: 0.75rem;
                color: #6c757d;
                font-weight: 500;
            }

            .step.active .step-label {
                color: #5e72e4;
                font-weight: 600;
            }

            .file-upload-area {
                transition: all 0.3s ease;
                cursor: pointer;
            }

            .file-upload-area:hover {
                border-color: #5e72e4 !important;
                background-color: rgba(94, 114, 228, 0.02) !important;
            }

            .file-upload-area.dragover {
                border-color: #5e72e4 !important;
                background-color: rgba(94, 114, 228, 0.05) !important;
            }

            .border-dashed {
                border-style: dashed !important;
            }

            .bg-gray-100 {
                background-color: #f8f9fa !important;
            }

            .border-radius-lg {
                border-radius: 0.75rem !important;
            }

            .form-control-lg {
                padding: 0.75rem 1rem;
                font-size: 1rem;
            }
        </style>

        <script>
            // Function to update report status via AJAX
            function updateReportStatus(reportId, status) {
                if (confirm('Are you sure you want to ' + status + ' this report?')) {
                    fetch(`/admin/reports/${reportId}/status`, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            status: status
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Show success message
                            const alertDiv = document.createElement('div');
                            alertDiv.className = 'alert alert-success alert-dismissible fade show';
                            alertDiv.innerHTML = `
                                <span class="alert-icon"><i class="ni ni-like-2"></i></span>
                                <span class="alert-text">Report ${status} successfully!</span>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            `;
                            
                            document.querySelector('.container-fluid').prepend(alertDiv);
                            
                            // Move row to appropriate tab
                            const row = document.querySelector(`tr[data-report-id="${reportId}"]`);
                            const targetTab = document.getElementById(status);
                            
                            if (targetTab) {
                                const targetTable = targetTab.querySelector('tbody');
                                targetTable.appendChild(row);
                            }
                            
                            // Update tab counts
                            updateTabCounts();
                            
                            // Auto dismiss alert after 3 seconds
                            setTimeout(() => {
                                alertDiv.remove();
                            }, 3000);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred. Please try again.');
                    });
                }
            }
            
            // Function to update tab counts
            function updateTabCounts() {
                const pendingCount = document.querySelectorAll('#pending tbody tr').length;
                const approvedCount = document.querySelectorAll('#approved tbody tr').length;
                const rejectedCount = document.querySelectorAll('#rejected tbody tr').length;
                
                document.querySelector('#pending-tab .badge').textContent = pendingCount;
                document.querySelector('#approved-tab .badge').textContent = approvedCount;
                document.querySelector('#rejected-tab .badge').textContent = rejectedCount;
                
                // Update header stats
                document.querySelector('.bg-white.bg-opacity-20:nth-child(1) p:last-child').textContent = pendingCount;
                document.querySelector('.bg-white.bg-opacity-20:nth-child(2) p:last-child').textContent = approvedCount;
                document.querySelector('.bg-white.bg-opacity-20:nth-child(3) p:last-child').textContent = rejectedCount;
            }
            
            // Filter functionality
            document.addEventListener('DOMContentLoaded', function() {
                const searchInput = document.getElementById('searchInput');
                const dateFilter = document.getElementById('dateFilter');
                const teamFilter = document.getElementById('teamFilter');
                const sortBy = document.getElementById('sortBy');
                
                if (searchInput) {
                    searchInput.addEventListener('input', filterTable);
                }
                
                if (dateFilter) {
                    dateFilter.addEventListener('change', filterTable);
                }
                
                if (teamFilter) {
                    teamFilter.addEventListener('change', filterTable);
                }
                
                if (sortBy) {
                    sortBy.addEventListener('change', sortTable);
                }
                
                function filterTable() {
                    const searchTerm = searchInput.value.toLowerCase();
                    const dateValue = dateFilter.value;
                    const teamValue = teamFilter.value;
                    
                    const allRows = document.querySelectorAll('tbody tr');
                    
                    allRows.forEach(row => {
                        const teamName = row.dataset.teamName.toLowerCase();
                        const email = row.dataset.email.toLowerCase();
                        const date = row.dataset.date;
                        
                        let showRow = true;
                        
                        // Search filter
                        if (searchTerm && !teamName.includes(searchTerm) && !email.includes(searchTerm)) {
                            showRow = false;
                        }
                        
                        // Team filter
                        if (teamValue && row.dataset.teamName !== teamValue) {
                            showRow = false;
                        }
                        
                        // Date filter
                        if (dateValue) {
                            const rowDate = new Date(date);
                            const today = new Date();
                            
                            switch(dateValue) {
                                case 'today':
                                    showRow = rowDate.toDateString() === today.toDateString();
                                    break;
                                case 'week':
                                    const weekAgo = new Date(today.setDate(today.getDate() - 7));
                                    showRow = rowDate >= weekAgo;
                                    break;
                                case 'month':
                                    const monthAgo = new Date(today.setMonth(today.getMonth() - 1));
                                    showRow = rowDate >= monthAgo;
                                    break;
                                case 'quarter':
                                    const quarterAgo = new Date(today.setMonth(today.getMonth() - 3));
                                    showRow = rowDate >= quarterAgo;
                                    break;
                            }
                        }
                        
                        row.style.display = showRow ? '' : 'none';
                    });
                }
                
                function sortTable() {
                    const sortValue = sortBy.value;
                    const activeTab = document.querySelector('.tab-pane.active');
                    const rows = Array.from(activeTab.querySelectorAll('tbody tr'));
                    
                    rows.sort((a, b) => {
                        switch(sortValue) {
                            case 'newest':
                                return new Date(b.dataset.date) - new Date(a.dataset.date);
                            case 'oldest':
                                return new Date(a.dataset.date) - new Date(b.dataset.date);
                            case 'team':
                                return a.dataset.teamName.localeCompare(b.dataset.teamName);
                            default:
                                return 0;
                        }
                    });
                    
                    const tbody = activeTab.querySelector('tbody');
                    rows.forEach(row => tbody.appendChild(row));
                }
            });
        </script>
    </main>
</x-app-layout>