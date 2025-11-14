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
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card border shadow-xs">
                        <div class="card-body p-4">
                            <h1 class="h4 text-gradient text-primary mb-2">Team Management</h1>
                            <p class="text-sm mb-0">Create or Join Team</p>
                        </div>
                    </div>
                </div>
            </div>               


        <div class="row">
            <!-- Create Team Card -->
            <div class="col-md-6 mb-4 ">
                <div class="card shadow-xs border h-100">
                    <div class="card-header pb-0">
                        <h6>Create New Team</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('teams.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Team name</label>
                                <input type="text" 
                                       name="name" 
                                       id="name"
                                       class="form-control @error('name') is-invalid @enderror" 
                                       placeholder="eg. GISO Tokyo ISA 2026"
                                       value="{{ old('name') }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" 
                                          id="description"
                                          class="form-control @error('description') is-invalid @enderror" 
                                          placeholder="Short description">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">
                                Create Team
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Join Team Card -->
            <div class="col-md-6 mb-4">
                <div class="card shadow-xs border h-100">
                    <div class="card-header pb-0">
                        <h6>Join Team</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('teams.join') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="code" class="form-label">Enter join code</label>
                                <div class="input-group">
                                    <input type="text"
                                           name="code"
                                           id="code"
                                           class="form-control text-uppercase @error('code') is-invalid @enderror"
                                           placeholder="ABC123"
                                           value="{{ old('code') }}"
                                           style="letter-spacing: 2px; font-weight: bold;">
                                    <button type="submit" class="btn btn-primary">Join</button>
                                </div>
                                @error('code')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
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