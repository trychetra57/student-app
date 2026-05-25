@extends('layouts.app')

@section('title', 'Edit Student - Student Management')

@section('styles')
<style>
.form-card {
    background: white;
    border-radius: 20px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    padding: 30px;
    margin-bottom: 24px;
    border: none;
}
.form-card-header {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 25px;
    padding-bottom: 15px;
    border-bottom: 2px solid #f8fafc;
    font-size: 1.25rem;
    font-weight: 700;
    color: #1e293b;
}
.form-card-header i {
    color: #6366f1;
    background: #e0e7ff;
    padding: 10px;
    border-radius: 12px;
}
.custom-form-label {
    font-weight: 600;
    color: #475569;
    font-size: 0.9rem;
    margin-bottom: 8px;
}
.custom-input {
    border-radius: 12px;
    border: 2px solid #e2e8f0;
    padding: 12px 16px;
    transition: all 0.2s;
    background: #f8fafc;
}
.custom-input:focus {
    background: white;
    border-color: #6366f1;
    box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
}
.profile-preview {
    width: 100px;
    height: 100px;
    border-radius: 20px;
    object-fit: cover;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    border: 3px solid white;
}
</style>
@endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="page-title mb-1"><i class="fas fa-user-edit text-primary me-2"></i> Edit Student</h1>
        <p class="text-muted mb-0">Update information for {{ $student->name }}</p>
    </div>
    <a href="{{ route('students.show', $student) }}" class="btn btn-secondary" style="border-radius:10px; padding:10px 20px; font-weight:600;">
        <i class="fas fa-arrow-left me-2"></i> Back to Profile
    </a>
</div>

<form method="POST" action="{{ route('students.update', $student) }}" enctype="multipart/form-data" novalidate id="editForm">
    @csrf
    @method('PUT')
    
    <div class="row">
        <div class="col-lg-8">
            <div class="form-card">
                <div class="form-card-header">
                    <i class="fas fa-id-badge"></i> Personal Information
                </div>
                
                <div class="row g-4">
                    <div class="col-md-6">
                        <label for="name" class="custom-form-label">Full Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control custom-input @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name', $student->name) }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label for="email" class="custom-form-label">Email Address <span class="text-danger">*</span></label>
                        <input type="email" class="form-control custom-input @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email', $student->email) }}" required>
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label for="phone" class="custom-form-label">Phone Number</label>
                        <input type="text" class="form-control custom-input @error('phone') is-invalid @enderror" 
                               id="phone" name="phone" value="{{ old('phone', $student->phone) }}">
                        @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label for="date_of_birth" class="custom-form-label">Date of Birth</label>
                        <input type="date" class="form-control custom-input @error('date_of_birth') is-invalid @enderror" 
                               id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', $student->date_of_birth ? $student->date_of_birth->format('Y-m-d') : '') }}">
                        @error('date_of_birth')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    
                    <div class="col-12">
                        <label for="address" class="custom-form-label">Home Address</label>
                        <textarea class="form-control custom-input @error('address') is-invalid @enderror" 
                                  id="address" name="address" rows="3">{{ old('address', $student->address) }}</textarea>
                        @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <div class="form-card">
                <div class="form-card-header">
                    <i class="fas fa-users"></i> Guardian Information
                </div>
                
                <div class="row g-4">
                    <div class="col-md-6">
                        <label for="guardian_name" class="custom-form-label">Guardian Name</label>
                        <input type="text" class="form-control custom-input @error('guardian_name') is-invalid @enderror" 
                               id="guardian_name" name="guardian_name" value="{{ old('guardian_name', $student->guardian_name) }}">
                        @error('guardian_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label for="guardian_phone" class="custom-form-label">Guardian Phone</label>
                        <input type="text" class="form-control custom-input @error('guardian_phone') is-invalid @enderror" 
                               id="guardian_phone" name="guardian_phone" value="{{ old('guardian_phone', $student->guardian_phone) }}">
                        @error('guardian_phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
            
            <div class="d-flex justify-content-end gap-3 mb-5">
                <a href="{{ route('students.show', $student) }}" class="btn btn-light border btn-lg px-4" style="border-radius:12px; font-weight:600;">Cancel</a>
                <button type="submit" class="btn btn-primary btn-lg px-5 shadow-sm" style="border-radius:12px; font-weight:600;">
                    <i class="fas fa-save me-2"></i> Save Changes
                </button>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="form-card">
                <div class="form-card-header">
                    <i class="fas fa-graduation-cap"></i> Academic Info
                </div>
                
                <div class="mb-4">
                    <label for="grade" class="custom-form-label">Grade / Class</label>
                    <input type="text" class="form-control custom-input @error('grade') is-invalid @enderror" 
                           id="grade" name="grade" value="{{ old('grade', $student->grade) }}">
                    @error('grade')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                
                <div class="mb-3">
                    <label for="status" class="custom-form-label">Enrollment Status <span class="text-danger">*</span></label>
                    <select class="form-select custom-input @error('status') is-invalid @enderror" 
                            id="status" name="status" required>
                        <option value="active" {{ old('status', $student->status) == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $student->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="graduated" {{ old('status', $student->status) == 'graduated' ? 'selected' : '' }}>Graduated</option>
                    </select>
                    @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            
            <div class="form-card">
                <div class="form-card-header">
                    <i class="fas fa-camera"></i> Profile Picture
                </div>
                
                <div class="text-center mb-4">
                    @if($student->profile_picture_url)
                        <img src="{{ $student->profile_picture_url }}" alt="Profile" class="profile-preview mb-3" id="imgPreview">
                        <div class="form-check d-flex justify-content-center align-items-center gap-2 mb-3">
                            <input class="form-check-input" type="checkbox" name="remove_profile_picture" id="remove_profile_picture" value="true">
                            <label class="form-check-label text-danger" for="remove_profile_picture">
                                Remove current picture
                            </label>
                        </div>
                    @else
                        <div class="profile-preview mx-auto mb-3" style="background:#e2e8f0; display:flex; align-items:center; justify-content:center;" id="imgPlaceholder">
                            <i class="fas fa-user text-white fs-1"></i>
                        </div>
                    @endif
                    <input type="file" class="form-control custom-input @error('profile_picture') is-invalid @enderror" 
                           id="profile_picture" name="profile_picture" accept="image/*">
                    <small class="text-muted d-block mt-2">Allowed: JPEG, PNG, WEBP (Max 2MB)</small>
                    @error('profile_picture')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>
            </div>
            
            @if(Auth::user()->isAdmin())
            <div class="form-card" style="border:2px dashed #fecdd3; background:#fff1f2;">
                <div class="form-card-header text-danger" style="border-bottom-color:#ffe4e6;">
                    <i class="fas fa-exclamation-triangle bg-white text-danger"></i> Danger Zone
                </div>
                <p style="font-size:0.85rem; color:#be123c;" class="mb-3">Deleting a student will soft-delete their record. This action can be undone by a super admin.</p>
                <button type="button" class="btn btn-danger w-100 fw-bold" style="border-radius:10px;" 
                        onclick="confirmDelete(event, document.getElementById('deleteForm'), 'Delete this student?');">
                    <i class="fas fa-trash-alt me-2"></i> Delete Student
                </button>
            </div>
            @endif
        </div>
    </div>
</form>

@if(Auth::user()->isAdmin())
<form id="deleteForm" method="POST" action="{{ route('students.destroy', $student) }}" style="display:none;">
    @csrf @method('DELETE')
</form>
@endif

@endsection
