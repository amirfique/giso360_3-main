<x-app-layout>

    @section('content')
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
        <div class="row">
            <div class="col-12">
                <div class="card border shadow-xs mb-4">
                    <div class="card-header border-bottom pb-0">
                        <div class="d-sm-flex align-items-center">
                            <div>
                                <h6 class="font-weight-semibold text-lg mb-0">Members list</h6>
                                <p class="text-sm">See information about all members</p>
                            </div>
                            <div class="ms-auto d-flex">
                                <button type="button" class="btn btn-sm btn-white me-2">
                                    View all
                                </button>
                                <button type="button"
                                    class="btn btn-sm btn-dark btn-icon d-flex align-items-center me-2">
                                    <span class="btn-inner--icon">
                                        <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24" fill="currentColor" class="d-block me-2">
                                            <path
                                                d="M6.25 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM3.25 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM19.75 7.5a.75.75 0 00-1.5 0v2.25H16a.75.75 0 000 1.5h2.25v2.25a.75.75 0 001.5 0v-2.25H22a.75.75 0 000-1.5h-2.25V7.5z" />
                                        </svg>
                                    </span>
                                    <span class="btn-inner--text">Add member</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-0 py-0">
                        <div class="border-bottom py-3 px-3 d-sm-flex align-items-center">
                            <!-- Removed radio buttons as requested -->
                            <div class="input-group w-sm-25 ms-auto">
                                <span class="input-group-text text-body">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px"
                                        fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z">
                                        </path>
                                    </svg>
                                </span>
                                <input type="text" class="form-control" placeholder="Search">
                            </div>
                        </div>
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="text-secondary text-xs font-weight-semibold opacity-7">Member</th>
                                        <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2">Role</th>
                                        <th class="text-center text-secondary text-xs font-weight-semibold opacity-7">Date of Join</th>
                                        <th class="text-secondary opacity-7"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($team->members as $member)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ $member->profile_photo_url ?? '../assets/img/team-2.jpg' }}"
                                                        class="avatar avatar-sm rounded-circle me-2"
                                                        alt="{{ $member->name }}">
                                                </div>
                                                <div class="d-flex flex-column justify-content-center ms-1">
                                                    <h6 class="mb-0 text-sm font-weight-semibold">{{ $member->name }}</h6>
                                                    <p class="text-sm text-secondary mb-0">{{ $member->email }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @if($member->id === $team->owner_id)
                                                <p class="text-sm text-dark font-weight-semibold mb-0">Director</p>
                                                <p class="text-sm text-secondary mb-0">Owner</p>
                                            @else
                                                <p class="text-sm text-dark font-weight-semibold mb-0">
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
                                                    {{ $roleDisplay }}
                                                </p>
                                                <p class="text-sm text-secondary mb-0">
                                                    {{ $role === 'director' ? 'Owner' : 
                                                    ($role === 'co-director' ? 'Management' :
                                                    ($role === 'secretary' ? 'Administration' :
                                                    ($role === 'treasurer' ? 'Finance' : 'Team Member'))) }}
                                                </p>
                                            @endif
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-sm font-weight-normal">
                                                @if($member->pivot->created_at)
                                                    {{ $member->pivot->created_at->format('d/m/Y') }}
                                                @else
                                                    {{ $member->created_at->format('d/m/Y') }}
                                                @endif
                                            </span>
                                        </td>
                                        <td class="align-middle">
                                            @if($member->id !== $team->owner_id)
                                                <a href="javascript:;" class="text-secondary font-weight-bold text-xs"
                                                    data-bs-toggle="tooltip" data-bs-title="Change role">
                                                    <svg width="14" height="14" viewBox="0 0 15 16"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M11.2201 2.02495C10.8292 1.63482 10.196 1.63545 9.80585 2.02636C9.41572 2.41727 9.41635 3.05044 9.80726 3.44057L11.2201 2.02495ZM12.5572 6.18502C12.9481 6.57516 13.5813 6.57453 13.9714 6.18362C14.3615 5.79271 14.3609 5.15954 13.97 4.7694L12.5572 6.18502ZM11.6803 1.56839L12.3867 2.2762L12.3867 2.27619L11.6803 1.56839ZM14.4302 4.31284L15.1367 5.02065L15.1367 5.02064L14.4302 4.31284ZM3.72198 15V16C3.98686 16 4.24091 15.8949 4.42839 15.7078L3.72198 15ZM0.999756 15H-0.000244141C-0.000244141 15.5523 0.447471 16 0.999756 16L0.999756 15ZM0.999756 12.2279L0.293346 11.5201C0.105383 11.7077 -0.000244141 11.9624 -0.000244141 12.2279H0.999756ZM9.80726 3.44057L12.5572 6.18502L13.97 4.7694L11.2201 2.02495L9.80726 3.44057ZM12.3867 2.27619C12.7557 1.90794 13.3549 1.90794 13.7238 2.27619L15.1367 0.860593C13.9869 -0.286864 12.1236 -0.286864 10.9739 0.860593L12.3867 2.27619ZM13.7238 2.27619C14.0917 2.64337 14.0917 3.23787 13.7238 3.60504L15.1367 5.02064C16.2875 3.8721 16.2875 2.00913 15.1367 0.860593L13.7238 2.27619ZM13.7238 3.60504L3.01557 14.2922L4.42839 15.7078L15.1367 5.02065L13.7238 3.60504ZM3.72198 14H0.999756V16H3.72198V14ZM1.99976 15V12.2279H-0.000244141V15H1.99976ZM1.70617 12.9357L12.3867 2.2762L10.9739 0.86059L0.293346 11.5201L1.70617 12.9357Z"
                                                            fill="#64748B" />
                                                    </svg>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="border-top py-3 px-3 d-flex align-items-center">
                            <p class="font-weight-semibold mb-0 text-dark text-sm">Page 1 of 10</p>
                            <div class="ms-auto">
                                <button class="btn btn-sm btn-white mb-0">Previous</button>
                                <button class="btn btn-sm btn-white mb-0">Next</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

                <!-- Presentation Schedule Card -->
        @if($schedule)
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border shadow-xs">
                    <div class="card-header bg-gradient-primary text-white">
                        <h6 class="font-weight-semibold text-lg mb-0 text-white">Your Presentation Schedule</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 text-center">
                                <div class="border-right border-gray-300 pr-3">
                                    <h6 class="text-sm text-secondary mb-1">Date</h6>
                                    <p class="text-lg font-weight-bold text-dark mb-0">
                                        {{ $schedule->presentation_date->format('d F Y') }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-2 text-center">
                                <div class="border-right border-gray-300 pr-3">
                                    <h6 class="text-sm text-secondary mb-1">Time</h6>
                                    <p class="text-lg font-weight-bold text-dark mb-0">
                                        {{ \Carbon\Carbon::parse($schedule->presentation_time)->format('h:i A') }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-4 text-center">
                                <div class="border-right border-gray-300 pr-3">
                                    <h6 class="text-sm text-secondary mb-1">Location</h6>
                                    <p class="text-lg font-weight-bold text-dark mb-0">
                                        {{ $schedule->location }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-3 text-center">
                                <div>
                                    <h6 class="text-sm text-secondary mb-1">Notes</h6>
                                    <p class="text-sm text-dark mb-0">
                                        {{ $schedule->notes ?? 'No additional notes' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border shadow-xs">
                    <div class="card-body text-center py-5">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" class="text-secondary mb-3">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <h6 class="text-secondary mb-2">No Presentation Scheduled Yet</h6>
                        <p class="text-sm text-secondary mb-0">Your presentation schedule will be announced soon.</p>
                    </div>
                </div>
            </div>
        </div>
        @endif

<!-- Proposals table -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card border shadow-xs mb-4">
                    <div class="card-header border-bottom pb-0">
                        <div class="d-sm-flex align-items-center">
                            <div>
                                <h6 class="font-weight-semibold text-lg mb-0">Proposals</h6>
                                <p class="text-sm">Manage and track all submitted proposals</p>
                            </div>
                            <div class="ms-auto d-flex">
                                <button type="button" class="btn btn-sm btn-white me-2">
                                    View all
                                </button>
                                <button type="button"
                                    class="btn btn-sm btn-dark btn-icon d-flex align-items-center me-2"
                                    data-bs-toggle="modal" data-bs-target="#addProposalModal">
                                    <span class="btn-inner--icon">
                                        <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24" fill="currentColor" class="d-block me-2">
                                            <path
                                                d="M6.25 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM3.25 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM19.75 7.5a.75.75 0 00-1.5 0v2.25H16a.75.75 0 000 1.5h2.25v2.25a.75.75 0 001.5 0v-2.25H22a.75.75 0 000-1.5h-2.25V7.5z" />
                                        </svg>
                                    </span>
                                    <span class="btn-inner--text">Add Proposal</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-0 py-0">
                        <div class="border-bottom py-3 px-3 d-sm-flex align-items-center">
                            <div class="input-group w-sm-25 ms-auto">
                                <span class="input-group-text text-body">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px"
                                        fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z">
                                        </path>
                                    </svg>
                                </span>
                                <input type="text" class="form-control" placeholder="Search proposals">
                            </div>
                        </div>
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0" style="table-layout: fixed; width: 100%;">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="text-secondary text-xs font-weight-semibold opacity-7" style="width: 25%;">Title</th>
                                        <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2" style="width: 20%;">Submitted By</th>
                                        <th class="text-center text-secondary text-xs font-weight-semibold opacity-7" style="width: 15%;">Date Submitted</th>
                                        <th class="text-center text-secondary text-xs font-weight-semibold opacity-7" style="width: 15%;">Status</th>
                                        <th class="text-secondary opacity-7 text-center" style="width: 10%;">File</th>
                                        <th class="text-secondary opacity-7 text-center" style="width: 15%;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($proposals as $proposal)
                                    <tr>
                                        <td style="width: 25%; word-wrap: break-word; vertical-align: top;">
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center ms-1 w-100">
                                                    <h6 class="mb-1 text-sm font-weight-semibold" style="word-wrap: break-word; line-height: 1.4;">
                                                        {{ $proposal->title }}
                                                    </h6>
                                                    <p class="text-sm text-secondary mb-0" style="word-wrap: break-word; line-height: 1.3;">
                                                        {{ $proposal->summary }}
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td style="width: 20%; word-wrap: break-word; vertical-align: top;">
                                            <p class="text-sm text-dark font-weight-semibold mb-1" style="word-wrap: break-word; line-height: 1.4;">
                                                {{ $proposal->user->name }}
                                            </p>
                                            <p class="text-sm text-secondary mb-0" style="word-wrap: break-word; line-height: 1.3;">
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
                                        </td>
                                        <td class="align-middle text-center" style="width: 15%; vertical-align: top;">
                                            <span class="text-secondary text-sm font-weight-normal">
                                                {{ $proposal->created_at->format('d/m/Y') }}
                                            </span>
                                        </td>
                                        <td class="align-middle text-center text-sm" style="width: 15%; vertical-align: top;">
                                            @if($proposal->status === 'approved')
                                                <span class="badge badge-sm border border-success text-success bg-success">
                                                    <svg width="9" height="9" viewBox="0 0 10 9" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="currentColor" class="me-1">
                                                        <path d="M1 4.42857L3.28571 6.71429L9 1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                    </svg>
                                                    Approved
                                                </span>
                                            @elseif($proposal->status === 'rejected')
                                                <span class="badge badge-sm border border-danger text-danger bg-danger">
                                                    <svg width="12" height="12" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="me-1">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                    Rejected
                                                </span>
                                            @else
                                                <span class="badge badge-sm border border-warning text-warning bg-warning">
                                                    <svg width="12" height="12" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="me-1">
                                                        <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 00-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 000-1.5h-3.75V6z" clip-rule="evenodd" />
                                                    </svg>
                                                    Pending
                                                </span>
                                            @endif
                                        </td>
                                        <td class="align-middle text-center" style="width: 10%; vertical-align: top;">
                                            <a href="{{ route('proposals.download', $proposal) }}" class="text-secondary font-weight-bold text-xs"
                                                data-bs-toggle="tooltip" data-bs-title="Download file">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                                    <polyline points="7 10 12 15 17 10"></polyline>
                                                    <line x1="12" y1="15" x2="12" y2="3"></line>
                                                </svg>
                                            </a>
                                        </td>
                                        <td class="align-middle text-center" style="width: 15%; vertical-align: top;">
                                            @if(auth()->id() === $proposal->user_id || auth()->id() === $team->owner_id)
                                                <form action="{{ route('proposals.destroy', $proposal) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-link text-danger text-xs p-0" 
                                                            data-bs-toggle="tooltip" 
                                                            data-bs-title="Delete proposal"
                                                            onclick="return confirm('Are you sure you want to delete this proposal?')">
                                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                            <path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                            <line x1="10" y1="11" x2="10" y2="17"></line>
                                                            <line x1="14" y1="11" x2="14" y2="17"></line>
                                                        </svg>
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-muted text-xs">No access</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

                <!-- Add Proposal Modal -->
                <div class="modal fade" id="addProposalModal" tabindex="-1" role="dialog" aria-labelledby="addProposalModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content border-0 shadow-lg">
                        <!-- Header -->
                        <div class="modal-header bg-gradient-primary text-white">
                            <div class="d-flex align-items-center">
                                <div class="icon icon-shape bg-white bg-opacity-10 rounded-circle me-3">
                                    <i class="fas fa-file-upload text-white"></i>
                                </div>
                                <div>
                                    <h5 class="modal-title mb-0" id="addProposalModalLabel">Submit New Proposal</h5>
                                    <p class="text-white text-xs mb-0 opacity-80">Fill in the details below to submit your proposal</p>
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

            <style>
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
            document.addEventListener('DOMContentLoaded', function() {
                let currentStep = 1;
                const totalSteps = 3;
                const form = document.getElementById('proposalForm');
                const fileInput = document.getElementById('proposalFile');
                const browseFileBtn = document.getElementById('browseFileBtn');
                const removeFileBtn = document.getElementById('removeFileBtn');
                const fileInfo = document.getElementById('fileInfo');
                const uploadArea = document.querySelector('.file-upload-area');

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
                    document.querySelectorAll('.step').forEach((step, index) => {
                        if (index + 1 <= currentStep) {
                            step.classList.add('active');
                        } else {
                            step.classList.remove('active');
                        }
                    });

                    // Show/hide step content
                    document.querySelectorAll('.step-content').forEach(content => {
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
                        alert(`Please complete the ${stepName} step before proceeding.`);
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
            });
            </script>

      <!-- Reports table -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card border shadow-xs mb-4">
                    <div class="card-header border-bottom pb-0">
                        <div class="d-sm-flex align-items-center">
                            <div>
                                <h6 class="font-weight-semibold text-lg mb-0">Reports</h6>
                                <p class="text-sm">Manage and track all submitted reports</p>
                            </div>
                            <div class="ms-auto d-flex">
                                <button type="button" class="btn btn-sm btn-white me-2">
                                    View all
                                </button>
                                <button type="button"
                                    class="btn btn-sm btn-dark btn-icon d-flex align-items-center me-2"
                                    data-bs-toggle="modal" data-bs-target="#addReportModal">
                                    <span class="btn-inner--icon">
                                        <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 24 24" fill="currentColor" class="d-block me-2">
                                            <path
                                                d="M6.25 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM3.25 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM19.75 7.5a.75.75 0 00-1.5 0v2.25H16a.75.75 0 000 1.5h2.25v2.25a.75.75 0 001.5 0v-2.25H22a.75.75 0 000-1.5h-2.25V7.5z" />
                                        </svg>
                                    </span>
                                    <span class="btn-inner--text">Add Report</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-0 py-0">
                        <div class="border-bottom py-3 px-3 d-sm-flex align-items-center">
                            <div class="input-group w-sm-25 ms-auto">
                                <span class="input-group-text text-body">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16px" height="16px"
                                        fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z">
                                        </path>
                                    </svg>
                                </span>
                                <input type="text" class="form-control" placeholder="Search reports">
                            </div>
                        </div>
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0" style="table-layout: fixed; width: 100%;">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="text-secondary text-xs font-weight-semibold opacity-7" style="width: 25%;">Title</th>
                                        <th class="text-secondary text-xs font-weight-semibold opacity-7 ps-2" style="width: 20%;">Submitted By</th>
                                        <th class="text-center text-secondary text-xs font-weight-semibold opacity-7" style="width: 15%;">Date Submitted</th>
                                        <th class="text-center text-secondary text-xs font-weight-semibold opacity-7" style="width: 15%;">Status</th>
                                        <th class="text-secondary opacity-7 text-center" style="width: 10%;">File</th>
                                        <th class="text-secondary opacity-7 text-center" style="width: 15%;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($reports as $report)
                                    <tr>
                                        <td style="width: 25%; word-wrap: break-word; vertical-align: top;">
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center ms-1 w-100">
                                                    <h6 class="mb-1 text-sm font-weight-semibold" style="word-wrap: break-word; line-height: 1.4;">
                                                        {{ $report->title }}
                                                    </h6>
                                                    <p class="text-sm text-secondary mb-0" style="word-wrap: break-word; line-height: 1.3;">
                                                        {{ $report->summary }}
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td style="width: 20%; word-wrap: break-word; vertical-align: top;">
                                            <p class="text-sm text-dark font-weight-semibold mb-1" style="word-wrap: break-word; line-height: 1.4;">
                                                {{ $report->user->name }}
                                            </p>
                                            <p class="text-sm text-secondary mb-0" style="word-wrap: break-word; line-height: 1.3;">
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
                                        </td>
                                        <td class="align-middle text-center" style="width: 15%; vertical-align: top;">
                                            <span class="text-secondary text-sm font-weight-normal">
                                                {{ $report->created_at->format('d/m/Y') }}
                                            </span>
                                        </td>
                                        <td class="align-middle text-center text-sm" style="width: 15%; vertical-align: top;">
                                            @if($report->status === 'approved')
                                                <span class="badge badge-sm border border-success text-success bg-success">
                                                    <svg width="9" height="9" viewBox="0 0 10 9" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="currentColor" class="me-1">
                                                        <path d="M1 4.42857L3.28571 6.71429L9 1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                    </svg>
                                                    Approved
                                                </span>
                                            @elseif($report->status === 'rejected')
                                                <span class="badge badge-sm border border-danger text-danger bg-danger">
                                                    <svg width="12" height="12" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="me-1">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                    Rejected
                                                </span>
                                            @else
                                                <span class="badge badge-sm border border-warning text-warning bg-warning">
                                                    <svg width="12" height="12" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="me-1">
                                                        <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25zM12.75 6a.75.75 0 00-1.5 0v6c0 .414.336.75.75.75h4.5a.75.75 0 000-1.5h-3.75V6z" clip-rule="evenodd" />
                                                    </svg>
                                                    Pending
                                                </span>
                                            @endif
                                        </td>
                                        <td class="align-middle text-center" style="width: 10%; vertical-align: top;">
                                            <a href="{{ route('reports.download', $report) }}" class="text-secondary font-weight-bold text-xs"
                                                data-bs-toggle="tooltip" data-bs-title="Download file">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                                    <polyline points="7 10 12 15 17 10"></polyline>
                                                    <line x1="12" y1="15" x2="12" y2="3"></line>
                                                </svg>
                                            </a>
                                        </td>
                                        <td class="align-middle text-center" style="width: 15%; vertical-align: top;">
                                            @if(auth()->id() === $report->user_id || auth()->id() === $team->owner_id)
                                                <form action="{{ route('reports.destroy', $report) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-link text-danger text-xs p-0"
                                                            data-bs-toggle="tooltip" 
                                                            data-bs-title="Delete report"
                                                            onclick="return confirm('Are you sure you want to delete this report?')">
                                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                            <path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                            <line x1="10" y1="11" x2="10" y2="17"></line>
                                                            <line x1="14" y1="11" x2="14" y2="17"></line>
                                                        </svg>
                                                    </button>
                                                </form>
                                            @else
                                                <span class="text-muted text-xs">No access</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
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
                            <div class="icon icon-shape bg-white bg-opacity-10 rounded-circle me-3">
                                <i class="fas fa-chart-bar text-white"></i>
                            </div>
                            <div>
                                <h5 class="modal-title mb-0" id="addReportModalLabel">Submit New Report</h5>
                                <p class="text-white text-xs mb-0 opacity-80">Fill in the details below to submit your report</p>
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
            background-color: #11cdef;
            color: white;
            box-shadow: 0 4px 6px rgba(17, 205, 239, 0.3);
        }

        .step-label {
            font-size: 0.75rem;
            color: #6c757d;
            font-weight: 500;
        }

        .step.active .step-label {
            color: #11cdef;
            font-weight: 600;
        }

        .file-upload-area {
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .file-upload-area:hover {
            border-color: #11cdef !important;
            background-color: rgba(17, 205, 239, 0.02) !important;
        }

        .file-upload-area.dragover {
            border-color: #11cdef !important;
            background-color: rgba(17, 205, 239, 0.05) !important;
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
        document.addEventListener('DOMContentLoaded', function() {
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

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            ['dragenter', 'dragover'].forEach(eventName => {
                reportUploadArea.addEventListener(eventName, highlight, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                reportUploadArea.addEventListener(eventName, unhighlight, false);
            });

            function highlight() {
                reportUploadArea.classList.add('dragover');
            }

            function unhighlight() {
                reportUploadArea.classList.remove('dragover');
            }

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

            function formatFileSize(bytes) {
                if (bytes === 0) return '0 Bytes';
                const k = 1024;
                const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
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
                    alert(`Please complete the ${stepName} step before proceeding.`);
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

                <!-- Finance Section Link -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card border shadow-xs">
                    <div class="card-body text-center">
                        <h6 class="font-weight-semibold text-lg mb-2">Finance Management</h6>
                        <p class="text-sm mb-3">Manage team expenses and financial tracking</p>
                        <a href="{{ route('teams.finance', $team) }}" class="btn btn-dark">
                            <i class="fas fa-money-bill-wave me-2"></i>Go to Finance Management
                        </a>
                    </div>
                </div>
            </div>
        </div>

</x-app-layout>