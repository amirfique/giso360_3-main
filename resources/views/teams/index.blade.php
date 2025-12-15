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
            <!-- Create Team Card -->
            <div class="col-md-6 mb-4">
                <div class="simple-card">
                    <div class="card-header-simple">
                        <div class="d-flex align-items-center">
                            <div class="card-icon">
                                <i class="fas fa-plus"></i>
                            </div>
                            <div>
                                <h5 class="mb-0">Create New Team</h5>
                                <p class="text-sm opacity-8 mb-0">Start your own team and invite others</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body-simple">
                        <form action="{{ route('teams.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Team Name</label>
                                <input type="text" 
                                    name="name" 
                                    id="name"
                                    class="form-control @error('name') is-invalid @enderror" 
                                    placeholder="e.g., GISO Tokyo ISA 2026"
                                    value="{{ old('name') }}">
                                @error('name')
                                    <div class="text-danger text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" 
                                        id="description"
                                        class="form-control @error('description') is-invalid @enderror" 
                                        placeholder="Tell others about your team's purpose"
                                        rows="3">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="text-danger text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn-primary-simple">
                                <i class="fas fa-rocket me-2"></i>
                                Create Team
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Join Team Card -->
            <div class="col-md-6 mb-4">
                <div class="simple-card">
                    <div class="card-header-simple">
                        <div class="d-flex align-items-center">
                            <div class="card-icon">
                                <i class="fas fa-user-plus"></i>
                            </div>
                            <div>
                                <h5 class="mb-0">Join Existing Team</h5>
                                <p class="text-sm opacity-8 mb-0">Enter code to join a team</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body-simple">
                        <form action="{{ route('teams.join') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="code" class="form-label">Team Invitation Code</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-key"></i>
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
                            
                            <button type="submit" class="btn-primary-simple">
                                <i class="fas fa-sign-in-alt me-2"></i>
                                Join Team
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Teams List -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="simple-card">
                    <div class="card-header-simple">
                        <h5 class="mb-0">My Teams</h5>
                    </div>
                    <div class="card-body-simple">
                        @if($teams->isEmpty())
                            <div class="text-center py-4">
                                <p class="text-muted">No teams yet. Create or join a team to get started!</p>
                            </div>
                        @else
                            <div class="row">
                                @foreach($teams as $team)
                                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-4">
                                        <div class="team-card">
                                            <div class="team-icon">
                                                {{ strtoupper(substr($team->name, 0, 1)) }}
                                            </div>
                                            <div class="team-info">
                                                <h5 class="team-name">{{ $team->name }}</h5>
                                                <p class="team-desc">{{ $team->description ?? 'No description' }}</p>
                                                <div class="team-details">
                                                    <p class="team-meta">
                                                        <i class="fas fa-user me-1"></i>
                                                        Owner: {{ $team->owner->name }}
                                                    </p>
                                                    <p class="team-meta">
                                                        <i class="fas fa-users me-1"></i>
                                                        {{ $team->members->count() }} members
                                                    </p>
                                                </div>
                                                <a href="{{ route('teams.show', $team->slug) }}" class="btn-view-team">
                                                    View Team
                                                </a>
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

    /* Form Styles */
    .form-label {
        color: var(--dark);
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

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

    .input-group-text {
        background: var(--white);
        border: 2px solid var(--border-color);
        border-right: none;
        color: var(--primary);
    }

    .form-text {
        color: var(--secondary);
        font-size: 0.875rem;
    }

    /* Button Styles */
    .btn-primary-simple {
        background: var(--primary);
        border: 2px solid var(--primary);
        border-radius: 8px;
        padding: 0.75rem 1.5rem;
        color: var(--white);
        font-weight: 600;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-primary-simple:hover {
        background: #6439b3;
        border-color: #6439b3;
    }

    /* Team Card Styles */
    .team-card {
        background: var(--white);
        border-radius: 12px;
        padding: 1.5rem;
        border: 2px solid var(--border-color);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        height: 100%;
        display: flex;
        flex-direction: column;
        transition: all 0.2s ease;
    }

    .team-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12);
        border-color: var(--border-dark);
    }

    .team-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        color: var(--white);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        font-weight: bold;
        margin: 0 auto 1rem;
    }

    .team-info {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .team-name {
        color: var(--dark);
        font-weight: 600;
        font-size: 1.1rem;
        margin-bottom: 0.5rem;
        text-align: center;
    }

    .team-desc {
        color: var(--secondary);
        font-size: 0.9rem;
        margin-bottom: 1rem;
        text-align: center;
        flex-grow: 1;
    }

    .team-details {
        margin-bottom: 1rem;
    }

    .team-meta {
        color: var(--secondary);
        font-size: 0.85rem;
        margin-bottom: 0.5rem;
    }

    .btn-view-team {
        background: var(--white);
        border: 2px solid var(--primary);
        border-radius: 8px;
        padding: 0.5rem 1rem;
        color: var(--primary);
        font-weight: 500;
        text-align: center;
        transition: all 0.2s ease;
    }

    .btn-view-team:hover {
        background: var(--primary);
        color: var(--white);
        border-color: var(--primary);
    }
    </style>
</x-app-layout>