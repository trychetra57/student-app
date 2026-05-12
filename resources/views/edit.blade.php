@extends('layouts.app')

@section('title', 'Edit Student - Student Management')

@section('content')
<div class="container-lg">
    <div class="page-header">
        <h1 class="page-title"><i class="fas fa-user-edit"></i> Edit Student</h1>
        <a href="{{ route('students.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <form method="POST" action="{{ route('students.update', $student) }}" novalidate>
                @csrf
                @method('PUT')

                <!-- Basic Information -->
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-user"></i> Basic Information
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name', $student->name) }}" 
                                       placeholder="Student full name" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email', $student->email) }}" 
                                       placeholder="student@example.com" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                       id="phone" name="phone" value="{{ old('phone', $student->phone) }}" 
                                       placeholder="Phone number">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="grade" class="form-label">Grade/Class</label>
                                <input type="text" class="form-control @error('grade') is-invalid @enderror" 
                                       id="grade" name="grade" value="{{ old('grade', $student->grade) }}" 
                                       placeholder="e.g., 10th Grade, Class A">
                                @error('grade')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="address" class="form-label">Address</label>
                                <textarea class="form-control @error('address') is-invalid @enderror" 
                                          id="address" name="address" rows="3" 
                                          placeholder="Student address">{{ old('address', $student->address) }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="date_of_birth" class="form-label">Date of Birth</label>
                                <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror" 
                                       id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', $student->date_of_birth ? $student->date_of_birth->format('Y-m-d') : '') }}">
                                @error('date_of_birth')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select @error('status') is-invalid @enderror" 
                                        id="status" name="status" required>
                                    <option value="">Select status...</option>
                                    <option value="active" {{ old('status', $student->status) == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status', $student->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    <option value="graduated" {{ old('status', $student->status) == 'graduated' ? 'selected' : '' }}>Graduated</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Guardian Information -->
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-users"></i> Guardian Information
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="guardian_name" class="form-label">Guardian Name</label>
                                <input type="text" class="form-control @error('guardian_name') is-invalid @enderror" 
                                       id="guardian_name" name="guardian_name" value="{{ old('guardian_name', $student->guardian_name) }}" 
                                       placeholder="Guardian full name">
                                @error('guardian_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="guardian_phone" class="form-label">Guardian Phone</label>
                                <input type="text" class="form-control @error('guardian_phone') is-invalid @enderror" 
                                       id="guardian_phone" name="guardian_phone" value="{{ old('guardian_phone', $student->guardian_phone) }}" 
                                       placeholder="Guardian phone number">
                                @error('guardian_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="d-flex gap-2 mb-4">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save"></i> Update Student
                    </button>
                    <a href="{{ route('students.index') }}" class="btn btn-secondary btn-lg">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                    <button type="button" class="btn btn-danger btn-lg ms-auto" onclick="confirmDelete(event, document.getElementById('sidebar-delete-form'), 'Delete this student?');">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </div>
            </form>
        </div>

        <!-- Sidebar Info -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-info-circle"></i> Student Info
                </div>
                <div class="card-body">
                    <p><small class="text-muted"><strong>ID:</strong> #{{ $student->id }}</small></p>
                    <p><small class="text-muted"><strong>Created:</strong> {{ $student->created_at->format('M j, Y') }}</small></p>
                    <p><small class="text-muted"><strong>Last Updated:</strong> {{ $student->updated_at->format('M j, Y') }}</small></p>
                    <hr>
                    <form id="sidebar-delete-form" method="POST" action="{{ route('students.destroy', $student) }}" onsubmit="confirmDelete(event, this, 'Delete this student?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger w-100">
                            <i class="fas fa-trash"></i> Delete Student
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
