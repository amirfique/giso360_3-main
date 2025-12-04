<x-app-layout>
    <div class="container-fluid py-4">
        <!-- Profile Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-xs overflow-hidden">
                    <div class="card-header bg-gradient-primary p-5 position-relative">
                        <div class="bg-pattern bg-white opacity-2"></div>
                        <div class="row align-items-center position-relative">
                            <div class="col-md-8">
                                <h3 class="text-white mb-1">My Profile</h3>
                                <p class="text-white opacity-8 mb-0">Manage your personal information and account settings</p>
                            </div>
                            <div class="col-md-4 text-end">
                                <div class="icon icon-shape bg-white bg-opacity-10 shadow text-center rounded-circle d-inline-flex align-items-center justify-content-center">
                                    <i class="fas fa-user-cog text-white"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Main Content Area -->
            <div class="col-12">
                <div class="card border-0 shadow-xs">
                    <div class="card-body p-4">
                        @if (session('success'))
                            <div class="alert alert-success border-radius-lg d-flex align-items-center mb-4" role="alert">
                                <i class="fas fa-check-circle me-2"></i>
                                <span class="text-sm">{{ session('success') }}</span>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger border-radius-lg mb-4" role="alert">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-exclamation-circle me-2"></i>
                                    <span class="text-sm">Please fix the following errors:</span>
                                </div>
                                <ul class="mb-0 ps-3 text-sm">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" id="profileForm">
                            @csrf
                            @method('PATCH')

                            <div class="row">
                                <!-- Left Column - Profile Picture & Basic Info -->
                                <div class="col-lg-4 mb-4">
                                    <!-- Profile Picture Section -->
                                    <div class="text-center mb-4">
                                        <div class="position-relative d-inline-block">
                                            <div class="avatar-upload">
                                                <div class="avatar-edit">
                                                    <input type="file" name="avatar" id="avatarUpload" accept=".png, .jpg, .jpeg" class="d-none">
                                                    <label for="avatarUpload" class="btn btn-sm bg-gradient-primary shadow-primary mb-0 position-absolute bottom-0 end-0 rounded-circle">
                                                        <i class="fas fa-camera text-white"></i>
                                                    </label>
                                                </div>
                                                <div class="avatar-preview">
                                                    @if(auth()->user()->avatar)
                                                        <div id="imagePreview" 
                                                             style="background-image: url('{{ asset('storage/' . auth()->user()->avatar) }}');">
                                                        </div>
                                                    @else
                                                        <div id="imagePreview" 
                                                             style="background-image: url('https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=5e72e4&color=ffffff&size=150');">
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <p class="text-sm text-muted mt-2">Click the camera icon to update your profile photo</p>
                                    </div>

                                    <!-- Team Stats Card -->
                                    <div class="card border-0 shadow-xs bg-gray-100">
                                        <div class="card-body text-center p-4">
                                            <div class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle mx-auto mb-3">
                                                <i class="fas fa-users text-white"></i>
                                            </div>
                                            <h2 class="text-primary mb-1">{{ $teamCount }}</h2>
                                            <h6 class="text-dark mb-3">GISO Teams</h6>
                                            <p class="text-sm text-muted mb-0">
                                                Number of teams you are currently a member of
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Account Info -->
                                    <div class="card border-0 shadow-xs mt-4">
                                        <div class="card-header bg-transparent">
                                            <h6 class="mb-0">Account Information</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <span class="text-sm text-muted">Member Since</span>
                                                <span class="text-sm fw-bold text-dark">
                                                    {{ auth()->user()->created_at->format('M d, Y') }}
                                                </span>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <span class="text-sm text-muted">Account Role</span>
                                                <span class="badge bg-gradient-{{ auth()->user()->role === 'admin' ? 'warning' : 'info' }}">
                                                    {{ ucfirst(auth()->user()->role) }}
                                                </span>
                                            </div>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="text-sm text-muted">Last Updated</span>
                                                <span class="text-sm fw-bold text-dark">
                                                    {{ auth()->user()->updated_at->format('M d, Y') }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Right Column - Form Fields -->
                                <div class="col-lg-8">
                                    <div class="ps-lg-4">
                                        <h5 class="text-dark mb-4">Personal Information</h5>
                                        
                                        <!-- Username Field -->
                                        <div class="form-group mb-4">
                                            <label for="name" class="form-label text-dark fw-bold mb-2">
                                                <i class="fas fa-user me-2 text-primary"></i>Username
                                            </label>
                                            <div class="input-group input-group-outline">
                                                <input type="text" 
                                                       name="name" 
                                                       id="name"
                                                       class="form-control border-radius-lg" 
                                                       value="{{ old('name', auth()->user()->name) }}"
                                                       placeholder="Enter your username">
                                            </div>
                                            @error('name')
                                                <div class="text-danger text-xs mt-1">
                                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <!-- Email Field -->
                                        <div class="form-group mb-4">
                                            <label for="email" class="form-label text-dark fw-bold mb-2">
                                                <i class="fas fa-envelope me-2 text-primary"></i>Email Address
                                            </label>
                                            <div class="input-group input-group-outline">
                                                <input type="email" 
                                                       name="email" 
                                                       id="email"
                                                       class="form-control border-radius-lg" 
                                                       value="{{ old('email', auth()->user()->email) }}"
                                                       placeholder="Enter your email address">
                                            </div>
                                            @error('email')
                                                <div class="text-danger text-xs mt-1">
                                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                                </div>
                                            @enderror
                                        </div>

                                        <!-- Action Buttons -->
                                        <div class="d-flex justify-content-between align-items-center mt-5 pt-4 border-top">
                                            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                                                <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                                            </a>
                                            <button type="submit" class="btn bg-gradient-primary">
                                                <i class="fas fa-save me-2"></i>Save Changes
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
    .card {
        border-radius: 0.75rem;
    }
    
    .shadow-xs {
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06) !important;
    }
    
    .border-radius-lg {
        border-radius: 0.75rem !important;
    }
    
    .avatar-upload {
        position: relative;
        max-width: 150px;
        margin: 0 auto;
    }
    
    .avatar-edit {
        position: absolute;
        right: 0;
        bottom: 0;
        z-index: 1;
    }
    
    .avatar-preview {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        border: 4px solid #fff;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }
    
    .avatar-preview div {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
    }
    
    .input-group-outline .form-control {
        border: 1px solid #d2d6da;
        background: transparent;
        transition: all 0.2s ease;
    }
    
    .input-group-outline .form-control:focus {
        border-color: #5e72e4;
        box-shadow: 0 0 0 2px rgba(94, 114, 228, 0.1);
    }
    
    .bg-pattern {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        opacity: 0.1;
        background: url("data:image/svg+xml,%3Csvg width='20' height='20' viewBox='0 0 20 20' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23ffffff' fill-opacity='0.2' fill-rule='evenodd'%3E%3Ccircle cx='3' cy='3' r='3'/%3E%3Ccircle cx='13' cy='13' r='3'/%3E%3C/g%3E%3C/svg%3E");
    }
    
    .bg-gray-100 {
        background-color: #f8f9fa !important;
    }
    
    .icon {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .ps-lg-4 {
        padding-left: 1.5rem;
    }
    
    @media (max-width: 991.98px) {
        .ps-lg-4 {
            padding-left: 0;
            padding-top: 1.5rem;
        }
    }
    </style>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Avatar upload preview
        const avatarUpload = document.getElementById('avatarUpload');
        const imagePreview = document.getElementById('imagePreview');
        
        if (avatarUpload && imagePreview) {
            avatarUpload.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imagePreview.style.backgroundImage = `url(${e.target.result})`;
                    }
                    reader.readAsDataURL(file);
                    
                    // Auto-submit form when avatar is selected
                    setTimeout(() => {
                        document.getElementById('profileForm').submit();
                    }, 500);
                }
            });
        }

        // Add loading state to form submission
        const profileForm = document.getElementById('profileForm');
        if (profileForm) {
            profileForm.addEventListener('submit', function() {
                const submitBtn = this.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Saving...';
                    submitBtn.disabled = true;
                }
            });
        }
    });
    </script>
</x-app-layout>