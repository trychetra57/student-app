@extends('layouts.app')

@section('title', 'Edit Class - LEARN Academy Admin')

@section('content')
<div class="container-lg">
    <div class="page-header">
        <h1 class="page-title"><i class="fas fa-edit"></i> Edit Class</h1>
        <a href="{{ route('classes.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <form action="{{ route('classes.update', $schoolClass) }}" method="POST" novalidate>
                @csrf
                @method('PUT')

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
                                       value="{{ old('name', $schoolClass->name) }}" required>
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Room Number</label>
                                <input type="text" name="room_number"
                                       class="form-control @error('room_number') is-invalid @enderror"
                                       value="{{ old('room_number', $schoolClass->room_number) }}">
                                @error('room_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Assigned Teacher</label>
                                <select name="teacher_id" class="form-select @error('teacher_id') is-invalid @enderror">
                                    <option value="">— No Teacher Assigned —</option>
                                    @foreach($teachers as $teacher)
                                        <option value="{{ $teacher->id }}" {{ old('teacher_id', $schoolClass->teacher_id) == $teacher->id ? 'selected' : '' }}>
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
                                       value="{{ old('capacity', $schoolClass->capacity) }}" min="1" max="1000">
                                @error('capacity')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select @error('status') is-invalid @enderror">
                                    <option value="active"   {{ old('status', $schoolClass->status) === 'active'   ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status', $schoolClass->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="d-flex gap-2 mb-4">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save"></i> Update Class
                    </button>
                    <a href="{{ route('classes.index') }}" class="btn btn-secondary btn-lg">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </form>

            @if(Auth::user()->isAdmin())
            <div class="card border-danger mt-2">
                <div class="card-header bg-danger text-white">
                    <i class="fas fa-exclamation-triangle"></i> Danger Zone
                </div>
                <div class="card-body">
                    <p class="mb-3" style="font-size:.875rem;">Deleting this class will remove it permanently. This action cannot be undone.</p>
                    <form method="POST" action="{{ route('classes.destroy', $schoolClass) }}"
                          onsubmit="confirmDelete(event, this, 'Are you sure you want to delete this class?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger">
                            <i class="fas fa-trash-alt"></i> Delete Class
                        </button>
                    </form>
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar Info -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-info-circle"></i> Record Info
                </div>
                <div class="card-body" style="font-size:.875rem;">
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted fw-bold">Class ID</span>
                        <span class="fw-bold">#{{ $schoolClass->id }}</span>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted fw-bold">Created</span>
                        <span>{{ $schoolClass->created_at->format('M j, Y') }}</span>
                    </div>
                    <div class="d-flex justify-content-between py-2">
                        <span class="text-muted fw-bold">Last Updated</span>
                        <span>{{ $schoolClass->updated_at->format('M j, Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
