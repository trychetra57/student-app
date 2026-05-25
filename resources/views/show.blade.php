@extends('layouts.app')

@section('title', 'Student Details - Student Management')

@section('styles')
<style>
.profile-header {
    background: linear-gradient(135deg, #312e81, #6366f1);
    border-radius: 16px;
    padding: 30px;
    color: white;
    margin-bottom: 24px;
    box-shadow: 0 4px 15px rgba(79, 70, 229, 0.2);
    display: flex;
    align-items: center;
    gap: 20px;
}
.profile-avatar {
    width: 100px;
    height: 100px;
    border-radius: 20px;
    background: white;
    padding: 3px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}
.profile-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 17px;
}
.profile-avatar-placeholder {
    width: 100%;
    height: 100%;
    border-radius: 17px;
    background: linear-gradient(135deg, #4f46e5, #818cf8);
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    color: white;
    font-size: 2.5rem;
}
.profile-info h1 {
    font-size: 1.8rem;
    font-weight: 700;
    margin: 0 0 5px 0;
}
.profile-info p {
    margin: 0;
    opacity: 0.9;
    font-size: 0.95rem;
}
.info-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.06);
    padding: 24px;
    margin-bottom: 24px;
    transition: transform 0.2s, box-shadow 0.2s;
}
.info-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(0,0,0,0.08);
}
.info-card-header {
    font-size: 1.1rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
    border-bottom: 2px solid #f1f5f9;
    padding-bottom: 12px;
}
.info-item {
    margin-bottom: 16px;
}
.info-label {
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #64748b;
    font-weight: 700;
    margin-bottom: 4px;
}
.info-value {
    font-size: 0.95rem;
    color: #0f172a;
    font-weight: 500;
}
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 600;
}
.status-active { background: #dcfce7; color: #15803d; }
.status-inactive { background: #ffe4e6; color: #be123c; }
.status-graduated { background: #ede9fe; color: #5b21b6; }
.doc-table {
    border-collapse: separate;
    border-spacing: 0;
    width: 100%;
}
.doc-table th {
    background: #f8fafc;
    color: #64748b;
    font-weight: 600;
    font-size: 0.8rem;
    text-transform: uppercase;
    padding: 12px 16px;
    border-bottom: 2px solid #e2e8f0;
}
.doc-table td {
    padding: 16px;
    border-bottom: 1px solid #f1f5f9;
    vertical-align: middle;
    font-size: 0.9rem;
}
.doc-table tr:hover td { background: #f8fafc; }
</style>
@endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <a href="{{ route('students.index') }}" class="btn btn-secondary btn-sm" style="border-radius:10px; padding:8px 16px;">
        <i class="fas fa-arrow-left"></i> Back to List
    </a>
    <div class="d-flex gap-2">
        <a href="{{ route('students.edit', $student) }}" class="btn btn-primary" style="border-radius:10px; padding:8px 16px;">
            <i class="fas fa-edit"></i> Edit Student
        </a>
        @if(Auth::user()->isAdmin())
        <form method="POST" action="{{ route('students.destroy', $student) }}" onsubmit="confirmDelete(event, this, 'Delete {{ addslashes($student->name) }}?');" class="d-inline">
            @csrf @method('DELETE')
            <button class="btn btn-danger" style="border-radius:10px; padding:8px 16px;">
                <i class="fas fa-trash"></i> Delete
            </button>
        </form>
        @endif
    </div>
</div>

<div class="profile-header">
    <div class="profile-avatar">
        @if($student->profile_picture_url)
            <img src="{{ $student->profile_picture_url }}" alt="{{ $student->name }}">
        @else
            <div class="profile-avatar-placeholder">{{ strtoupper(substr($student->name, 0, 2)) }}</div>
        @endif
    </div>
    <div class="profile-info">
        <h1>{{ $student->name }}</h1>
        <p><i class="fas fa-envelope me-2"></i>{{ $student->email }} &nbsp;|&nbsp; <i class="fas fa-id-card me-2"></i>ID: #{{ $student->id }}</p>
    </div>
    <div class="ms-auto text-end">
        @php
            $statusClass = match($student->status) {
                'active' => 'status-active',
                'inactive' => 'status-inactive',
                'graduated' => 'status-graduated',
                default => 'bg-secondary'
            };
        @endphp
        <span class="status-badge {{ $statusClass }}">
            <i class="fas fa-{{ $student->status == 'active' ? 'check-circle' : ($student->status == 'inactive' ? 'times-circle' : 'graduation-cap') }}"></i>
            {{ ucfirst($student->status) }}
        </span>
        <div class="mt-2" style="font-size:0.85rem; opacity:0.8;">
            Joined {{ $student->created_at->format('M j, Y') }}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <!-- Basic Information -->
        <div class="info-card">
            <div class="info-card-header">
                <i class="fas fa-user text-primary"></i> Basic Information
            </div>
            <div class="row">
                <div class="col-md-6 info-item">
                    <div class="info-label">Full Name</div>
                    <div class="info-value">{{ $student->name }}</div>
                </div>
                <div class="col-md-6 info-item">
                    <div class="info-label">Email Address</div>
                    <div class="info-value"><a href="mailto:{{ $student->email }}" style="color:#4f46e5;text-decoration:none;">{{ $student->email }}</a></div>
                </div>
                <div class="col-md-6 info-item">
                    <div class="info-label">Phone Number</div>
                    <div class="info-value">{{ $student->phone ?? '—' }}</div>
                </div>
                <div class="col-md-6 info-item">
                    <div class="info-label">Grade / Class</div>
                    <div class="info-value">
                        @if($student->grade)
                            <span style="background:#f1f5f9;color:#475569;padding:3px 10px;border-radius:20px;font-size:0.85rem;font-weight:600;">{{ $student->grade }}</span>
                        @else
                            —
                        @endif
                    </div>
                </div>
                <div class="col-md-6 info-item">
                    <div class="info-label">Date of Birth</div>
                    <div class="info-value">
                        @if($student->date_of_birth)
                            {{ $student->date_of_birth->format('M j, Y') }} <span class="text-muted">(Age: {{ $student->age }})</span>
                        @else
                            —
                        @endif
                    </div>
                </div>
                <div class="col-md-6 info-item">
                    <div class="info-label">Last Updated</div>
                    <div class="info-value">{{ $student->updated_at->format('M j, Y H:i') }}</div>
                </div>
                @if($student->address)
                <div class="col-12 info-item mt-2">
                    <div class="info-label">Home Address</div>
                    <div class="info-value">{{ $student->address }}</div>
                </div>
                @endif
            </div>
        </div>

        <!-- Documents Section -->
        <div class="info-card">
            <div class="info-card-header">
                <i class="fas fa-file-alt text-primary"></i> Documents & Files
            </div>
            
            <form method="POST" action="{{ route('students.documents.upload', $student) }}" enctype="multipart/form-data" class="mb-4 bg-light p-3 rounded-3 border">
                @csrf
                <div class="row g-2 align-items-center">
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="type" placeholder="Doc type (e.g. ID, Certificate)" required>
                    </div>
                    <div class="col-md-5">
                        <input type="file" class="form-control" name="document" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" required>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary w-100 fw-bold">
                            <i class="fas fa-cloud-upload-alt"></i> Upload
                        </button>
                    </div>
                </div>
            </form>

            @if($student->documents->count() > 0)
                <div class="table-responsive" style="border-radius:12px; border:1px solid #f1f5f9;">
                    <table class="doc-table">
                        <thead>
                            <tr>
                                <th>File Name</th>
                                <th>Type</th>
                                <th>Uploaded</th>
                                <th width="100" class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($student->documents as $document)
                            <tr>
                                <td class="fw-bold" style="color:#334155;">{{ $document->file_name }}</td>
                                <td>
                                    <span style="background:#e0e7ff;color:#4338ca;padding:4px 10px;border-radius:12px;font-size:0.75rem;font-weight:700;text-transform:uppercase;">
                                        {{ $document->document_type }}
                                    </span>
                                </td>
                                <td style="color:#64748b;font-size:0.85rem;">{{ $document->created_at->format('M j, Y') }}</td>
                                <td class="text-end">
                                    <div class="d-flex justify-content-end gap-1">
                                        <a href="{{ route('documents.download', $document) }}" class="btn btn-sm btn-light text-primary border" title="Download">
                                            <i class="fas fa-download"></i>
                                        </a>
                                        <form method="POST" action="{{ route('documents.delete', $document) }}" class="d-inline" onsubmit="confirmDelete(event, this, 'Delete this document?');">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-light text-danger border" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5 rounded-3 bg-light border border-dashed">
                    <div style="width:60px;height:60px;background:#e2e8f0;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 15px;">
                        <i class="fas fa-folder-open text-muted fs-3"></i>
                    </div>
                    <h5 style="color:#475569;font-weight:700;">No Documents</h5>
                    <p style="color:#94a3b8;margin-bottom:0;font-size:0.9rem;">Upload files for this student above.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Sidebar Info -->
    <div class="col-lg-4">
        @if($student->guardian_name || $student->guardian_phone)
        <div class="info-card" style="background: linear-gradient(180deg, #ffffff, #f8fafc);">
            <div class="info-card-header">
                <i class="fas fa-users text-primary"></i> Guardian Information
            </div>
            @if($student->guardian_name)
            <div class="info-item">
                <div class="info-label">Guardian Name</div>
                <div class="info-value fw-bold">{{ $student->guardian_name }}</div>
            </div>
            @endif
            @if($student->guardian_phone)
            <div class="info-item mb-0">
                <div class="info-label">Contact Phone</div>
                <div class="info-value">
                    <a href="tel:{{ $student->guardian_phone }}" class="btn btn-sm btn-outline-primary mt-1 rounded-pill px-3 fw-bold">
                        <i class="fas fa-phone-alt me-1"></i> {{ $student->guardian_phone }}
                    </a>
                </div>
            </div>
            @endif
        </div>
        @endif
        
        <div class="info-card bg-primary text-white text-center" style="border:none;">
            <div style="width:50px;height:50px;background:rgba(255,255,255,0.2);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 15px;">
                <i class="fas fa-shield-alt fs-4"></i>
            </div>
            <h5 class="fw-bold mb-2">Security & Audit</h5>
            <p style="font-size:0.85rem;opacity:0.9;margin-bottom:20px;">Review all changes and actions taken on this student record.</p>
            <a href="{{ route('audit.index') }}?search={{ $student->email }}" class="btn btn-light text-primary w-100 fw-bold" style="border-radius:10px;">
                View Audit Logs
            </a>
        </div>
    </div>
</div>
@endsection
