@extends('layouts.app')

@section('title', 'Student Details - Student Management')

@section('content')
<div class="container-lg">
    <div class="page-header">
        <h1 class="page-title"><i class="fas fa-user-circle"></i> Student Details</h1>
        <div class="d-flex gap-2">
            <a href="{{ route('students.edit', $student) }}" class="btn btn-primary">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('students.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Basic Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-user"></i> Basic Information
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <small class="text-muted">Name</small>
                            <p class="fw-bold">{{ $student->name }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <small class="text-muted">Email</small>
                            <p class="fw-bold"><a href="mailto:{{ $student->email }}">{{ $student->email }}</a></p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <small class="text-muted">Phone</small>
                            <p class="fw-bold">{{ $student->phone ?? '-' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <small class="text-muted">Grade/Class</small>
                            <p class="fw-bold">{{ $student->grade ?? '-' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <small class="text-muted">Date of Birth</small>
                            <p class="fw-bold">
                                @if($student->date_of_birth)
                                    {{ $student->date_of_birth->format('M j, Y') }} (Age: {{ $student->age }})
                                @else
                                    -
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <small class="text-muted">Status</small>
                            <p>
                                @php
                                    $statusClass = match($student->status) {
                                        'active' => 'badge-active',
                                        'inactive' => 'badge-inactive',
                                        'graduated' => 'badge-graduated',
                                        default => 'bg-secondary'
                                    };
                                @endphp
                                <span class="badge {{ $statusClass }}">
                                    <i class="fas fa-{{ $student->status == 'active' ? 'check-circle' : ($student->status == 'inactive' ? 'times-circle' : 'graduation-cap') }}"></i>
                                    {{ ucfirst($student->status) }}
                                </span>
                            </p>
                        </div>
                    </div>
                    @if($student->address)
                        <div class="mt-3 pt-3 border-top">
                            <small class="text-muted">Address</small>
                            <p class="fw-bold">{{ $student->address }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Guardian Information -->
            @if($student->guardian_name || $student->guardian_phone)
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-users"></i> Guardian Information
                </div>
                <div class="card-body">
                    <div class="row">
                        @if($student->guardian_name)
                        <div class="col-md-6 mb-3">
                            <small class="text-muted">Guardian Name</small>
                            <p class="fw-bold">{{ $student->guardian_name }}</p>
                        </div>
                        @endif
                        @if($student->guardian_phone)
                        <div class="col-md-6 mb-3">
                            <small class="text-muted">Guardian Phone</small>
                            <p class="fw-bold"><a href="tel:{{ $student->guardian_phone }}">{{ $student->guardian_phone }}</a></p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif

            <!-- Documents Section -->
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-file-alt"></i> Documents
                </div>
                <div class="card-body">
                    <!-- Upload Document Form -->
                    <form method="POST" action="{{ route('students.documents.upload', $student) }}" enctype="multipart/form-data" class="mb-4">
                        @csrf
                        <div class="row g-3">
                            <div class="col-12 col-md-4">
                                <input type="text" class="form-control" name="type" placeholder="Document type (e.g. ID, Certificate)" required>
                            </div>
                            <div class="col-12 col-md-5">
                                <input type="file" class="form-control" name="document" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" required>
                            </div>
                            <div class="col-12 col-md-3">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-upload"></i> Upload
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Documents List -->
                    @if($student->documents->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>File Name</th>
                                        <th>Document Type</th>
                                        <th>Uploaded</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($student->documents as $document)
                                    <tr>
                                        <td>{{ $document->file_name }}</td>
                                        <td>{{ $document->document_type }}</td>
                                        <td>
                                            @if(str_contains($document->file_type, 'pdf'))
                                                <i class="fas fa-file-pdf text-danger"></i> PDF
                                            @elseif(str_contains($document->file_type, 'word') || str_contains($document->file_type, 'document'))
                                                <i class="fas fa-file-word text-primary"></i> Word
                                            @elseif(str_contains($document->file_type, 'image'))
                                                <i class="fas fa-file-image text-success"></i> Image
                                            @else
                                                <i class="fas fa-file text-secondary"></i> File
                                            @endif
                                        </td>
                                        <td>{{ $document->created_at->format('M j, Y') }}</td>
                                        <td>
                                            <a href="{{ route('documents.download', $document) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-download"></i>
                                            </a>
                                            <form method="POST" action="{{ route('documents.delete', $document) }}" class="d-inline" onsubmit="confirmDelete(event, this, 'Delete this document?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-file-alt fa-3x mb-3"></i>
                            <p>No documents uploaded yet</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-info-circle"></i> Quick Info
                </div>
                <div class="card-body">
                    <p><strong>Student ID:</strong> #{{ $student->id }}</p>
                    <hr>
                    <div class="d-grid gap-2">
                        <a href="{{ route('students.edit', $student) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-edit"></i> Edit Student
                        </a>
                        <form method="POST" action="{{ route('students.destroy', $student) }}" onsubmit="confirmDelete(event, this, 'Delete this student?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger w-100">
                                <i class="fas fa-trash"></i> Delete Student
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
