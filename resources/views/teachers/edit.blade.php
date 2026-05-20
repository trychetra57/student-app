@extends('layouts.app')

@section('title', 'Edit Teacher — ' . $teacher->name)

@section('content')
<div class="container-lg" style="max-width:760px;">
    <div class="page-header">
        <h1 class="page-title"><i class="fas fa-edit"></i> Edit Teacher</h1>
        <div class="d-flex gap-2">
            <a href="{{ route('teachers.show', $teacher) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('teachers.update', $teacher) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="section-title">Personal Info</div>
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label class="form-label">Full Name *</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', $teacher->name) }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email *</label>
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
                    <div class="col-md-6">
                        <label class="form-label">Qualification</label>
                        <input type="text" name="qualification" class="form-control @error('qualification') is-invalid @enderror"
                               value="{{ old('qualification', $teacher->qualification) }}">
                        @error('qualification')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12">
                        <label for="profile_picture" class="form-label">Profile Picture</label>
                        @if($teacher->profile_picture_url)
                            <div class="mb-2">
                                <img src="{{ $teacher->profile_picture_url }}" alt="Profile" class="rounded-circle shadow-sm" style="width: 64px; height: 64px; object-fit: cover;">
                            </div>
                        @endif
                        <input type="file" class="form-control @error('profile_picture') is-invalid @enderror" 
                               id="profile_picture" name="profile_picture" accept="image/*">
                        @error('profile_picture')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror">
                            <option value="active"   {{ old('status',$teacher->status)==='active'  ?'selected':'' }}>Active</option>
                            <option value="inactive" {{ old('status',$teacher->status)==='inactive'?'selected':'' }}>Inactive</option>
                            <option value="on_leave" {{ old('status',$teacher->status)==='on_leave'?'selected':'' }}>On Leave</option>
                        </select>
                        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label">Address</label>
                        <textarea name="address" class="form-control @error('address') is-invalid @enderror"
                                  rows="2">{{ old('address', $teacher->address) }}</textarea>
                        @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="section-title">Teaching Details</div>
                <div class="row g-3 mb-4">
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
                        <label class="form-label">Joined Date</label>
                        <input type="date" name="joined_date" class="form-control @error('joined_date') is-invalid @enderror"
                               value="{{ old('joined_date', $teacher->joined_date?->format('Y-m-d')) }}">
                        @error('joined_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="d-flex gap-2 justify-content-end">
                    <a href="{{ route('teachers.show', $teacher) }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update Teacher</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
.section-title {
    font-size: .7rem;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: #94a3b8;
    margin-bottom: 12px;
    padding-bottom: 8px;
    border-bottom: 2px solid #f1f5f9;
}
</style>
@endsection
