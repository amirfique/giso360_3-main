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
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addProposalModalLabel">Add New Proposal</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="mb-3">
                                <label for="proposalTitle" class="form-label">Title</label>
                                <input type="text" class="form-control" id="proposalTitle" placeholder="Enter proposal title" maxlength="40">
                            </div>
                            <div class="mb-3">
                                <label for="proposalSummary" class="form-label">Summary</label>
                                <textarea class="form-control" id="proposalSummary" rows="3" placeholder="Brief description of the proposal"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="proposalFile" class="form-label">Choose File</label>
                                <input type="file" class="form-control" id="proposalFile">
                                <div class="form-text">Supported formats: PDF, DOC, DOCX, PPT, PPTX</div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-dark">Submit Proposal</button>
                    </div>
                </div>
            </div>
        </div>

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
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addReportModalLabel">Add New Report</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('reports.store', $team) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="reportTitle" class="form-label">Title</label>
                                <input type="text" class="form-control" id="reportTitle" name="title" placeholder="Enter report title" required>
                            </div>
                            <div class="mb-3">
                                <label for="reportSummary" class="form-label">Summary</label>
                                <textarea class="form-control" id="reportSummary" name="summary" rows="3" placeholder="Brief description of the report"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="reportFile" class="form-label">Choose File</label>
                                <input type="file" class="form-control" id="reportFile" name="file" required>
                                <div class="form-text">Supported formats: PDF, DOC, DOCX, PPT, PPTX, XLS, XLSX (Max: 10MB)</div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-white" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-dark">Submit Report</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

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