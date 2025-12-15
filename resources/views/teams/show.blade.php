<x-app-layout>

<div class="container-fluid py-0">
    <!-- Team Header with Gradient Team Name -->
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-4">
                    <div class="d-sm-flex align-items-center justify-content-between">
                        <div>
                            <!-- Gradient Team Name -->
                            <h3 class="font-weight-bold text-gradient text-primary mb-1">{{ $team->name }}</h3>
                            <p class="text-lg mb-0 text-secondary">{{ $team->description ?? 'Team workspace' }}</p>
                        </div>
                        <div class="mt-2 mt-sm-0">
                            <div class="d-flex flex-wrap gap-2">
                                <span class="badge bg-gradient-info">
                                    <i class="fas fa-user me-1"></i>
                                    Created by: {{ $team->owner->name }}
                                </span>
                                <span class="badge bg-gradient-success">
                                    <i class="fas fa-key me-1"></i>
                                    Join Code: {{ $team->join_code }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Members table -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="simple-card">
                <div class="card-header-simple">
                    <div class="d-sm-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="card-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div>
                                <h5 class="mb-0">Members List</h5>
                                <p class="text-sm opacity-8 mb-0">See information about all members</p>
                            </div>
                        </div>
                        <div class="d-flex">
                            <button type="button" class="btn-white-simple me-2">
                                View all
                            </button>
                            <!-- Only show add member button for team owner -->
                            @if(Auth::id() === $team->owner_id)
                            <button type="button" class="btn-primary-simple" data-bs-toggle="modal" data-bs-target="#addMemberModal">
                                <i class="fas fa-user-plus me-2"></i>
                                Add member
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body-simple">
                    <div class="search-container mb-4">
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="fas fa-search"></i>
                            </span>
                            <input type="text" class="form-control" placeholder="Search members..." id="memberSearch">
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="simple-table">
                            <thead>
                                <tr>
                                    <th>Member</th>
                                    <th>Role</th>
                                    <th class="text-center">Date of Join</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="membersTableBody">
                                @foreach($team->members()->paginate(10) as $member)
                                <tr>
                                    <td>
                                        <div class="member-info">
                                            <div class="member-avatar">
                                                @if($member->avatar)
                                                    <img src="{{ asset('storage/' . $member->avatar) }}" alt="{{ $member->name }}">
                                                @else
                                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($member->name) }}&background=774dd3&color=ffffff&size=150" alt="{{ $member->name }}">
                                                @endif
                                            </div>
                                            <div class="member-details">
                                                <h6>{{ $member->name }}</h6>
                                                <p>{{ $member->email }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($member->id === $team->owner_id)
                                            <div class="role-badge owner">
                                                <i class="fas fa-crown me-1"></i>
                                                Director
                                            </div>
                                            <p class="role-subtitle">Owner</p>
                                        @else
                                            @if(Auth::id() === $team->owner_id)
                                                <!-- Role dropdown for team owner -->
                                                <form action="{{ route('teams.members.updateRole', [$team->id, $member->id]) }}" method="POST" class="role-form">
                                                    @csrf
                                                    @method('PATCH')
                                                    <select name="role" class="form-select role-select" onchange="this.form.submit()">
                                                        <option value="member" {{ ($member->pivot->role ?? 'member') == 'member' ? 'selected' : '' }}>Member</option>
                                                        <option value="secretary" {{ ($member->pivot->role ?? 'member') == 'secretary' ? 'selected' : '' }}>Secretary</option>
                                                        <option value="treasurer" {{ ($member->pivot->role ?? 'member') == 'treasurer' ? 'selected' : '' }}>Treasurer</option>
                                                        <option value="co-director" {{ ($member->pivot->role ?? 'member') == 'co-director' ? 'selected' : '' }}>Co-director</option>
                                                        <option value="director" {{ ($member->pivot->role ?? 'member') == 'director' ? 'selected' : '' }}>Director</option>
                                                    </select>
                                                </form>
                                            @else
                                                <!-- Just display the role for non-owners -->
                                                @php
                                                    $role = $member->pivot->role ?? 'member';
                                                    $roleDisplay = [
                                                        'director' => 'Director',
                                                        'co-director' => 'Co-director', 
                                                        'secretary' => 'Secretary',
                                                        'treasurer' => 'Treasurer',
                                                        'member' => 'Member'
                                                    ][$role] ?? 'Member';
                                                @endphp
                                                <div class="role-badge {{ $role }}">
                                                    {{ $roleDisplay }}
                                                </div>
                                                <p class="role-subtitle">
                                                    {{ $role === 'director' ? 'Owner' : 
                                                    ($role === 'co-director' ? 'Management' :
                                                    ($role === 'secretary' ? 'Administration' :
                                                    ($role === 'treasurer' ? 'Finance' : 'Team Member'))) }}
                                                </p>
                                            @endif
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span class="join-date">
                                            @if($member->pivot->created_at)
                                                {{ $member->pivot->created_at->format('d/m/Y') }}
                                            @else
                                                {{ $member->created_at->format('d/m/Y') }}
                                            @endif
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <div class="dropdown">
                                            <button class="btn-action" type="button" id="memberActions{{ $member->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="memberActions{{ $member->id }}">
                                                <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>View Profile</a></li>
                                                @if(Auth::id() === $team->owner_id && $member->id !== $team->owner_id)
                                                <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-user-times me-2"></i>Remove from Team</a></li>
                                                @endif
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="pagination-container d-flex justify-content-between align-items-center mt-4">
                        <p class="font-weight-semibold mb-0 text-dark text-sm">
                            Showing {{ $team->members()->paginate(10)->firstItem() }} to {{ $team->members()->paginate(10)->lastItem() }} of {{ $team->members()->count() }} members
                        </p>
                        <div class="pagination-controls">
                            @if($team->members()->paginate(10)->onFirstPage())
                                <button class="btn-white-simple me-2" disabled>
                                    <i class="fas fa-chevron-left me-1"></i>
                                    Previous
                                </button>
                            @else
                                <a href="{{ $team->members()->paginate(10)->previousPageUrl() }}" class="btn-white-simple me-2">
                                    <i class="fas fa-chevron-left me-1"></i>
                                    Previous
                                </a>
                            @endif
                            
                            @if($team->members()->paginate(10)->hasMorePages())
                                <a href="{{ $team->members()->paginate(10)->nextPageUrl() }}" class="btn-white-simple">
                                    Next
                                    <i class="fas fa-chevron-right ms-1"></i>
                                </a>
                            @else
                                <button class="btn-white-simple" disabled>
                                    Next
                                    <i class="fas fa-chevron-right ms-1"></i>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Presentation Schedule Card -->
    @if($schedule)
    <div class="row mb-5">
        <div class="col-12">
            <div class="simple-card">
                <div class="card-header-simple">
                    <div class="d-flex align-items-center">
                        <div class="card-icon">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <div>
                            <h5 class="mb-0">Your Presentation Schedule</h5>
                            <p class="text-sm opacity-8 mb-0">Details about your upcoming presentation</p>
                        </div>
                    </div>
                </div>
                <div class="card-body-simple">
                    <div class="schedule-container">
                        <div class="schedule-item">
                            <div class="schedule-icon">
                                <i class="fas fa-calendar-day"></i>
                            </div>
                            <div class="schedule-content">
                                <h6 class="schedule-label">Date</h6>
                                <p class="schedule-value">
                                    {{ $schedule->presentation_date->format('d F Y') }}
                                </p>
                            </div>
                        </div>
                        
                        <div class="schedule-item">
                            <div class="schedule-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="schedule-content">
                                <h6 class="schedule-label">Time</h6>
                                <p class="schedule-value">
                                    {{ \Carbon\Carbon::parse($schedule->presentation_time)->format('h:i A') }}
                                </p>
                            </div>
                        </div>
                        
                        <div class="schedule-item">
                            <div class="schedule-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="schedule-content">
                                <h6 class="schedule-label">Location</h6>
                                <p class="schedule-value">
                                    {{ $schedule->location }}
                                </p>
                            </div>
                        </div>
                        
                        <div class="schedule-item">
                            <div class="schedule-icon">
                                <i class="fas fa-sticky-note"></i>
                            </div>
                            <div class="schedule-content">
                                <h6 class="schedule-label">Notes</h6>
                                <p class="schedule-value">
                                    {{ $schedule->notes ?? 'No additional notes' }}
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <button class="btn-primary-simple">
                            <i class="fas fa-bell me-2"></i>
                            Set Reminder
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="row mb-4">
        <div class="col-12">
            <div class="simple-card">
                <div class="card-header-simple">
                    <div class="d-flex align-items-center">
                        <div class="card-icon">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <div>
                            <h5 class="mb-0">Presentation Schedule</h5>
                            <p class="text-sm opacity-8 mb-0">Your upcoming presentation details</p>
                        </div>
                    </div>
                </div>
                <div class="card-body-simple">
                    <div class="empty-state text-center py-5">
                        <div class="empty-icon">
                            <i class="fas fa-calendar-times"></i>
                        </div>
                        <h6 class="empty-title">No Presentation Scheduled Yet</h6>
                        <p class="empty-description">Your presentation schedule will be announced soon.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Tab Navigation for Proposals, Reports and Finance -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="simple-card">
                <div class="card-header-simple">
                    <div class="d-sm-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="card-icon">
                                <i class="fas fa-folder-open"></i>
                            </div>
                            <div>
                                <h5 class="mb-0">Team Documents & Finance</h5>
                                <p class="text-sm opacity-8 mb-0">Manage proposals, reports and financial tracking</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Tab Navigation -->
                    <ul class="nav nav-tabs-custom mt-3" id="documentsTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link-custom active" id="proposals-tab" data-bs-toggle="tab" data-bs-target="#proposals" type="button" role="tab" aria-controls="proposals" aria-selected="true">
                                <i class="fas fa-file-alt me-2"></i>Proposals
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link-custom" id="reports-tab" data-bs-toggle="tab" data-bs-target="#reports" type="button" role="tab" aria-controls="reports" aria-selected="false">
                                <i class="fas fa-chart-bar me-2"></i>Reports
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link-custom" id="finance-tab" data-bs-toggle="tab" data-bs-target="#finance" type="button" role="tab" aria-controls="finance" aria-selected="false">
                                <i class="fas fa-money-bill-wave me-2"></i>Finance
                            </button>
                        </li>
                    </ul>
                </div>
                
                <div class="card-body-simple">
                    <div class="tab-content" id="documentsTabContent">
                        <!-- Proposals Tab -->
                        <div class="tab-pane fade show active" id="proposals" role="tabpanel" aria-labelledby="proposals-tab">
                            <div class="table-actions-container d-flex justify-content-between align-items-center mb-4">
                                <div class="d-flex">
                                    <button type="button" class="btn-white-simple me-2">
                                        View all
                                    </button>
                                    <button type="button"
                                        class="btn-primary-simple"
                                        data-bs-toggle="modal" data-bs-target="#addProposalModal">
                                        <i class="fas fa-plus me-2"></i>
                                        Add Proposal
                                    </button>
                                </div>
                                <div class="search-container">
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-search"></i>
                                        </span>
                                        <input type="text" class="form-control" placeholder="Search proposals">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="table-responsive">
                                <table class="simple-table">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Submitted By</th>
                                            <th class="text-center">Date Submitted</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">File</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($proposals as $proposal)
                                        <tr>
                                            <td>
                                                <div class="document-info">
                                                    <h6 class="document-title">{{ $proposal->title }}</h6>
                                                    <p class="document-summary">{{ $proposal->summary }}</p>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="submitter-info">
                                                    <p class="submitter-name">{{ $proposal->user->name }}</p>
                                                    <p class="submitter-role">
                                                        @if($proposal->user->id === $team->owner_id)
                                                            Owner
                                                        @else
                                                            @php
                                                                $member = $team->members->where('id', $proposal->user->id)->first();
                                                                $role = $member->pivot->role ?? 'member';
                                                                $roleDisplay = [
                                                                    'director' => 'Director',
                                                                    'co-director' => 'Co-director', 
                                                                    'secretary' => 'Secretary',
                                                                    'treasurer' => 'Treasurer',
                                                                    'member' => 'Member'
                                                                ][$role] ?? 'Member';
                                                            @endphp
                                                            {{ $roleDisplay }}
                                                        @endif
                                                    </p>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <span class="date-badge">
                                                    {{ $proposal->created_at->format('d/m/Y') }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                @if($proposal->status === 'approved')
                                                    <span class="status-badge approved">
                                                        <i class="fas fa-check-circle me-1"></i>
                                                        Approved
                                                    </span>
                                                @elseif($proposal->status === 'rejected')
                                                    <span class="status-badge rejected">
                                                        <i class="fas fa-times-circle me-1"></i>
                                                        Rejected
                                                    </span>
                                                @else
                                                    <span class="status-badge pending">
                                                        <i class="fas fa-clock me-1"></i>
                                                        Pending
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('proposals.download', $proposal) }}" class="btn-download" data-bs-toggle="tooltip" data-bs-placement="top" title="Download file">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                @if(auth()->id() === $proposal->user_id || auth()->id() === $team->owner_id)
                                                    <form action="{{ route('proposals.destroy', $proposal) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn-delete" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete proposal" onclick="return confirm('Are you sure you want to delete this proposal?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="no-access">No access</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <!-- Reports Tab -->
                        <div class="tab-pane fade" id="reports" role="tabpanel" aria-labelledby="reports-tab">
                            <div class="table-actions-container d-flex justify-content-between align-items-center mb-4">
                                <div class="d-flex">
                                    <button type="button" class="btn-white-simple me-2">
                                        View all
                                    </button>
                                    <button type="button"
                                        class="btn-primary-simple"
                                        data-bs-toggle="modal" data-bs-target="#addReportModal">
                                        <i class="fas fa-plus me-2"></i>
                                        Add Report
                                    </button>
                                </div>
                                <div class="search-container">
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-search"></i>
                                        </span>
                                        <input type="text" class="form-control" placeholder="Search reports">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="table-responsive">
                                <table class="simple-table">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Submitted By</th>
                                            <th class="text-center">Date Submitted</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">File</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($reports as $report)
                                        <tr>
                                            <td>
                                                <div class="document-info">
                                                    <h6 class="document-title">{{ $report->title }}</h6>
                                                    <p class="document-summary">{{ $report->summary }}</p>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="submitter-info">
                                                    <p class="submitter-name">{{ $report->user->name }}</p>
                                                    <p class="submitter-role">
                                                        @if($report->user->id === $team->owner_id)
                                                            Owner
                                                        @else
                                                            @php
                                                                $member = $team->members->where('id', $report->user->id)->first();
                                                                $role = $member->pivot->role ?? 'member';
                                                                $roleDisplay = [
                                                                    'director' => 'Director',
                                                                    'co-director' => 'Co-director', 
                                                                    'secretary' => 'Secretary',
                                                                    'treasurer' => 'Treasurer',
                                                                    'member' => 'Member'
                                                                ][$role] ?? 'Member';
                                                            @endphp
                                                            {{ $roleDisplay }}
                                                        @endif
                                                    </p>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <span class="date-badge">
                                                    {{ $report->created_at->format('d/m/Y') }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                @if($report->status === 'approved')
                                                    <span class="status-badge approved">
                                                        <i class="fas fa-check-circle me-1"></i>
                                                        Approved
                                                    </span>
                                                @elseif($report->status === 'rejected')
                                                    <span class="status-badge rejected">
                                                        <i class="fas fa-times-circle me-1"></i>
                                                        Rejected
                                                    </span>
                                                @else
                                                    <span class="status-badge pending">
                                                        <i class="fas fa-clock me-1"></i>
                                                        Pending
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('reports.download', $report) }}" class="btn-download" data-bs-toggle="tooltip" data-bs-placement="top" title="Download file">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                @if(auth()->id() === $report->user_id || auth()->id() === $team->owner_id)
                                                    <form action="{{ route('reports.destroy', $report) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn-delete" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete report" onclick="return confirm('Are you sure you want to delete this report?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="no-access">No access</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <!-- Finance Tab -->
                        <div class="tab-pane fade" id="finance" role="tabpanel" aria-labelledby="finance-tab">
                            <div class="finance-container text-center py-5">
                                <div class="finance-icon mb-4">
                                    <i class="fas fa-money-bill-wave"></i>
                                </div>
                                <h5 class="finance-title mb-3">Finance Management</h5>
                                <p class="finance-description mb-4">Manage team expenses and financial tracking</p>
                                <a href="{{ route('teams.finance', $team) }}" class="btn-primary-simple">
                                    <i class="fas fa-external-link-alt me-2"></i>Go to Finance Dashboard
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addProposalModal" tabindex="-1" role="dialog" aria-labelledby="addProposalModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content border-0 shadow-lg">
            <!-- Header -->
            <div class="modal-header bg-gradient-primary text-white">
                <div class="d-flex align-items-center">
                    <div>
                        <h5 class="modal-title mb-0 text-white" id="addProposalModalLabel">Submit New Proposal</h5>
                        <p class="text-white text-xs mb-0 opacity-80">Fill in details below to submit your proposal</p>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('proposals.store', $team) }}" method="POST" enctype="multipart/form-data" id="proposalForm">
                @csrf
                <div class="modal-body p-4">
                    <!-- Progress Steps -->
                    <div class="steps-progress mb-4">
                        <div class="steps">
                            <div class="step active" data-step="1">
                                <div class="step-number">1</div>
                                <span class="step-label">Basic Info</span>
                            </div>
                            <div class="step" data-step="2">
                                <div class="step-number">2</div>
                                <span class="step-label">File Upload</span>
                            </div>
                            <div class="step" data-step="3">
                                <div class="step-number">3</div>
                                <span class="step-label">Review</span>
                            </div>
                        </div>
                    </div>

                    <!-- Step 1: Basic Information -->
                    <div class="step-content" data-step="1">
                        <div class="mb-4">
                            <label for="proposalTitle" class="form-label fw-semibold text-dark mb-2">
                                Proposal Title <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control form-control-lg border-radius-lg" 
                                id="proposalTitle" name="title" 
                                placeholder="Enter a clear and descriptive title for your proposal" 
                                maxlength="255" required>
                            <div class="form-text text-end">
                                <span id="titleCount">0</span>/255 characters
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="proposalSummary" class="form-label fw-semibold text-dark mb-2">
                                Executive Summary
                            </label>
                            <textarea class="form-control border-radius-lg" id="proposalSummary" 
                                    name="summary" rows="4" 
                                    placeholder="Provide a brief overview of your proposal's objectives, methodology, and expected outcomes..."></textarea>
                            <div class="form-text text-end">
                                <span id="summaryCount">0</span> characters
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: File Upload -->
                    <div class="step-content d-none" data-step="2">
                        <div class="file-upload-area text-center p-4 border border-dashed border-radius-lg bg-gray-100">
                            <div class="upload-icon mb-3">
                                <i class="fas fa-cloud-upload-alt text-primary fa-3x opacity-60"></i>
                            </div>
                            <h6 class="mb-2">Upload Proposal File</h6>
                            <p class="text-sm text-muted mb-3">Drag & drop your file here or click to browse</p>
                            
                            <input type="file" class="d-none" id="proposalFile" name="file" required>
                            <button type="button" class="btn bg-gradient-primary mb-3" id="browseFileBtn">
                                <i class="fas fa-folder-open me-2"></i>Browse Files
                            </button>
                            
                            <div class="file-info d-none" id="fileInfo">
                                <div class="alert alert-success border-radius-lg p-3">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1" id="fileName">File selected</h6>
                                            <p class="mb-0 text-xs" id="fileSize">File size will appear here</p>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-outline-danger" id="removeFileBtn">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="supported-formats mt-3">
                                <p class="text-xs text-muted mb-1">Supported formats:</p>
                                <div class="d-flex justify-content-center gap-3">
                                    <span class="badge badge-sm bg-gray-200 text-dark">PDF</span>
                                    <span class="badge badge-sm bg-gray-200 text-dark">DOC</span>
                                    <span class="badge badge-sm bg-gray-200 text-dark">DOCX</span>
                                    <span class="badge badge-sm bg-gray-200 text-dark">PPT</span>
                                    <span class="badge badge-sm bg-gray-200 text-dark">PPTX</span>
                                </div>
                                <p class="text-xs text-muted mt-2">Maximum file size: 10MB</p>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Review -->
                    <div class="step-content d-none" data-step="3">
                        <div class="review-section">
                            <h6 class="text-dark mb-3">Review Your Proposal</h6>
                            
                            <div class="card border shadow-xs mb-3">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <h6 class="text-sm text-muted mb-1">Title</h6>
                                            <p class="text-dark font-weight-semibold" id="reviewTitle">-</p>
                                        </div>
                                        <div class="col-12 mt-3">
                                            <h6 class="text-sm text-muted mb-1">Summary</h6>
                                            <p class="text-dark" id="reviewSummary">-</p>
                                        </div>
                                        <div class="col-12 mt-3">
                                            <h6 class="text-sm text-muted mb-1">File</h6>
                                            <p class="text-dark font-weight-semibold" id="reviewFileName">-</p>
                                            <p class="text-xs text-muted mb-0" id="reviewFileSize">-</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="alert alert-info border-radius-lg">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-info-circle text-info me-2"></i>
                                    <span class="text-sm">Please review all information before submitting. You can go back to make changes if needed.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer with Navigation -->
                <div class="modal-footer bg-gray-100 border-top">
                    <div class="w-100 d-flex justify-content-between align-items-center">
                        <button type="button" class="btn btn-outline-secondary" id="prevStepBtn" style="display: none;">
                            <i class="fas fa-arrow-left me-2"></i>Previous
                        </button>
                        
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-white" data-bs-dismiss="modal">
                                Cancel
                            </button>
                            <button type="button" class="btn bg-gradient-primary" id="nextStepBtn">
                                Next <i class="fas fa-arrow-right ms-2"></i>
                            </button>
                            <button type="submit" class="btn bg-gradient-success" id="submitBtn" style="display: none;">
                                <i class="fas fa-paper-plane me-2"></i>Submit Proposal
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Report Modal -->
<div class="modal fade" id="addReportModal" tabindex="-1" role="dialog" aria-labelledby="addReportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content border-0 shadow-lg">
            <!-- Header -->
            <div class="modal-header bg-gradient-info text-white">
                <div class="d-flex align-items-center">
                    <div>
                        <h5 class="modal-title mb-0 text-white" id="addReportModalLabel">Submit New Report</h5>
                        <p class="text-white text-xs mb-0 opacity-80">Fill in details below to submit your report</p>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('reports.store', $team) }}" method="POST" enctype="multipart/form-data" id="reportForm">
                @csrf
                <div class="modal-body p-4">
                    <!-- Progress Steps -->
                    <div class="steps-progress mb-4">
                        <div class="steps">
                            <div class="step active" data-step="1">
                                <div class="step-number">1</div>
                                <span class="step-label">Basic Info</span>
                            </div>
                            <div class="step" data-step="2">
                                <div class="step-number">2</div>
                                <span class="step-label">File Upload</span>
                            </div>
                            <div class="step" data-step="3">
                                <div class="step-number">3</div>
                                <span class="step-label">Review</span>
                            </div>
                        </div>
                    </div>

                    <!-- Step 1: Basic Information -->
                    <div class="step-content" data-step="1">
                        <div class="mb-4">
                            <label for="reportTitle" class="form-label fw-semibold text-dark mb-2">
                                Report Title <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control form-control-lg border-radius-lg" 
                                id="reportTitle" name="title" 
                                placeholder="Enter a clear and descriptive title for your report" 
                                maxlength="255" required>
                            <div class="form-text text-end">
                                <span id="reportTitleCount">0</span>/255 characters
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="reportSummary" class="form-label fw-semibold text-dark mb-2">
                                Executive Summary
                            </label>
                            <textarea class="form-control border-radius-lg" id="reportSummary" 
                                    name="summary" rows="4" 
                                    placeholder="Provide a brief overview of your report's findings, analysis, and conclusions..."></textarea>
                            <div class="form-text text-end">
                                <span id="reportSummaryCount">0</span> characters
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: File Upload -->
                    <div class="step-content d-none" data-step="2">
                        <div class="file-upload-area text-center p-4 border border-dashed border-radius-lg bg-gray-100">
                            <div class="upload-icon mb-3">
                                <i class="fas fa-cloud-upload-alt text-info fa-3x opacity-60"></i>
                            </div>
                            <h6 class="mb-2">Upload Report File</h6>
                            <p class="text-sm text-muted mb-3">Drag & drop your file here or click to browse</p>
                            
                            <input type="file" class="d-none" id="reportFile" name="file" required>
                            <button type="button" class="btn bg-gradient-info mb-3" id="browseReportFileBtn">
                                <i class="fas fa-folder-open me-2"></i>Browse Files
                            </button>
                            
                            <div class="file-info d-none" id="reportFileInfo">
                                <div class="alert alert-success border-radius-lg p-3">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1" id="reportFileName">File selected</h6>
                                            <p class="mb-0 text-xs" id="reportFileSize">File size will appear here</p>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-outline-danger" id="removeReportFileBtn">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="supported-formats mt-3">
                                <p class="text-xs text-muted mb-1">Supported formats:</p>
                                <div class="d-flex justify-content-center gap-2 flex-wrap">
                                    <span class="badge badge-sm bg-gray-200 text-dark">PDF</span>
                                    <span class="badge badge-sm bg-gray-200 text-dark">DOC</span>
                                    <span class="badge badge-sm bg-gray-200 text-dark">DOCX</span>
                                    <span class="badge badge-sm bg-gray-200 text-dark">PPT</span>
                                    <span class="badge badge-sm bg-gray-200 text-dark">PPTX</span>
                                    <span class="badge badge-sm bg-gray-200 text-dark">XLS</span>
                                    <span class="badge badge-sm bg-gray-200 text-dark">XLSX</span>
                                </div>
                                <p class="text-xs text-muted mt-2">Maximum file size: 10MB</p>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Review -->
                    <div class="step-content d-none" data-step="3">
                        <div class="review-section">
                            <h6 class="text-dark mb-3">Review Your Report</h6>
                            
                            <div class="card border shadow-xs mb-3">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <h6 class="text-sm text-muted mb-1">Title</h6>
                                            <p class="text-dark font-weight-semibold" id="reviewReportTitle">-</p>
                                        </div>
                                        <div class="col-12 mt-3">
                                            <h6 class="text-sm text-muted mb-1">Summary</h6>
                                            <p class="text-dark" id="reviewReportSummary">-</p>
                                        </div>
                                        <div class="col-12 mt-3">
                                            <h6 class="text-sm text-muted mb-1">File</h6>
                                            <p class="text-dark font-weight-semibold" id="reviewReportFileName">-</p>
                                            <p class="text-xs text-muted mb-0" id="reviewReportFileSize">-</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="alert alert-info border-radius-lg">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-info-circle text-info me-2"></i>
                                    <span class="text-sm">Please review all information before submitting. You can go back to make changes if needed.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer with Navigation -->
                <div class="modal-footer bg-gray-100 border-top">
                    <div class="w-100 d-flex justify-content-between align-items-center">
                        <button type="button" class="btn btn-outline-secondary" id="prevReportStepBtn" style="display: none;">
                            <i class="fas fa-arrow-left me-2"></i>Previous
                        </button>
                        
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-white" data-bs-dismiss="modal">
                                Cancel
                            </button>
                            <button type="button" class="btn bg-gradient-info" id="nextReportStepBtn">
                                Next <i class="fas fa-arrow-right ms-2"></i>
                            </button>
                            <button type="submit" class="btn bg-gradient-success" id="submitReportBtn" style="display: none;">
                                <i class="fas fa-paper-plane me-2"></i>Submit Report
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
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
    color: #ffffff;
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

.btn-close-white {
    background: none;
    border: none;
    font-size: 1.5rem;
    color: rgba(255, 255, 255, 0.7);
    transition: all 0.2s ease;
}

.btn-close-white:hover {
    color: white;
}

.bg-gradient-primary {
    background: linear-gradient(87deg, #5e72e4 0%, #825ee4 100%);
    border: none;
}

.bg-gradient-info {
    background: linear-gradient(87deg, #11cdef 0%, #3b82f6 100%);
    border: none;
}

.bg-gradient-success {
    background: linear-gradient(87deg, #10b981 0%, #059669 100%);
    border: none;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Bootstrap modals
    var proposalModal = new bootstrap.Modal(document.getElementById('addProposalModal'));
    var reportModal = new bootstrap.Modal(document.getElementById('addReportModal'));
    
    // Proposal Modal Scripts
    let currentStep = 1;
    const totalSteps = 3;
    const form = document.getElementById('proposalForm');
    const fileInput = document.getElementById('proposalFile');
    const browseFileBtn = document.getElementById('browseFileBtn');
    const removeFileBtn = document.getElementById('removeFileBtn');
    const fileInfo = document.getElementById('fileInfo');
    const uploadArea = document.querySelector('#addProposalModal .file-upload-area');
    
    // Character counters
    const titleInput = document.getElementById('proposalTitle');
    const summaryInput = document.getElementById('proposalSummary');
    const titleCount = document.getElementById('titleCount');
    const summaryCount = document.getElementById('summaryCount');
    
    // Navigation buttons
    const prevStepBtn = document.getElementById('prevStepBtn');
    const nextStepBtn = document.getElementById('nextStepBtn');
    const submitBtn = document.getElementById('submitBtn');
    
    // Review elements
    const reviewTitle = document.getElementById('reviewTitle');
    const reviewSummary = document.getElementById('reviewSummary');
    const reviewFileName = document.getElementById('reviewFileName');
    const reviewFileSize = document.getElementById('reviewFileSize');
    
    if (!form) return;
    
    // Character counting
    titleInput.addEventListener('input', function() {
        titleCount.textContent = this.value.length;
    });
    
    summaryInput.addEventListener('input', function() {
        summaryCount.textContent = this.value.length;
    });
    
    // File upload handling
    browseFileBtn.addEventListener('click', function() {
        fileInput.click();
    });
    
    fileInput.addEventListener('change', function(e) {
        if (this.files.length > 0) {
            const file = this.files[0];
            updateFileInfo(file);
        }
    });
    
    // Drag and drop functionality
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        uploadArea.addEventListener(eventName, preventDefaults, false);
    });
    
    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }
    
    ['dragenter', 'dragover'].forEach(eventName => {
        uploadArea.addEventListener(eventName, highlight, false);
    });
    
    ['dragleave', 'drop'].forEach(eventName => {
        uploadArea.addEventListener(eventName, unhighlight, false);
    });
    
    function highlight() {
        uploadArea.classList.add('dragover');
    }
    
    function unhighlight() {
        uploadArea.classList.remove('dragover');
    }
    
    uploadArea.addEventListener('drop', function(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        fileInput.files = files;
        if (files.length > 0) {
            updateFileInfo(files[0]);
        }
    });
    
    function updateFileInfo(file) {
        const fileName = document.getElementById('fileName');
        const fileSize = document.getElementById('fileSize');
        
        fileName.textContent = file.name;
        fileSize.textContent = formatFileSize(file.size);
        fileInfo.classList.remove('d-none');
        
        // Update review section
        reviewFileName.textContent = file.name;
        reviewFileSize.textContent = formatFileSize(file.size);
    }
    
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }
    
    removeFileBtn.addEventListener('click', function() {
        fileInput.value = '';
        fileInfo.classList.add('d-none');
        reviewFileName.textContent = '-';
        reviewFileSize.textContent = '-';
    });
    
    // Step navigation
    function updateStepNavigation() {
        // Update step indicators
        document.querySelectorAll('#addProposalModal .step').forEach((step, index) => {
            if (index + 1 <= currentStep) {
                step.classList.add('active');
            } else {
                step.classList.remove('active');
            }
        });
        
        // Show/hide step content
        document.querySelectorAll('#addProposalModal .step-content').forEach(content => {
            if (parseInt(content.dataset.step) === currentStep) {
                content.classList.remove('d-none');
            } else {
                content.classList.add('d-none');
            }
        });
        
        // Update navigation buttons
        prevStepBtn.style.display = currentStep > 1 ? 'block' : 'none';
        
        if (currentStep === totalSteps) {
            nextStepBtn.style.display = 'none';
            submitBtn.style.display = 'block';
            updateReviewSection();
        } else {
            nextStepBtn.style.display = 'block';
            submitBtn.style.display = 'none';
        }
    }
    
    function updateReviewSection() {
        reviewTitle.textContent = titleInput.value || '-';
        reviewSummary.textContent = summaryInput.value || '-';
    }
    
    function validateStep(step) {
        switch(step) {
            case 1:
                return titleInput.value.trim() !== '';
            case 2:
                return fileInput.files.length > 0;
            case 3:
                return true;
            default:
                return false;
        }
    }
    
    nextStepBtn.addEventListener('click', function() {
        if (validateStep(currentStep)) {
            currentStep++;
            updateStepNavigation();
        } else {
            // Show validation error
            const stepName = currentStep === 1 ? 'Basic Information' : 'File Upload';
            alert(`Please complete ${stepName} step before proceeding.`);
        }
    });
    
    prevStepBtn.addEventListener('click', function() {
        currentStep--;
        updateStepNavigation();
    });
    
    // Form submission validation
    form.addEventListener('submit', function(e) {
        if (!validateStep(1) || !validateStep(2)) {
            e.preventDefault();
            alert('Please complete all required fields before submitting.');
        }
    });
    
    // Initialize
    updateStepNavigation();
    
    // Report Modal Scripts
    let currentReportStep = 1;
    const totalReportSteps = 3;
    const reportForm = document.getElementById('reportForm');
    const reportFileInput = document.getElementById('reportFile');
    const browseReportFileBtn = document.getElementById('browseReportFileBtn');
    const removeReportFileBtn = document.getElementById('removeReportFileBtn');
    const reportFileInfo = document.getElementById('reportFileInfo');
    const reportUploadArea = document.querySelector('#addReportModal .file-upload-area');
    
    // Character counters
    const reportTitleInput = document.getElementById('reportTitle');
    const reportSummaryInput = document.getElementById('reportSummary');
    const reportTitleCount = document.getElementById('reportTitleCount');
    const reportSummaryCount = document.getElementById('reportSummaryCount');
    
    // Navigation buttons
    const prevReportStepBtn = document.getElementById('prevReportStepBtn');
    const nextReportStepBtn = document.getElementById('nextReportStepBtn');
    const submitReportBtn = document.getElementById('submitReportBtn');
    
    // Review elements
    const reviewReportTitle = document.getElementById('reviewReportTitle');
    const reviewReportSummary = document.getElementById('reviewReportSummary');
    const reviewReportFileName = document.getElementById('reviewReportFileName');
    const reviewReportFileSize = document.getElementById('reviewReportFileSize');
    
    if (!reportForm) return;
    
    // Character counting
    reportTitleInput.addEventListener('input', function() {
        reportTitleCount.textContent = this.value.length;
    });
    
    reportSummaryInput.addEventListener('input', function() {
        reportSummaryCount.textContent = this.value.length;
    });
    
    // File upload handling
    browseReportFileBtn.addEventListener('click', function() {
        reportFileInput.click();
    });
    
    reportFileInput.addEventListener('change', function(e) {
        if (this.files.length > 0) {
            const file = this.files[0];
            updateReportFileInfo(file);
        }
    });
    
    // Drag and drop functionality
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        reportUploadArea.addEventListener(eventName, preventDefaults, false);
    });
    
    ['dragenter', 'dragover'].forEach(eventName => {
        reportUploadArea.addEventListener(eventName, function() {
            this.classList.add('dragover');
        }, false);
    });
    
    ['dragleave', 'drop'].forEach(eventName => {
        reportUploadArea.addEventListener(eventName, function() {
            this.classList.remove('dragover');
        }, false);
    });
    
    reportUploadArea.addEventListener('drop', function(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        reportFileInput.files = files;
        if (files.length > 0) {
            updateReportFileInfo(files[0]);
        }
    });
    
    function updateReportFileInfo(file) {
        const reportFileName = document.getElementById('reportFileName');
        const reportFileSize = document.getElementById('reportFileSize');
        
        reportFileName.textContent = file.name;
        reportFileSize.textContent = formatFileSize(file.size);
        reportFileInfo.classList.remove('d-none');
        
        // Update review section
        reviewReportFileName.textContent = file.name;
        reviewReportFileSize.textContent = formatFileSize(file.size);
    }
    
    removeReportFileBtn.addEventListener('click', function() {
        reportFileInput.value = '';
        reportFileInfo.classList.add('d-none');
        reviewReportFileName.textContent = '-';
        reviewReportFileSize.textContent = '-';
    });
    
    // Step navigation
    function updateReportStepNavigation() {
        // Update step indicators
        document.querySelectorAll('#addReportModal .step').forEach((step, index) => {
            if (index + 1 <= currentReportStep) {
                step.classList.add('active');
            } else {
                step.classList.remove('active');
            }
        });
        
        // Show/hide step content
        document.querySelectorAll('#addReportModal .step-content').forEach(content => {
            if (parseInt(content.dataset.step) === currentReportStep) {
                content.classList.remove('d-none');
            } else {
                content.classList.add('d-none');
            }
        });
        
        // Update navigation buttons
        prevReportStepBtn.style.display = currentReportStep > 1 ? 'block' : 'none';
        
        if (currentReportStep === totalReportSteps) {
            nextReportStepBtn.style.display = 'none';
            submitReportBtn.style.display = 'block';
            updateReportReviewSection();
        } else {
            nextReportStepBtn.style.display = 'block';
            submitReportBtn.style.display = 'none';
        }
    }
    
    function updateReportReviewSection() {
        reviewReportTitle.textContent = reportTitleInput.value || '-';
        reviewReportSummary.textContent = reportSummaryInput.value || '-';
    }
    
    function validateReportStep(step) {
        switch(step) {
            case 1:
                return reportTitleInput.value.trim() !== '';
            case 2:
                return reportFileInput.files.length > 0;
            case 3:
                return true;
            default:
                return false;
        }
    }
    
    nextReportStepBtn.addEventListener('click', function() {
        if (validateReportStep(currentReportStep)) {
            currentReportStep++;
            updateReportStepNavigation();
        } else {
            // Show validation error
            const stepName = currentReportStep === 1 ? 'Basic Information' : 'File Upload';
            alert(`Please complete ${stepName} step before proceeding.`);
        }
    });
    
    prevReportStepBtn.addEventListener('click', function() {
        currentReportStep--;
        updateReportStepNavigation();
    });
    
    // Form submission validation
    reportForm.addEventListener('submit', function(e) {
        if (!validateReportStep(1) || !validateReportStep(2)) {
            e.preventDefault();
            alert('Please complete all required fields before submitting.');
        }
    });
    
    // Initialize
    updateReportStepNavigation();
});
</script>

<style>
/* Color Variables */
:root {
    --primary: #774dd3;
    --secondary: #64748b;
    --white: #FFFFFF;
    --dark: #1E293B;
    --light-bg: rgba(255, 255, 255, 0.8);
    --border-color: rgba(100, 116, 139, 0.5);
    --border-dark: rgba(30, 41, 59, 0.6);
    --success: #10b981;
    --warning: #f59e0b;
    --danger: #ef4444;
    --info: #3b82f6;
}

/* Simple Card Styles */
.simple-card {
    background: var(--light-bg);
    backdrop-filter: blur(10px);
    border-radius: 12px;
    border: 2px solid var(--border-color);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    overflow: hidden;
    height: 100%;
    transition: transform 0.2s ease;
}

.card-header-simple {
    background: linear-gradient(135deg, rgba(73, 0, 230, 0.1) 0%, rgba(73, 0, 230, 0.1) 100%);
    padding: 1.5rem;
    border-bottom: 2px solid var(--border-color);
}

.card-header-simple p {
    color: var(--secondary);
    font-size: 0.9rem;
}

.card-icon {
    width: 50px;
    height: 50px;
    border-radius: 10px;
    background: var(--primary);
    color: var(--white);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
    font-size: 1.2rem;
}

.card-body-simple {
    padding: 1.5rem;
}

/* Button Styles */
.btn-primary-simple {
    background: var(--primary);
    border: 2px solid var(--primary);
    border-radius: 8px;
    padding: 0.75rem 1.5rem;
    color: var(--white);
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
    text-decoration: none;
}

.btn-primary-simple:hover {
    background: #6439b3;
    border-color: #6439b3;
    color: var(--white);
}

.btn-white-simple {
    background: var(--white);
    border: 2px solid var(--border-color);
    border-radius: 8px;
    padding: 0.75rem 1.5rem;
    color: var(--dark);
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
    text-decoration: none;
}

.btn-white-simple:hover:not(:disabled) {
    background: #f8fafc;
    border-color: var(--border-dark);
}

.btn-white-simple:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

.btn-info-simple {
    background: var(--info);
    border: 2px solid var(--info);
    border-radius: 8px;
    padding: 0.75rem 1.5rem;
    color: var(--white);
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
    text-decoration: none;
}

.btn-info-simple:hover {
    background: #2563eb;
    border-color: #2563eb;
}

.btn-success-simple {
    background: var(--success);
    border: 2px solid var(--success);
    border-radius: 8px;
    padding: 0.75rem 1.5rem;
    color: var(--white);
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
    text-decoration: none;
}

.btn-success-simple:hover {
    background: #059669;
    border-color: #059669;
}

/* Form Styles */
.form-control {
    background: var(--white);
    border: 2px solid var(--border-color);
    border-radius: 8px;
    padding: 0.75rem;
    color: var(--dark);
    transition: border-color 0.2s ease;
}

.form-control:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(119, 77, 211, 0.1);
    outline: none;
}

.form-label {
    color: var(--dark);
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.form-text {
    color: var(--secondary);
    font-size: 0.875rem;
}

.input-group-text {
    background: var(--white);
    border: 2px solid var(--border-color);
    border-right: none;
    color: var(--primary);
}

/* Table Styles */
.simple-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}

.simple-table th {
    background: rgba(119, 77, 211, 0.05);
    padding: 1rem;
    text-align: left;
    font-weight: 600;
    color: var(--dark);
    font-size: 0.9rem;
    border-bottom: 2px solid var(--border-color);
}

.simple-table td {
    padding: 1rem;
    vertical-align: middle;
    border-bottom: 1px solid var(--border-color);
}

.simple-table tr:last-child td {
    border-bottom: none;
}

.simple-table tr:hover td {
    background: rgba(119, 77, 211, 0.03);
}

.table-actions-container {
    margin-bottom: 1rem;
}

/* Member Info Styles */
.member-info {
    display: flex;
    align-items: center;
}

.member-avatar {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    overflow: hidden;
    margin-right: 1rem;
    border: 2px solid var(--border-color);
}

.member-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.member-details h6 {
    margin: 0;
    font-weight: 600;
    color: var(--dark);
}

.member-details p {
    margin: 0;
    font-size: 0.85rem;
    color: var(--secondary);
}

/* Role Badge Styles */
.role-badge {
    display: inline-flex;
    align-items: center;
    padding: 0.35rem 0.75rem;
    border-radius: 6px;
    font-size: 0.85rem;
    font-weight: 600;
    margin-bottom: 0.25rem;
}

.role-badge.owner {
    background: rgba(239, 68, 68, 0.1);
    color: var(--danger);
}

.role-badge.director {
    background: rgba(239, 68, 68, 0.1);
    color: var(--danger);
}

.role-badge.co-director {
    background: rgba(245, 158, 11, 0.1);
    color: var(--warning);
}

.role-badge.secretary {
    background: rgba(59, 130, 246, 0.1);
    color: var(--info);
}

.role-badge.treasurer {
    background: rgba(16, 185, 129, 0.1);
    color: var(--success);
}

.role-badge.member {
    background: rgba(100, 116, 139, 0.1);
    color: var(--secondary);
}

.role-subtitle {
    font-size: 0.75rem;
    color: var(--secondary);
    margin: 0;
}

.role-select {
    background: var(--white);
    border: 2px solid var(--border-color);
    border-radius: 8px;
    padding: 0.5rem;
    font-size: 0.85rem;
    color: var(--dark);
}

/* Date Badge Styles */
.date-badge {
    background: rgba(100, 116, 139, 0.1);
    padding: 0.35rem 0.75rem;
    border-radius: 6px;
    font-size: 0.85rem;
    color: var(--secondary);
    display: inline-block;
}

.join-date {
    background: rgba(100, 116, 139, 0.1);
    padding: 0.35rem 0.75rem;
    border-radius: 6px;
    font-size: 0.85rem;
    color: var(--secondary);
}

/* Action Button Styles */
.btn-action {
    background: transparent;
    border: none;
    color: var(--secondary);
    padding: 0.5rem;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-action:hover {
    background: rgba(100, 116, 139, 0.1);
    color: var(--dark);
}

.btn-download {
    color: var(--primary);
    background: rgba(119, 77, 211, 0.1);
    width: 32px;
    height: 32px;
    border-radius: 6px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
}

.btn-download:hover {
    background: var(--primary);
    color: var(--white);
}

.btn-delete {
    color: var(--danger);
    background: rgba(239, 68, 68, 0.1);
    width: 32px;
    height: 32px;
    border-radius: 6px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
    border: none;
}

.btn-delete:hover {
    background: var(--danger);
    color: var(--white);
}

.btn-remove {
    background: none;
    border: none;
    color: var(--danger);
    font-size: 1rem;
    cursor: pointer;
    padding: 0.25rem;
    border-radius: 4px;
    transition: all 0.2s ease;
}

.btn-remove:hover {
    background: rgba(239, 68, 68, 0.1);
}

.no-access {
    color: var(--secondary);
    font-size: 0.85rem;
}

/* Dropdown Menu Styles */
.dropdown-menu {
    background: var(--white);
    border: 2px solid var(--border-color);
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
}

.dropdown-item {
    color: var(--dark);
    padding: 0.5rem 1rem;
    transition: all 0.2s ease;
    text-decoration: none;
}

.dropdown-item:hover {
    background: rgba(119, 77, 211, 0.05);
    color: var(--primary);
}

.dropdown-item.text-danger:hover {
    background: rgba(239, 68, 68, 0.05);
    color: var(--danger);
}

/* Search Container Styles */
.search-container {
    max-width: 300px;
    margin-left: auto;
}

/* Pagination Styles */
.pagination-controls {
    display: flex;
}

/* Schedule Container Styles */
.schedule-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
}

.schedule-item {
    display: flex;
    align-items: flex-start;
    padding: 1rem;
    background: var(--white);
    border-radius: 10px;
    border: 1px solid var(--border-color);
    transition: all 0.2s ease;
}

.schedule-item:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.05);
}

.schedule-icon {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    background: rgba(119, 77, 211, 0.1);
    color: var(--primary);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
    font-size: 1rem;
}

.schedule-content {
    flex: 1;
}

.schedule-label {
    color: var(--secondary);
    font-size: 0.85rem;
    font-weight: 500;
    margin-bottom: 0.5rem;
}

.schedule-value {
    color: var(--dark);
    font-weight: 600;
    font-size: 1rem;
    margin: 0;
}

/* Empty State Styles */
.empty-state {
    padding: 2rem 0;
}

.empty-icon {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    background: rgba(100, 116, 139, 0.1);
    color: var(--secondary);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    font-size: 2rem;
}

.empty-title {
    color: var(--dark);
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.empty-description {
    color: var(--secondary);
    max-width: 500px;
    margin: 0 auto;
}

/* Tab Styles */
.nav-tabs-custom {
    border-bottom: none;
    display: flex;
    gap: 1rem;
}

.nav-link-custom {
    border: none;
    color: var(--secondary);
    font-weight: 500;
    padding: 0.75rem 1.5rem;
    border-radius: 8px 8px 0 0;
    background: rgba(255, 255, 255, 0.5);
    transition: all 0.2s ease;
}

.nav-link-custom:hover {
    color: var(--primary);
    background: rgba(255, 255, 255, 0.8);
}

.nav-link-custom.active {
    color: var(--primary);
    background: var(--white);
    font-weight: 600;
    box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.05);
}

.tab-content {
    background: var(--white);
    border-radius: 0 0 12px 12px;
}

/* Document Info Styles */
.document-info {
    max-width: 300px;
}

.document-title {
    font-weight: 600;
    color: var(--dark);
    margin-bottom: 0.5rem;
    line-height: 1.4;
}

.document-summary {
    color: var(--secondary);
    font-size: 0.85rem;
    margin: 0;
    line-height: 1.3;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Submitter Info Styles */
.submitter-info {
    max-width: 200px;
}

.submitter-name {
    font-weight: 600;
    color: var(--dark);
    margin-bottom: 0.25rem;
}

.submitter-role {
    color: var(--secondary);
    font-size: 0.85rem;
    margin: 0;
}

/* Status Badge Styles */
.status-badge {
    display: inline-flex;
    align-items: center;
    padding: 0.35rem 0.75rem;
    border-radius: 6px;
    font-size: 0.85rem;
    font-weight: 500;
}

.status-badge.approved {
    background: rgba(16, 185, 129, 0.1);
    color: var(--success);
}

.status-badge.rejected {
    background: rgba(239, 68, 68, 0.1);
    color: var(--danger);
}

.status-badge.pending {
    background: rgba(245, 158, 11, 0.1);
    color: var(--warning);
}

/* Finance Container Styles */
.finance-container {
    padding: 3rem 1rem;
}

.finance-icon {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: rgba(119, 77, 211, 0.1);
    color: var(--primary);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    font-size: 2.5rem;
}

.finance-title {
    color: var(--dark);
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.finance-description {
    color: var(--secondary);
    max-width: 500px;
    margin: 0 auto;
}

/* Modal Styles */
.modal-content-simple {
    background: var(--light-bg);
    backdrop-filter: blur(10px);
    border-radius: 12px;
    border: 2px solid var(--border-color);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    overflow: hidden;
}

.modal-header-simple {
    background: linear-gradient(135deg, rgba(73, 0, 230, 0.1) 0%, rgba(73, 0, 230, 0.1) 100%);
    padding: 1.5rem;
    border-bottom: 2px solid var(--border-color);
}

.modal-icon {
    width: 50px;
    height: 50px;
    border-radius: 10px;
    background: var(--primary);
    color: var(--white);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
    font-size: 1.2rem;
}

.modal-title {
    color: var(--dark);
    font-weight: 600;
    margin-bottom: 0.25rem;
}

.modal-subtitle {
    color: var(--secondary);
    font-size: 0.85rem;
    margin: 0;
}

.modal-body-simple {
    padding: 1.5rem;
}

.modal-footer-simple {
    background: rgba(100, 116, 139, 0.05);
    padding: 1.5rem;
    border-top: 1px solid var(--border-color);
}

.btn-close {
    background: none;
    border: none;
    font-size: 1.5rem;
    color: var(--secondary);
    opacity: 0.7;
    transition: all 0.2s ease;
}

.btn-close:hover {
    opacity: 1;
    color: var(--dark);
}

/* Steps Progress Styles */
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
    background-color: var(--border-color);
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
    background-color: var(--border-color);
    color: var(--white);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.875rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    transition: all 0.3s ease;
}

.step.active .step-number {
    background-color: var(--primary);
    box-shadow: 0 4px 6px rgba(119, 77, 211, 0.3);
}

.step-label {
    font-size: 0.75rem;
    color: var(--secondary);
    font-weight: 500;
}

.step.active .step-label {
    color: var(--primary);
    font-weight: 600;
}

/* File Upload Styles */
.file-upload-area {
    border: 2px dashed var(--border-color);
    border-radius: 8px;
    background: rgba(100, 116, 139, 0.05);
    transition: all 0.3s ease;
    cursor: pointer;
}

.file-upload-area:hover {
    border-color: var(--primary);
    background: rgba(119, 77, 211, 0.05);
}

.upload-icon {
    font-size: 3rem;
    color: var(--primary);
    opacity: 0.6;
}

.file-selected {
    background: var(--white);
    border: 1px solid var(--border-color);
    border-radius: 8px;
    padding: 1rem;
    margin-top: 1rem;
}

.format-badge {
    background: rgba(100, 116, 139, 0.1);
    color: var(--dark);
    padding: 0.25rem 0.5rem;
    border-radius: 4px;
    font-size: 0.75rem;
    font-weight: 500;
}

/* Review Section Styles */
.review-title {
    color: var(--dark);
    font-weight: 600;
    margin-bottom: 1rem;
}

.review-card {
    background: var(--white);
    border: 1px solid var(--border-color);
    border-radius: 8px;
    padding: 1rem;
    margin-bottom: 1rem;
}

.review-item {
    margin-bottom: 1rem;
}

.review-item:last-child {
    margin-bottom: 0;
}

.review-label {
    color: var(--secondary);
    font-size: 0.85rem;
    margin-bottom: 0.25rem;
}

.review-value {
    color: var(--dark);
    font-weight: 500;
    margin: 0;
}

.alert-info {
    background: rgba(59, 130, 246, 0.1);
    border: 1px solid rgba(59, 130, 246, 0.2);
    border-radius: 8px;
    padding: 1rem;
    color: var(--dark);
}

/* Responsive Styles */
@media (max-width: 768px) {
    .schedule-container {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Member search functionality
    const memberSearch = document.getElementById('memberSearch');
    if (memberSearch) {
        memberSearch.addEventListener('keyup', function() {
            const searchValue = this.value.toLowerCase();
            const rows = document.querySelectorAll('#membersTableBody tr');
            
            rows.forEach(row => {
                const name = row.querySelector('.member-details h6').textContent.toLowerCase();
                const email = row.querySelector('.member-details p').textContent.toLowerCase();
                
                if (name.includes(searchValue) || email.includes(searchValue)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }

    // Role change confirmation
    const roleSelects = document.querySelectorAll('.role-select');
    roleSelects.forEach(function(select) {
        select.addEventListener('change', function() {
            const memberName = this.closest('tr').querySelector('h6').textContent;
            const newRole = this.options[this.selectedIndex].text;
            
            if (confirm(`Are you sure you want to change ${memberName}'s role to ${newRole}?`)) {
                this.form.submit();
            } else {
                // Reset to original value if cancelled
                this.value = this.getAttribute('data-original-value');
            }
        });
        
        // Store original value
        select.setAttribute('data-original-value', select.value);
    });

    // Multi-step form functionality
    function initializeMultiStepForm(formId, fileInputId, browseBtnId, removeBtnId, fileInfoId, uploadAreaId, titleInputId, summaryInputId, titleCountId, summaryCountId, prevBtnId, nextBtnId, submitBtnId, reviewTitleId, reviewSummaryId, reviewFileNameId, reviewFileSizeId) {
        let currentStep = 1;
        const totalSteps = 3;
        const form = document.getElementById(formId);
        const fileInput = document.getElementById(fileInputId);
        const browseBtn = document.getElementById(browseBtnId);
        const removeBtn = document.getElementById(removeBtnId);
        const fileInfo = document.getElementById(fileInfoId);
        const uploadArea = document.getElementById(uploadAreaId);
        
        // Character counters
        const titleInput = document.getElementById(titleInputId);
        const summaryInput = document.getElementById(summaryInputId);
        const titleCount = document.getElementById(titleCountId);
        const summaryCount = document.getElementById(summaryCountId);
        
        // Navigation buttons
        const prevBtn = document.getElementById(prevBtnId);
        const nextBtn = document.getElementById(nextBtnId);
        const submitBtn = document.getElementById(submitBtnId);
        
        // Review elements
        const reviewTitle = document.getElementById(reviewTitleId);
        const reviewSummary = document.getElementById(reviewSummaryId);
        const reviewFileName = document.getElementById(reviewFileNameId);
        const reviewFileSize = document.getElementById(reviewFileSizeId);
        
        if (!form) return;
        
        // Character counting
        titleInput.addEventListener('input', function() {
            titleCount.textContent = this.value.length;
        });
        
        summaryInput.addEventListener('input', function() {
            summaryCount.textContent = this.value.length;
        });
        
        // File upload handling
        browseBtn.addEventListener('click', function() {
            fileInput.click();
        });
        
        fileInput.addEventListener('change', function(e) {
            if (this.files.length > 0) {
                const file = this.files[0];
                updateFileInfo(file, reviewFileNameId, reviewFileSizeId);
            }
        });
        
        // Drag and drop functionality
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            uploadArea.addEventListener(eventName, preventDefaults, false);
        });
        
        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }
        
        ['dragenter', 'dragover'].forEach(eventName => {
            uploadArea.addEventListener(eventName, highlight, false);
        });
        
        ['dragleave', 'drop'].forEach(eventName => {
            uploadArea.addEventListener(eventName, unhighlight, false);
        });
        
        function highlight() {
            uploadArea.style.borderColor = 'var(--primary)';
            uploadArea.style.background = 'rgba(119, 77, 211, 0.05)';
        }
        
        function unhighlight() {
            uploadArea.style.borderColor = 'var(--border-color)';
            uploadArea.style.background = 'rgba(100, 116, 139, 0.05)';
        }
        
        uploadArea.addEventListener('drop', function(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            fileInput.files = files;
            if (files.length > 0) {
                updateFileInfo(files[0], reviewFileNameId, reviewFileSizeId);
            }
        });
        
        function updateFileInfo(file, reviewFileNameId, reviewFileSizeId) {
            const fileName = document.getElementById('fileName');
            const fileSize = document.getElementById('fileSize');
            
            fileName.textContent = file.name;
            fileSize.textContent = formatFileSize(file.size);
            fileInfo.classList.remove('d-none');
            
            // Update review section
            const reviewFileName = document.getElementById(reviewFileNameId);
            const reviewFileSize = document.getElementById(reviewFileSizeId);
            reviewFileName.textContent = file.name;
            reviewFileSize.textContent = formatFileSize(file.size);
        }
        
        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }
        
        removeBtn.addEventListener('click', function() {
            fileInput.value = '';
            fileInfo.classList.add('d-none');
            reviewFileName.textContent = '-';
            reviewFileSize.textContent = '-';
        });
        
        // Step navigation
        function updateStepNavigation() {
            // Update step indicators
            document.querySelectorAll(`#${formId} .step`).forEach((step, index) => {
                if (index + 1 <= currentStep) {
                    step.classList.add('active');
                } else {
                    step.classList.remove('active');
                }
            });
            
            // Show/hide step content
            document.querySelectorAll(`#${formId} .step-content`).forEach(content => {
                if (parseInt(content.dataset.step) === currentStep) {
                    content.classList.remove('d-none');
                } else {
                    content.classList.add('d-none');
                }
            });
            
            // Update navigation buttons
            prevBtn.style.display = currentStep > 1 ? 'block' : 'none';
            
            if (currentStep === totalSteps) {
                nextBtn.style.display = 'none';
                submitBtn.style.display = 'block';
                updateReviewSection();
            } else {
                nextBtn.style.display = 'block';
                submitBtn.style.display = 'none';
            }
        }
        
        function updateReviewSection() {
            reviewTitle.textContent = titleInput.value || '-';
            reviewSummary.textContent = summaryInput.value || '-';
        }
        
        function validateStep(step) {
            switch(step) {
                case 1:
                    return titleInput.value.trim() !== '';
                case 2:
                    return fileInput.files.length > 0;
                case 3:
                    return true;
                default:
                    return false;
            }
        }
        
        nextBtn.addEventListener('click', function() {
            if (validateStep(currentStep)) {
                currentStep++;
                updateStepNavigation();
            } else {
                // Show validation error
                const stepName = currentStep === 1 ? 'Basic Information' : 'File Upload';
                alert(`Please complete ${stepName} step before proceeding.`);
            }
        });
        
        prevBtn.addEventListener('click', function() {
            currentStep--;
            updateStepNavigation();
        });
        
        // Form submission validation
        form.addEventListener('submit', function(e) {
            if (!validateStep(1) || !validateStep(2)) {
                e.preventDefault();
                alert('Please complete all required fields before submitting.');
            }
        });
        
        // Initialize
        updateStepNavigation();
    }

    // Initialize Proposal Form
    initializeMultiStepForm(
        'proposalForm', 'proposalFile', 'browseFileBtn', 'removeFileBtn', 'fileInfo', 
        'proposalFileUploadArea', 'proposalTitle', 'proposalSummary', 
        'titleCount', 'summaryCount', 'prevStepBtn', 'nextStepBtn', 'submitBtn', 
        'reviewTitle', 'reviewSummary', 'reviewFileName', 'reviewFileSize'
    );
    
    // Initialize Report Form
    initializeMultiStepForm(
        'reportForm', 'reportFile', 'browseReportFileBtn', 'removeReportFileBtn', 'reportFileInfo', 
        'reportFileUploadArea', 'reportTitle', 'reportSummary', 
        'reportTitleCount', 'reportSummaryCount', 'prevReportStepBtn', 'nextReportStepBtn', 'submitReportBtn', 
        'reviewReportTitle', 'reviewReportSummary', 'reviewReportFileName', 'reviewReportFileSize'
    );
    
    // Special handling for report form drag and drop
    const reportUploadArea = document.getElementById('reportFileUploadArea');
    if (reportUploadArea) {
        ['dragenter', 'dragover'].forEach(eventName => {
            reportUploadArea.addEventListener(eventName, function() {
                this.style.borderColor = 'var(--info)';
                this.style.background = 'rgba(59, 130, 246, 0.05)';
            }, false);
        });
        
        ['dragleave', 'drop'].forEach(eventName => {
            reportUploadArea.addEventListener(eventName, function() {
                this.style.borderColor = 'var(--border-color)';
                this.style.background = 'rgba(100, 116, 139, 0.05)';
            }, false);
        });
    }
    
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });
});
</script>

</x-app-layout>