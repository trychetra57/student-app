@extends('layouts.app')

@section('title', 'Add Class - BelTei University Admin')

@section('content')
<div class="container-lg">
    <div class="page-header">
        <h1 class="page-title"><i class="fas fa-door-open"></i> Add New Class</h1>
        <a href="{{ route('classes.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <form action="{{ route('classes.store') }}" method="POST" novalidate>
                @csrf

                <!-- Class Details -->
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-info-circle"></i> Class Details
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Class Name <span class="text-danger">*</span></label>
                                <input type="text" name="name"
                                       class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name') }}"
                                       placeholder="e.g. Grade 10A" required>
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Room Number</label>
                                <input type="text" name="room_number"
                                       class="form-control @error('room_number') is-invalid @enderror"
                                       value="{{ old('room_number') }}"
                                       placeholder="e.g. 101">
                                @error('room_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Assigned Teacher</label>
                                <select name="teacher_id" class="form-select @error('teacher_id') is-invalid @enderror">
                                    <option value="">— No Teacher Assigned —</option>
                                    @foreach($teachers as $teacher)
                                        <option value="{{ $teacher->id }}" {{ old('teacher_id') == $teacher->id ? 'selected' : '' }}>
                                            {{ $teacher->name }}{{ $teacher->subject ? ' ('.$teacher->subject.')' : '' }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('teacher_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Capacity</label>
                                <input type="number" name="capacity"
                                       class="form-control @error('capacity') is-invalid @enderror"
                                       value="{{ old('capacity', 30) }}" min="1" max="1000">
                                @error('capacity')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select @error('status') is-invalid @enderror">
                                    <option value="active"   {{ old('status', 'active') === 'active'   ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="d-flex gap-2 mb-4">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save"></i> Save Class
                    </button>
                    <a href="{{ route('classes.index') }}" class="btn btn-secondary btn-lg">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </form>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-lightbulb"></i> Tips
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0" style="font-size:.875rem;color:#475569;">
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Give the class a clear, descriptive name (e.g. "Grade 10A").</li>
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Assigning a teacher now will link them to this class immediately.</li>
                        <li class="mb-2"><i class="fas fa-check text-success me-2"></i>Capacity can be updated later if the room changes.</li>
                        <li><i class="fas fa-check text-success me-2"></i>Set status to <strong>Inactive</strong> if the class hasn't started yet.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
