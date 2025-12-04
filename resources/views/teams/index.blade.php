<x-app-layout>
    <div class="container-fluid py-4 px-5">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Page Header -->
        <div class="row">
            <div class="col-12">
                <div class="card card-background card-background-after-none align-items-start mt-4 mb-5">
                    <div class="full-background"
                        style="background-image: url('../assets/img/header-blue-purple.jpg')"></div>
                    <div class="card-body text-start p-4 w-100">
                        <h3 class="text-white my-3">Team Management</h3>
                        <p class="mb-4 mt-2 font-weight-semibold">
                            Create or Join and Manage your Team
                        </p>
                        <img src="../assets/img/team management 3d.png" alt="3d-cube"
                            class="position-absolute top-0 end-1 w-25 max-width-200 mt-n6 d-sm-block d-none" />
                    </div>
                </div>
            </div>
        </div>
        

        <div class="row">
            <!-- Create Team Card - Enhanced -->
            <div class="col-md-6 mb-4">
                <div class="card shadow-lg border-0 h-100">
                    <div class="card-header bg-gradient-primary text-white pb-3 pt-4">
                        <div class="d-flex align-items-center">
                            <div class="icon icon-shape bg-white shadow text-center border-radius-md me-3">
                                <i class="fas fa-plus text-primary text-lg"></i>
                            </div>
                            <div>
                                <h5 class="mb-0 text-white">Create New Team</h5>
                                <p class="text-sm opacity-8 mb-0">Start your own team and invite others</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('teams.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label fw-bold">Team Name</label>
                                <div class="input-group input-group-static">
                                    <input type="text" 
                                           name="name" 
                                           id="name"
                                           class="form-control @error('name') is-invalid @enderror" 
                                           placeholder="e.g., GISO Tokyo ISA 2026"
                                           value="{{ old('name') }}">
                                </div>
                                @error('name')
                                    <div class="text-danger text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="description" class="form-label fw-bold">Description</label>
                                <div class="input-group input-group-static">
                                    <textarea name="description" 
                                              id="description"
                                              class="form-control @error('description') is-invalid @enderror" 
                                              placeholder="Tell others about your team's purpose"
                                              rows="3">{{ old('description') }}</textarea>
                                </div>
                                @error('description')
                                    <div class="text-danger text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-lg btn-primary w-100 d-flex align-items-center justify-content-center">
                                <i class="fas fa-rocket me-2"></i>
                                Create Team
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Join Team Card - Enhanced -->
            <div class="col-md-6 mb-4">
                <div class="card shadow-lg border-0 h-100">
                    <div class="card-header bg-gradient-primary text-white pb-3 pt-4">
                        <div class="d-flex align-items-center">
                            <div class="icon icon-shape bg-white shadow text-center border-radius-md me-3">
                                <i class="fas fa-user-plus text-primary text-lg"></i>
                            </div>
                            <div>
                                <h5 class="mb-0 text-white">Join Existing Team</h5>
                                <p class="text-sm opacity-8 mb-0">Enter code to join a team</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4 d-flex flex-column">
                        <form action="{{ route('teams.join') }}" method="POST" class="flex-grow-1 d-flex flex-column">
                            @csrf
                            <div class="mb-4">
                                <label for="code" class="form-label fw-bold">Team Invitation Code</label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text bg-gray-200 border-0">
                                        <i class="fas fa-key text-dark"></i>
                                    </span>
                                    <input type="text"
                                           name="code"
                                           id="code"
                                           class="form-control text-uppercase text-center @error('code') is-invalid @enderror"
                                           placeholder="ABC123"
                                           value="{{ old('code') }}"
                                           style="letter-spacing: 3px; font-weight: bold; font-size: 1.1rem;">
                                </div>
                                @error('code')
                                    <div class="text-danger text-sm mt-1">{{ $message }}</div>
                                @enderror
                                <div class="form-text mt-2">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Ask your team administrator for the invitation code
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-lg btn-primary w-100 mt-auto d-flex align-items-center justify-content-center">
                                <i class="fas fa-sign-in-alt me-2"></i>
                                Join Team
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Teams List with Responsive Grid -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card shadow-xs border h-100">
                    <div class="card-header pb-0">
                        <h6>My Teams</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        @if($teams->isEmpty())
                            <div class="text-center py-4">
                                <p class="text-muted">No teams yet. Create or join a team to get started!</p>
                            </div>
                        @else
                            <div class="row mx-2">
                                @foreach($teams as $team)
                                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-4">
                                        <div class="card border h-100">
                                            <!-- Team Icon/Image -->
                                            <div class="card-img-top d-flex justify-content-center align-items-center bg-gradient-primary text-white p-4" 
                                                style="height: 120px; border-radius: 0.375rem 0.375rem 0 0;">
                                                <div class="icon icon-shape icon-lg bg-white shadow text-center border-radius-md">
                                                    <span class="text-primary text-lg font-weight-bold">
                                                        {{ strtoupper(substr($team->name, 0, 1)) }}
                                                    </span>
                                                </div>
                                            </div>
                                            
                                            <div class="card-body d-flex flex-column">
                                                <h5 class="card-title">{{ $team->name }}</h5>
                                                <p class="card-text text-sm text-secondary mb-2 flex-grow-1">
                                                    {{ $team->description ?? 'No description' }}
                                                </p>
                                                <div class="mt-auto">
                                                    <p class="card-text text-sm text-muted mb-2">
                                                        <i class="fas fa-user me-1"></i>
                                                        Owner: {{ $team->owner->name }}
                                                    </p>
                                                    <p class="card-text text-sm text-muted mb-3">
                                                        <i class="fas fa-users me-1"></i>
                                                        {{ $team->members->count() }} members
                                                    </p>
                                                    <a href="{{ route('teams.show', $team->slug) }}" 
                                                    class="btn btn-outline-primary btn-sm w-100">
                                                        View GISO
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>