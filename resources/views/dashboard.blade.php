<x-app-layout>
    <div class="container-fluid py-4 px-5">
        <div class="row">
            <div class="col-md-12">
                <div class="d-md-flex align-items-center mb-3 mx-2">
                    <div class="mb-md-0 mb-3">
                        <h3 class="font-weight-bold mb-0">Hello, {{ Auth::user()->name ?? 'Student' }}</h3>
                        <p class="mb-0">Welcome to your GISO 360 Dashboard!</p>
                    </div>
                    <button type="button"
                        class="btn btn-sm btn-white btn-icon d-flex align-items-center mb-0 ms-md-auto mb-sm-0 mb-2 me-2">
                        <span class="btn-inner--icon">
                            <span class="p-1 bg-success rounded-circle d-flex ms-auto me-2">
                                <span class="visually-hidden">New</span>
                            </span>
                        </span>
                        <span class="btn-inner--text">Messages</span>
                    </button>
                    <button type="button" class="btn btn-sm btn-dark btn-icon d-flex align-items-center mb-0">
                        <span class="btn-inner--icon">
                            <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="d-block me-2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                            </svg>
                        </span>
                        <span class="btn-inner--text">Sync</span>
                    </button>
                </div>
            </div>
        </div>
        <hr class="my-0">
        
        <!-- Swiper -->
        <div class="row">
            <div class="position-relative overflow-hidden">
                <div class="swiper mySwiper mt-4 mb-2">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div>
                                <div
                                    class="card card-background shadow-none border-radius-xl card-background-after-none align-items-start mb-0">
                                    <div class="full-background bg-cover"
                                        style="background-image: url('../assets/img/img-2.jpg')"></div>
                                    <div class="card-body text-start px-3 py-0 w-100">
                                        <div class="row mt-12">
                                            <div class="col-sm-3 mt-auto">
                                                <h4 class="text-dark font-weight-bolder">#1</h4>
                                                <p class="text-dark opacity-6 text-xs font-weight-bolder mb-0">Name
                                                </p>
                                                <h5 class="text-dark font-weight-bolder">Secured</h5>
                                            </div>
                                            <div class="col-sm-3 ms-auto mt-auto">
                                                <p class="text-dark opacity-6 text-xs font-weight-bolder mb-0">
                                                    Category</p>
                                                <h5 class="text-dark font-weight-bolder">Banking</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div
                                class="card card-background shadow-none border-radius-xl card-background-after-none align-items-start mb-0">
                                <div class="full-background bg-cover"
                                    style="background-image: url('../assets/img/img-1.jpg')"></div>
                                <div class="card-body text-start px-3 py-0 w-100">
                                    <div class="row mt-12">
                                        <div class="col-sm-3 mt-auto">
                                            <h4 class="text-dark font-weight-bolder">#2</h4>
                                            <p class="text-dark opacity-6 text-xs font-weight-bolder mb-0">Name</p>
                                            <h5 class="text-dark font-weight-bolder">Cyber</h5>
                                        </div>
                                        <div class="col-sm-3 ms-auto mt-auto">
                                            <p class="text-dark opacity-6 text-xs font-weight-bolder mb-0">Category
                                            </p>
                                            <h5 class="text-dark font-weight-bolder">Security</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div
                                class="card card-background shadow-none border-radius-xl card-background-after-none align-items-start mb-0">
                                <div class="full-background bg-cover"
                                    style="background-image: url('../assets/img/img-3.jpg')"></div>
                                <div class="card-body text-start px-3 py-0 w-100">
                                    <div class="row mt-12">
                                        <div class="col-sm-3 mt-auto">
                                            <h4 class="text-dark font-weight-bolder">#3</h4>
                                            <p class="text-dark opacity-6 text-xs font-weight-bolder mb-0">Name</p>
                                            <h5 class="text-dark font-weight-bolder">Alpha</h5>
                                        </div>
                                        <div class="col-sm-3 ms-auto mt-auto">
                                            <p class="text-dark opacity-6 text-xs font-weight-bolder mb-0">Category
                                            </p>
                                            <h5 class="text-dark font-weight-bolder">Blockchain</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div
                                class="card card-background shadow-none border-radius-xl card-background-after-none align-items-start mb-0">
                                <div class="full-background bg-cover"
                                    style="background-image: url('../assets/img/img-4.jpg')"></div>
                                <div class="card-body text-start px-3 py-0 w-100">
                                    <div class="row mt-12">
                                        <div class="col-sm-3 mt-auto">
                                            <h4 class="text-dark font-weight-bolder">#4</h4>
                                            <p class="text-dark opacity-6 text-xs font-weight-bolder mb-0">Name</p>
                                            <h5 class="text-dark font-weight-bolder">Beta</h5>
                                        </div>
                                        <div class="col-sm-3 ms-auto mt-auto">
                                            <p class="text-dark opacity-6 text-xs font-weight-bolder mb-0">Category
                                            </p>
                                            <h5 class="text-dark font-weight-bolder">Web3</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div
                                class="card card-background shadow-none border-radius-xl card-background-after-none align-items-start mb-0">
                                <div class="full-background bg-cover"
                                    style="background-image: url('../assets/img/img-5.jpg')"></div>
                                <div class="card-body text-start px-3 py-0 w-100">
                                    <div class="row mt-12">
                                        <div class="col-sm-3 mt-auto">
                                            <h4 class="text-dark font-weight-bolder">#5</h4>
                                            <p class="text-dark opacity-6 text-xs font-weight-bolder mb-0">Name</p>
                                            <h5 class="text-dark font-weight-bolder">Gama</h5>
                                        </div>
                                        <div class="col-sm-3 ms-auto mt-auto">
                                            <p class="text-dark opacity-6 text-xs font-weight-bolder mb-0">Category
                                            </p>
                                            <h5 class="text-dark font-weight-bolder">Design</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div
                                class="card card-background shadow-none border-radius-xl card-background-after-none align-items-start mb-0">
                                <div class="full-background bg-cover"
                                    style="background-image: url('../assets/img/img-1.jpg')"></div>
                                <div class="card-body text-start px-3 py-0 w-100">
                                    <div class="row mt-12">
                                        <div class="col-sm-3 mt-auto">
                                            <h4 class="text-dark font-weight-bolder">#6</h4>
                                            <p class="text-dark opacity-6 text-xs font-weight-bolder mb-0">Name</p>
                                            <h5 class="text-dark font-weight-bolder">Rompro</h5>
                                        </div>
                                        <div class="col-sm-3 ms-auto mt-auto">
                                            <p class="text-dark opacity-6 text-xs font-weight-bolder mb-0">Category
                                            </p>
                                            <h5 class="text-dark font-weight-bolder">Security</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
        </div>
        <!-- End of Swiper -->


        <!-- Quick Actions & Teams Section -->
        
                <!-- Quick Actions -->
        <div class="card mb-4">
            <div class="card-header pb-2">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Quick Actions</h5>
                    <span class="text-sm text-muted">Get things done faster</span>
                </div>
            </div>
            <div class="card-body p-3">
                <div class="row g-3">
                    <div class="col-xl-3 col-md-6">
                        <a href="{{ route('teams.index') }}" class="card card-action h-100">
                            <div class="card-body p-3 d-flex flex-column align-items-center">
                                <div class="icon-container mb-3">
                                    <div class="icon-circle bg-gradient-primary shadow-primary">
                                        <i class="fas fa-plus text-white"></i>
                                    </div>
                                </div>
                                <h6 class="mb-1">Create Team</h6>
                                <p class="text-xs text-muted text-center mb-0">Start new project</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <a href="{{ route('teams.index') }}" class="card card-action h-100">
                            <div class="card-body p-3 d-flex flex-column align-items-center">
                                <div class="icon-container mb-3">
                                    <div class="icon-circle bg-gradient-success shadow-success">
                                        <i class="fas fa-users text-white"></i>
                                    </div>
                                </div>
                                <h6 class="mb-1">My Teams</h6>
                                <p class="text-xs text-muted text-center mb-0">Manage teams</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <a href="{{ route('presentation-schedules.index') }}" class="card card-action h-100">
                            <div class="card-body p-3 d-flex flex-column align-items-center">
                                <div class="icon-container mb-3">
                                    <div class="icon-circle bg-gradient-info shadow-info">
                                        <i class="fas fa-calendar-alt text-white"></i>
                                    </div>
                                </div>
                                <h6 class="mb-1">Schedule</h6>
                                <p class="text-xs text-muted text-center mb-0">View presentations</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <a href="#" class="card card-action h-100">
                            <div class="card-body p-3 d-flex flex-column align-items-center">
                                <div class="icon-container mb-3">
                                    <div class="icon-circle bg-gradient-warning shadow-warning">
                                        <i class="fas fa-file-upload text-white"></i>
                                    </div>
                                </div>
                                <h6 class="mb-1">Submit</h6>
                                <p class="text-xs text-muted text-center mb-0">Proposals & Reports</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

                <!-- My Teams Section -->
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-1">My GISO Teams</h5>
                                <p class="text-sm text-muted mb-0">Manage your teams and track progress</p>
                            </div>
                            <a href="{{ route('teams.index') }}" class="btn btn-sm bg-gradient-primary mb-0">
                                <i class="fas fa-eye me-1"></i> View All
                            </a>
                        </div>
                    </div>
                    <div class="card-body p-3">
                        @if($teams->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover align-items-center">
                                    <thead class="bg-gray-100">
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 ps-3">Team</th>
                                            <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 text-center">Status</th>
                                            <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 text-center">Members</th>
                                            <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 text-center">Progress</th>
                                            <th class="text-uppercase text-secondary text-xs font-weight-bolder opacity-7 text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($teams as $team)
                                        <tr class="border-bottom">
                                            <td>
                                                <div class="d-flex align-items-center px-2 py-2">
                                                    <div class="team-avatar me-3">
                                                        <div class="avatar bg-gradient-primary shadow-sm rounded-circle d-flex align-items-center justify-content-center">
                                                            <i class="fas fa-users text-white text-sm"></i>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex flex-column">
                                                        <h6 class="mb-0 text-sm font-weight-semibold">{{ $team->name }}</h6>
                                                        <p class="text-xs text-muted mb-0">{{ Str::limit($team->description, 40) ?: 'No description provided' }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge badge-sm badge-pill 
                                                    {{ $team->latest_proposal_status === 'approved' ? 'bg-gradient-success' : 
                                                    ($team->latest_proposal_status === 'pending' ? 'bg-gradient-warning' : 
                                                    ($team->latest_proposal_status === 'rejected' ? 'bg-gradient-danger' : 
                                                    ($team->latest_proposal_status === 'under_review' ? 'bg-gradient-info' : 'bg-gradient-secondary'))) }}">
                                                    @if($team->latest_proposal_status === 'not_submitted')
                                                        <i class="fas fa-clock me-1"></i> No Proposal
                                                    @elseif($team->latest_proposal_status === 'pending')
                                                        <i class="fas fa-hourglass-half me-1"></i> Pending
                                                    @elseif($team->latest_proposal_status === 'approved')
                                                        <i class="fas fa-check me-1"></i> Approved
                                                    @elseif($team->latest_proposal_status === 'rejected')
                                                        <i class="fas fa-times me-1"></i> Rejected
                                                    @elseif($team->latest_proposal_status === 'under_review')
                                                        <i class="fas fa-search me-1"></i> Under Review
                                                    @else
                                                        {{ ucfirst($team->latest_proposal_status) }}
                                                    @endif
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <div class="d-flex flex-column align-items-center">
                                                    <span class="text-sm font-weight-bold">{{ $team->members_count }}</span>
                                                    <span class="text-xs text-muted">members</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="progress-wrapper">
                                                    <div class="d-flex justify-content-between mb-1">
                                                        <span class="text-xs font-weight-semibold">Project Progress</span>
                                                        <span class="text-xs font-weight-bold">{{ $team->progress_percentage }}%</span>
                                                    </div>
                                                    <div class="progress" style="height: 6px;">
                                                        <div class="progress-bar 
                                                            {{ $team->progress_percentage < 25 ? 'bg-gradient-danger' : 
                                                            ($team->progress_percentage < 50 ? 'bg-gradient-warning' : 
                                                            ($team->progress_percentage < 75 ? 'bg-gradient-info' : 'bg-gradient-success')) }}" 
                                                            role="progressbar" 
                                                            aria-valuenow="{{ $team->progress_percentage }}" 
                                                            aria-valuemin="0" 
                                                            aria-valuemax="100" 
                                                            style="width: {{ $team->progress_percentage }}%;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="action-buttons">
                                                    <a href="{{ route('teams.show', $team) }}" 
                                                    class="btn btn-sm bg-gradient-info text-white mb-0 me-1"
                                                    data-bs-toggle="tooltip" 
                                                    title="View Team Details">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="#" 
                                                    class="btn btn-sm bg-gradient-primary text-white mb-0"
                                                    data-bs-toggle="tooltip" 
                                                    title="Quick Actions">
                                                        <i class="fas fa-ellipsis-h"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-6">
                                <div class="empty-state-icon mb-4">
                                    <div class="icon icon-shape bg-gradient-secondary shadow text-center rounded-circle mx-auto d-flex align-items-center justify-content-center" 
                                        style="width: 100px; height: 100px;">
                                        <i class="fas fa-users text-white text-2xl opacity-10"></i>
                                    </div>
                                </div>
                                <h5 class="mb-2">No teams yet</h5>
                                <p class="text-muted mb-4">Join or create a team to get started with your GISO project</p>
                                <div class="d-flex justify-content-center gap-3">
                                    <a href="{{ route('teams.create') }}" class="btn bg-gradient-primary mb-0">
                                        <i class="fas fa-plus me-2"></i>Create Team
                                    </a>
                                    <a href="{{ route('teams.index') }}" class="btn btn-outline-primary mb-0">
                                        <i class="fas fa-search me-2"></i>Find Teams
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <style>
                .card {
                    border: none;
                    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
                    border-radius: 0.75rem;
                }

                .card-header {
                    border-bottom: 1px solid #e9ecef;
                    background-color: transparent;
                }

                .team-avatar .avatar {
                    width: 48px;
                    height: 48px;
                }

                .table-hover tbody tr:hover {
                    background-color: rgba(94, 114, 228, 0.03);
                }

                .bg-gray-100 {
                    background-color: #f8f9fa !important;
                }

                .border-bottom {
                    border-bottom: 1px solid #e9ecef !important;
                }

                .font-weight-semibold {
                    font-weight: 600;
                }

                .progress {
                    border-radius: 10px;
                    overflow: hidden;
                }

                .progress-bar {
                    border-radius: 10px;
                }

                .action-buttons .btn {
                    border-radius: 0.5rem;
                    width: 36px;
                    height: 36px;
                    display: inline-flex;
                    align-items: center;
                    justify-content: center;
                    padding: 0;
                }

                .empty-state-icon .icon {
                    transition: transform 0.3s ease;
                }

                .empty-state-icon:hover .icon {
                    transform: scale(1.05);
                }

                .text-2xl {
                    font-size: 1.5rem;
                }

                .btn {
                    border-radius: 0.5rem;
                    font-weight: 600;
                    transition: all 0.2s ease;
                }

                .btn:hover {
                    transform: translateY(-1px);
                    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                }
                </style>

                <script>
                // Initialize tooltips if using Bootstrap 5
                document.addEventListener('DOMContentLoaded', function() {
                    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
                    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                        return new bootstrap.Tooltip(tooltipTriggerEl)
                    })
                });
                </script>
    </div>
    
            <!-- Right Column - Progress, Deadlines, Activities -->


    <style>
        .card-action {
            border: 1px solid transparent;
            transition: all 0.3s ease;
            border-radius: 0.75rem;
            background-color: #fff;
        }

        .card-action:hover {
            border-color: rgba(94, 114, 228, 0.2);
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            text-decoration: none;
        }

        .icon-container {
            position: relative;
        }

        .icon-circle {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .card-action:hover .icon-circle {
            transform: scale(1.1);
        }

        .card-action h6 {
            font-weight: 600;
            color: #344767;
        }

        .card-action p {
            line-height: 1.4;
        }

        .card-header h5 {
            font-weight: 600;
            color: #344767;
        }

        .text-muted {
            color: #6c757d !important;
        }
        </style>


</x-app-layout>