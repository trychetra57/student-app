@extends('layouts.app')

@section('title', 'Edit Teacher — ' . $teacher->name)

@section('content')
<div class="container-lg">
    <div class="page-header">
        <h1 class="page-title"><i class="fas fa-edit"></i> Edit Teacher</h1>
        <div class="d-flex gap-2">
            <a href="{{ route('teachers.show', $teacher) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Profile
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <form method="POST" action="{{ route('teachers.update', $teacher) }}" enctype="multipart/form-data" novalidate>
                @csrf
                @method('PUT')

                <!-- Personal Information -->
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-user"></i> Personal Information
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name', $teacher->name) }}" required>
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                       value="{{ old('email', $teacher->email) }}" required>
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">Phone</label>
                                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                                       value="{{ old('phone', $teacher->phone) }}">
                                @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">Date of Birth</label>
                                <input type="date" name="date_of_birth" class="form-control @error('date_of_birth') is-invalid @enderror"
                                       value="{{ old('date_of_birth', $teacher->date_of_birth?->format('Y-m-d')) }}">
                                @error('date_of_birth')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            
                            <div class="col-12">
                                <label class="form-label">Address</label>
                                <textarea name="address" class="form-control @error('address') is-invalid @enderror"
                                          rows="2">{{ old('address', $teacher->address) }}</textarea>
                                @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            
                            <div class="col-12">
                                <label for="profile_picture" class="form-label">Profile Picture</label>
                                @if($teacher->profile_picture_url)
                                    <div class="mb-3 d-flex align-items-center gap-3 p-3 bg-light rounded border">
                                        <img src="{{ $teacher->profile_picture_url }}" alt="Profile" class="rounded-circle shadow-sm" style="width: 64px; height: 64px; object-fit: cover; border: 2px solid white;">
                                        <div>
                                            <p class="mb-1 fw-600">Current Picture</p>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="remove_profile_picture" value="true" id="remove_picture">
                                                <label class="form-check-label text-danger" for="remove_picture">
                                                    Remove picture
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <input type="file" class="form-control @error('profile_picture') is-invalid @enderror" 
                                       id="profile_picture" name="profile_picture" accept="image/*">
                                <div class="form-text">Leave empty to keep the current picture. Select a new image to replace it.</div>
                                @error('profile_picture')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Professional Information -->
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-briefcase"></i> Professional Information
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Subject</label>
                                <input type="text" name="subject" class="form-control @error('subject') is-invalid @enderror"
                                       value="{{ old('subject', $teacher->subject) }}">
                                @error('subject')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">Department</label>
                                <input type="text" name="department" class="form-control @error('department') is-invalid @enderror"
                                       value="{{ old('department', $teacher->department) }}">
                                @error('department')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">Qualification</label>
                                <input type="text" name="qualification" class="form-control @error('qualification') is-invalid @enderror"
                                       value="{{ old('qualification', $teacher->qualification) }}">
                                @error('qualification')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">Joined Date</label>
                                <input type="date" name="joined_date" class="form-control @error('joined_date') is-invalid @enderror"
                                       value="{{ old('joined_date', $teacher->joined_date?->format('Y-m-d')) }}">
                                @error('joined_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            
                            <div class="col-md-12">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                    <option value="active"   {{ old('status',$teacher->status)==='active'  ?'selected':'' }}>Active</option>
                                    <option value="inactive" {{ old('status',$teacher->status)==='inactive'?'selected':'' }}>Inactive</option>
                                    <option value="on_leave" {{ old('status',$teacher->status)==='on_leave'?'selected':'' }}>On Leave</option>
                                </select>
                                @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="d-flex gap-2 mb-4">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save"></i> Update Teacher
                    </button>
                    <a href="{{ route('teachers.show', $teacher) }}" class="btn btn-secondary btn-lg">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </form>

            @if(Auth::user()->isAdmin())
            <div class="card border-danger mt-5">
                <div class="card-header bg-danger text-white">
                    <i class="fas fa-exclamation-triangle"></i> Danger Zone
                </div>
                <div class="card-body">
                    <p>Deleting this teacher will remove them from the system. This action cannot be undone.</p>
                    <form method="POST" action="{{ route('teachers.destroy', $teacher) }}" onsubmit="confirmDelete(event, this, 'Are you sure you want to delete this teacher?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger">
                            <i class="fas fa-trash-alt"></i> Delete Teacher
                        </button>
                    </form>
                </div>
            </div>
            @endif
        </div>

        <!-- Form Information -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-info-circle"></i> Form Information
                </div>
                <div class="card-body">
                    <p><strong>Required Fields:</strong></p>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-check text-success"></i> Full Name</li>
                        <li><i class="fas fa-check text-success"></i> Email</li>
                        <li><i class="fas fa-check text-success"></i> Status</li>
                    </ul>
                    <hr>
                    <p><small class="text-muted">Fill in all required fields marked with <span class="text-danger">*</span> to update the teacher in the system. Profile pictures must be less than 2MB.</small></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
