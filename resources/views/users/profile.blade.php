@extends('layouts.app')

@section('title', 'My Profile Settings')

@section('content')
<div class="container-fluid px-0">
    <!-- Header Card -->
    <div class="card border-0 shadow-sm rounded-4 mb-4" style="background: linear-gradient(135deg, #125875 0%, #0d3f54 100%); color: white;">
        <div class="card-body p-4 d-flex align-items-center gap-3">
            <div class="rounded-circle bg-white text-primary d-flex align-items-center justify-content-center fw-bold text-uppercase" style="width: 64px; height: 64px; font-size: 1.8rem; box-shadow: 0 4px 10px rgba(0,0,0,0.15);">
                {{ strtoupper(substr($user->name, 0, 2)) }}
            </div>
            <div>
                <h4 class="fw-bold mb-1">{{ $user->name }}</h4>
                <p class="mb-0 text-white-50"><i class="fas fa-shield-alt me-1"></i> {{ ucwords(str_replace('_', ' ', $user->role ?? 'staff')) }} Profile Account &mdash; Student Management System</p>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Profile details -->
        <div class="col-12 col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="fw-bold text-dark mb-0"><i class="fas fa-user-edit me-2"></i> Account Details</h5>
                </div>
                <div class="card-body">
                    <form onsubmit="event.preventDefault(); Swal.fire('Profile Updated', 'Your profile details have been saved (mock action).', 'success')">
                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-bold small text-muted">Full Name</label>
                                <input type="text" class="form-control rounded-3" value="{{ $user->name }}" required>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-bold small text-muted">Email Address</label>
                                <input type="email" class="form-control rounded-3" value="{{ $user->email }}" required>
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-bold small text-muted">New Password</label>
                                <input type="password" class="form-control rounded-3" placeholder="Leave blank to keep current password">
                            </div>
                            <div class="col-12 col-md-6">
                                <label class="form-label fw-bold small text-muted">Confirm Password</label>
                                <input type="password" class="form-control rounded-3" placeholder="Confirm new password">
                            </div>

                            <div class="col-12 text-end mt-4">
                                <button type="submit" class="btn btn-primary px-4 rounded-3 fw-bold"><i class="fas fa-save me-2"></i> Update Profile</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- System info / metadata -->
        <div class="col-12 col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="fw-bold text-dark mb-0"><i class="fas fa-server me-2"></i> Session Information</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between text-muted small py-2 border-bottom">
                        <span>Account Role</span>
                        <strong class="text-primary">{{ ucwords(str_replace('_', ' ', $user->role ?? 'staff')) }}</strong>
                    </div>
                    <div class="d-flex justify-content-between text-muted small py-2 border-bottom">
                        <span>Created At</span>
                        <strong class="text-dark">{{ $user->created_at ? $user->created_at->format('M d, Y H:i') : 'N/A' }}</strong>
                    </div>
                    <div class="d-flex justify-content-between text-muted small py-2 border-bottom">
                        <span>Last Login IP</span>
                        <strong class="text-dark">127.0.0.1 (Localhost)</strong>
                    </div>
                    <div class="d-flex justify-content-between text-muted small py-2">
                        <span>Security Level</span>
                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill">High Security</span>
                    </div>
                </div>
            </div>

            <!-- Profile tip -->
            <div class="card border-0 shadow-sm rounded-4 bg-light border-start border-4 border-info">
                <div class="card-body">
                    <h6 class="fw-bold text-info mb-2"><i class="fas fa-shield-alt"></i> Security Recommendation</h6>
                    <p class="small text-muted mb-0">We recommend changing your password every 90 days to maintain dashboard integrity. Always use a combination of symbols, numbers, and uppercase characters.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
