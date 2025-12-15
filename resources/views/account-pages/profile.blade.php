<x-app-layout>
    <div class="container-fluid py-4 px-5">
        <!-- Page Header -->
        <div class="row">
            <div class="col-12">
                <div class="card card-background card-background-after-none align-items-start mt-4 mb-5">
                    <div class="full-background" style="background-image: url('{{ asset('assets/img/header-blue-purple.jpg') }}')"></div>
                    <div class="card-body text-start p-4 w-100">
                        <h3 class="text-white my-3">My Profile</h3>
                        <p class="mb-4 mt-2 font-weight-semibold">
                            Manage your personal information and account settings
                        </p>
                        <img src="{{ asset('assets/img/profile-management 3d.png') }}" alt="profile management"
                            class="position-absolute top-0 end-0 w-25 max-width-200 mt-n4 d-sm-block d-none" />
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Main Content Area -->
            <div class="col-12">
                <div class="simple-card">
                    <div class="card-header-simple">
                        <div class="d-flex align-items-center">
                            <div class="card-icon">
                                <i class="fas fa-user-cog"></i>
                            </div>
                            <div>
                                <h5 class="mb-0">Profile Information</h5>
                                <p class="text-sm opacity-8 mb-0">Update your personal details and avatar</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body-simple">
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
                                                    <label for="avatarUpload" class="btn-primary-simple position-absolute bottom-0 end-0 rounded-circle" style="width: 40px; height: 40px; padding: 0; display: flex; align-items: center; justify-content: center;">
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
                                                             style="background-image: url('https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=774dd3&color=ffffff&size=150');">
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        <p class="text-sm text-muted mt-2">Click the camera icon to update your profile photo</p>
                                    </div>

                                    <!-- Account Info -->
                                    <div class="simple-card" style="background: rgba(100, 116, 139, 0.05); border-color: rgba(100, 116, 139, 0.2);">
                                        <div class="card-body">
                                            <h6 class="mb-3 text-dark fw-bold">Account Information</h6>
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
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="fas fa-user text-primary"></i>
                                                </span>
                                                <input type="text" 
                                                       name="name" 
                                                       id="name"
                                                       class="form-control @error('name') is-invalid @enderror" 
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
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="fas fa-envelope text-primary"></i>
                                                </span>
                                                <input type="email" 
                                                       name="email" 
                                                       id="email"
                                                       class="form-control @error('email') is-invalid @enderror" 
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
                                            <a href="{{ route('dashboard') }}" class="btn-white-simple">
                                                <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                                            </a>
                                            <button type="submit" class="btn-primary-simple">
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
        background: linear-gradient(135deg, rgba(119, 77, 211, 0.1) 0%, rgba(119, 77, 211, 0.1) 100%);
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

    .input-group .form-control {
        border-left: none;
    }

    .input-group:focus-within .input-group-text {
        border-color: var(--primary);
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

    .btn-white-simple:hover {
        background: #f8fafc;
        border-color: var(--border-dark);
    }

    /* Avatar Styles */
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
        border: 4px solid var(--white);
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

    /* Card Background Styles */
    .card-background {
        position: relative;
        overflow: hidden;
    }
    
    .full-background {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-size: cover;
        background-position: center;
        z-index: 0;
    }
    
    .card-background .card-body {
        position: relative;
        z-index: 1;
    }
    
    .card-background-after-none::after {
        display: none;
    }

    /* Additional Styles */
    .border-radius-lg {
        border-radius: 0.75rem !important;
    }

    .icon-shape {
        width: 2.5rem;
        height: 2.5rem;
        display: inline-flex;
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