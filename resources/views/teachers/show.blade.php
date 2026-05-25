@extends('layouts.app')

@section('title', 'Teacher Details - ' . $teacher->name)

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
    flex-wrap: wrap;
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
.status-on_leave { background: #ffedd5; color: #c2410c; }
.experience-pill {
    background: rgba(255,255,255,.2);
    border-radius: 16px;
    padding: 12px 20px;
    text-align: center;
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255,255,255,.3);
}
.exp-num   { font-size: 2rem; font-weight: 800; color: white; line-height: 1; }
.exp-label { font-size: .68rem; color: rgba(255,255,255,.8); text-transform: uppercase; letter-spacing: .5px; }
</style>
@endsection

@section('content')
<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <a href="{{ route('teachers.index') }}" class="btn btn-secondary btn-sm" style="border-radius:10px; padding:8px 16px;">
        <i class="fas fa-arrow-left"></i> Back to List
    </a>
    <div class="d-flex gap-2">
        <a href="{{ route('teachers.edit', $teacher) }}" class="btn btn-primary" style="border-radius:10px; padding:8px 16px;">
            <i class="fas fa-edit"></i> Edit Teacher
        </a>
        @if(Auth::user()->isAdmin())
        <form method="POST" action="{{ route('teachers.destroy', $teacher) }}" onsubmit="confirmDelete(event, this, 'Delete {{ addslashes($teacher->name) }}?');" class="d-inline">
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
        @if($teacher->profile_picture_url)
            <img src="{{ $teacher->profile_picture_url }}" alt="{{ $teacher->name }}">
        @else
            <div class="profile-avatar-placeholder">{{ strtoupper(substr($teacher->name, 0, 2)) }}</div>
        @endif
    </div>
    <div class="profile-info flex-fill">
        <h1>{{ $teacher->name }}</h1>
        <p>
            @if($teacher->subject) <i class="fas fa-book-open me-1"></i>{{ $teacher->subject }} &nbsp;|&nbsp; @endif
            @if($teacher->department) <i class="fas fa-building me-1"></i>{{ $teacher->department }} &nbsp;|&nbsp; @endif
            <i class="fas fa-id-card me-1"></i>ID: #{{ $teacher->id }}
        </p>
    </div>
    
    @if($teacher->experience_years !== null)
    <div class="experience-pill me-3">
        <div class="exp-num">{{ $teacher->experience_years }}</div>
        <div class="exp-label">Yrs Exp</div>
    </div>
    @endif
    
    <div class="text-end">
        @php
            $statusClass = match($teacher->status) {
                'active' => 'status-active',
                'inactive' => 'status-inactive',
                'on_leave' => 'status-on_leave',
                default => 'bg-secondary'
            };
        @endphp
        <span class="status-badge {{ $statusClass }}">
            <i class="fas fa-{{ $teacher->status == 'active' ? 'check-circle' : ($teacher->status == 'inactive' ? 'times-circle' : 'user-clock') }}"></i>
            {{ ucwords(str_replace('_', ' ', $teacher->status)) }}
        </span>
        <div class="mt-2" style="font-size:0.85rem; opacity:0.8;">
            Joined {{ $teacher->joined_date ? $teacher->joined_date->format('M j, Y') : $teacher->created_at->format('M j, Y') }}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <!-- Personal Information -->
        <div class="info-card">
            <div class="info-card-header">
                <i class="fas fa-user text-primary"></i> Personal Information
            </div>
            <div class="row">
                <div class="col-md-6 info-item">
                    <div class="info-label">Full Name</div>
                    <div class="info-value">{{ $teacher->name }}</div>
                </div>
                <div class="col-md-6 info-item">
                    <div class="info-label">Email Address</div>
                    <div class="info-value"><a href="mailto:{{ $teacher->email }}" style="color:#4f46e5;text-decoration:none;">{{ $teacher->email }}</a></div>
                </div>
                <div class="col-md-6 info-item">
                    <div class="info-label">Phone Number</div>
                    <div class="info-value">{{ $teacher->phone ?? '—' }}</div>
                </div>
                <div class="col-md-6 info-item">
                    <div class="info-label">Date of Birth</div>
                    <div class="info-value">
                        @if($teacher->date_of_birth)
                            {{ $teacher->date_of_birth->format('M j, Y') }} <span class="text-muted">(Age: {{ $teacher->age }})</span>
                        @else
                            —
                        @endif
                    </div>
                </div>
                @if($teacher->address)
                <div class="col-12 info-item mt-2">
                    <div class="info-label">Home Address</div>
                    <div class="info-value">{{ $teacher->address }}</div>
                </div>
                @endif
            </div>
        </div>

        <!-- Professional Information -->
        <div class="info-card">
            <div class="info-card-header">
                <i class="fas fa-briefcase text-primary"></i> Professional Information
            </div>
            <div class="row">
                <div class="col-md-6 info-item">
                    <div class="info-label">Teaching Subject</div>
                    <div class="info-value">
                        @if($teacher->subject)
                            <span style="background:#e0e7ff;color:#a16207;padding:3px 10px;border-radius:20px;font-size:0.85rem;font-weight:600;">{{ $teacher->subject }}</span>
                        @else
                            —
                        @endif
                    </div>
                </div>
                <div class="col-md-6 info-item">
                    <div class="info-label">Department</div>
                    <div class="info-value">{{ $teacher->department ?? '—' }}</div>
                </div>
                <div class="col-md-6 info-item">
                    <div class="info-label">Qualification</div>
                    <div class="info-value">{{ $teacher->qualification ?? '—' }}</div>
                </div>
                <div class="col-md-6 info-item">
                    <div class="info-label">Joined Date</div>
                    <div class="info-value">
                        @if($teacher->joined_date)
                            {{ $teacher->joined_date->format('M j, Y') }}
                        @else
                            —
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar Info -->
    <div class="col-lg-4">
        
        <!-- Record Meta -->
        <div class="info-card" style="background: linear-gradient(180deg, #ffffff, #f8fafc);">
            <div class="info-card-header">
                <i class="fas fa-info-circle text-primary"></i> Record Details
            </div>
            <div class="info-item">
                <div class="info-label">Teacher ID</div>
                <div class="info-value fw-bold">#{{ $teacher->id }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Record Created</div>
                <div class="info-value">{{ $teacher->created_at->format('M j, Y H:i') }}</div>
            </div>
            <div class="info-item mb-0">
                <div class="info-label">Last Updated</div>
                <div class="info-value">{{ $teacher->updated_at->format('M j, Y H:i') }}</div>
            </div>
        </div>
        
        <div class="info-card bg-primary text-white text-center" style="border:none;">
            <div style="width:50px;height:50px;background:rgba(255,255,255,0.2);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 15px;">
                <i class="fas fa-envelope-open-text fs-4"></i>
            </div>
            <h5 class="fw-bold mb-2">Quick Action</h5>
            <p style="font-size:0.85rem;opacity:0.9;margin-bottom:20px;">Need to contact this teacher quickly? Send an email immediately.</p>
            <a href="mailto:{{ $teacher->email }}" class="btn btn-light text-primary w-100 fw-bold" style="border-radius:10px;">
                <i class="fas fa-paper-plane me-1"></i> Send Email
            </a>
        </div>
    </div>
</div>
@endsection
