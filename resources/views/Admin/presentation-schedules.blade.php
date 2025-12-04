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
                                    <h1 class="h4 text-white mb-2">Presentation Schedule Management</h1>
                                    <p class="text-white-80 mb-0">Manage presentation schedules for all GISO teams</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Presentation Schedules Table -->
            <div class="row">
                <div class="col-12">
                    <div class="card border shadow-xs mb-4">
                        <div class="card-header border-bottom pb-0">
                            <div class="d-sm-flex align-items-center">
                                <div>
                                    <h6 class="font-weight-semibold text-lg mb-0">Presentation Schedules</h6>
                                    <p class="text-sm">Manage schedules for all teams</p>
                                </div>
                            </div>
                        </div>
                 <!-- Search and Filters -->
                        <div class="card-body">
                                        <form method="GET" action="{{ route('admin.presentation-schedules') }}">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <span class="input-group-text text-body">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                                            </svg>
                                                        </span>
                                                        <input type="text" class="form-control" name="search" placeholder="Search by Team Name or GISO ID..." value="{{ request('search') }}">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <select class="form-select" name="proposal_status">
                                                        <option value="">All Proposal Status</option>
                                                        <option value="pending" {{ request('proposal_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                                        <option value="approved" {{ request('proposal_status') == 'approved' ? 'selected' : '' }}>Approved</option>
                                                        <option value="rejected" {{ request('proposal_status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <select class="form-select" name="sort">
                                                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest Teams</option>
                                                        <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Sort by Name</option>
                                                        <option value="id" {{ request('sort') == 'id' ? 'selected' : '' }}>Sort by ID</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <button type="submit" class="btn btn-dark w-100">Apply</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>        
                        <div class="card-body px-0 py-0">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead class="bg-gray-100">
                                        <tr>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7">ID</th>
                                            <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">GISO Team Name</th>
                                            <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">Status</th>
                                            <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">Presentation Date</th>
                                            <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">Location</th>
                                            <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">Time</th>
                                            <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">Notes</th>
                                            <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($teams as $team)
                                        @php
                                            $latestProposal = $team->proposals->sortByDesc('created_at')->first();
                                            $status = $latestProposal ? $latestProposal->status : 'none';
                                            $schedule = $team->presentationSchedule;
                                        @endphp
                                        <tr>
                                            <td class="align-middle text-center">
                                                <span class="text-sm font-weight-semibold">{{ $team->id }}</span>
                                            </td>
                                            <td class="align-middle">
                                                <span class="text-sm font-weight-semibold">{{ $team->name }}</span>
                                            </td>
                                            <td class="align-middle text-center">
                                                @if($status === 'approved')
                                                    <span class="badge badge-sm border border-success text-success bg-success">Approved</span>
                                                @elseif($status === 'rejected')
                                                    <span class="badge badge-sm border border-danger text-danger bg-danger">Rejected</span>
                                                @elseif($status === 'pending')
                                                    <span class="badge badge-sm border border-warning text-warning bg-warning">Pending</span>
                                                @else
                                                    <span class="badge badge-sm border border-secondary text-secondary bg-secondary">No Proposal</span>
                                                @endif
                                            </td>
                                            <td class="align-middle text-center">
                                                <form action="{{ route('admin.presentation-schedules.update', $team) }}" method="POST" class="schedule-form">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="date" 
                                                           class="form-control form-control-sm text-center" 
                                                           name="presentation_date" 
                                                           value="{{ $schedule ? $schedule->presentation_date->format('Y-m-d') : '' }}"
                                                           min="{{ now()->format('Y-m-d') }}">
                                            </td>
                                            <td class="align-middle text-center">
                                                <select class="form-select form-select-sm" name="location">
                                                    <option value="">Select Location</option>
                                                    <option value="Main Auditorium" {{ $schedule && $schedule->location == 'Main Auditorium' ? 'selected' : '' }}>Main Auditorium</option>
                                                    <option value="Room 101" {{ $schedule && $schedule->location == 'Room 101' ? 'selected' : '' }}>Room 101</option>
                                                    <option value="Room 102" {{ $schedule && $schedule->location == 'Room 102' ? 'selected' : '' }}>Room 102</option>
                                                    <option value="Room 201" {{ $schedule && $schedule->location == 'Room 201' ? 'selected' : '' }}>Room 201</option>
                                                    <option value="Room 202" {{ $schedule && $schedule->location == 'Room 202' ? 'selected' : '' }}>Room 202</option>
                                                    <option value="Conference Room A" {{ $schedule && $schedule->location == 'Conference Room A' ? 'selected' : '' }}>Conference Room A</option>
                                                    <option value="Conference Room B" {{ $schedule && $schedule->location == 'Conference Room B' ? 'selected' : '' }}>Conference Room B</option>
                                                    <option value="Lab 1" {{ $schedule && $schedule->location == 'Lab 1' ? 'selected' : '' }}>Lab 1</option>
                                                    <option value="Lab 2" {{ $schedule && $schedule->location == 'Lab 2' ? 'selected' : '' }}>Lab 2</option>
                                                </select>
                                            </td>
                                            <td class="align-middle text-center">
                                                <select class="form-select form-select-sm" name="presentation_time">
                                                    <option value="">Select Time</option>
                                                    @for($hour = 8; $hour <= 17; $hour++)
                                                        @foreach(['00', '30'] as $minute)
                                                            @php
                                                                $time = sprintf('%02d:%s', $hour, $minute);
                                                                $displayTime = date('h:i A', strtotime($time));
                                                            @endphp
                                                            <option value="{{ $time }}" {{ $schedule && $schedule->presentation_time == $time ? 'selected' : '' }}>
                                                                {{ $displayTime }}
                                                            </option>
                                                        @endforeach
                                                    @endfor
                                                </select>
                                            </td>
                                            <td class="align-middle text-center">
                                                <textarea class="form-control form-control-sm" 
                                                          name="notes" 
                                                          rows="1" 
                                                          placeholder="Special instructions...">{{ $schedule ? $schedule->notes : '' }}</textarea>
                                            </td>
                                            <td class="align-middle text-center">
                                                <button type="submit" class="btn btn-sm btn-dark" rows="1">Save</button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- Pagination -->
                            @if($teams->hasPages())
                            <div class="border-top py-3 px-3 d-flex align-items-center">
                                <p class="font-weight-semibold mb-0 text-dark text-sm">
                                    Page {{ $teams->currentPage() }} of {{ $teams->lastPage() }}
                                </p>
                                <div class="ms-auto">
                                    @if($teams->onFirstPage())
                                        <button class="btn btn-sm btn-white mb-0" disabled>Previous</button>
                                    @else
                                        <a href="{{ $teams->previousPageUrl() }}" class="btn btn-sm btn-white mb-0">Previous</a>
                                    @endif
                                    
                                    @if($teams->hasMorePages())
                                        <a href="{{ $teams->nextPageUrl() }}" class="btn btn-sm btn-white mb-0">Next</a>
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

        <script>
            // Add confirmation for save actions
            document.addEventListener('DOMContentLoaded', function() {
                const forms = document.querySelectorAll('.schedule-form');
                
                forms.forEach(form => {
                    form.addEventListener('submit', function(e) {
                        const date = form.querySelector('input[name="presentation_date"]').value;
                        const location = form.querySelector('select[name="location"]').value;
                        const time = form.querySelector('select[name="presentation_time"]').value;
                        
                        if (!date || !location || !time) {
                            e.preventDefault();
                            alert('Please fill in all required fields: Date, Location, and Time.');
                            return false;
                        }
                    });
                });
            });
        </script>

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
    </style>
    </main>
</x-app-layout>