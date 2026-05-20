@extends('layouts.app')

@section('title', $teacher->name . ' — Teacher Profile')

@section('content')
<div class="container-lg">

    {{-- Page Header --}}
    <div class="page-header">
        <h1 class="page-title"><i class="fas fa-chalkboard-teacher"></i> Teacher Profile</h1>
        <div class="d-flex gap-2">
            <a href="{{ route('teachers.edit', $teacher) }}" class="btn btn-primary">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('teachers.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>

    <div class="row g-4">

        {{-- LEFT: Profile Card + Details --}}
        <div class="col-lg-8">

            {{-- Hero Card --}}
            <div class="profile-hero card mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-4 flex-wrap">
                        @if($teacher->profile_picture_url)
                            <img src="{{ $teacher->profile_picture_url }}" alt="{{ $teacher->name }}" class="profile-avatar" style="object-fit:cover;">
                        @else
                            <div class="profile-avatar">
                                {{ strtoupper(substr($teacher->name, 0, 2)) }}
                            </div>
                        @endif
                        <div class="flex-fill">
                            <h2 class="profile-name mb-1">{{ $teacher->name }}</h2>
                            <div class="profile-sub mb-2">
                                @if($teacher->subject)
                                    <span><i class="fas fa-book-open me-1"></i>{{ $teacher->subject }}</span>
                                @endif
                                @if($teacher->department)
                                    &nbsp;·&nbsp;
                                    <span><i class="fas fa-building me-1"></i>{{ $teacher->department }}</span>
                                @endif
                            </div>
                            @php
                                $cls = match($teacher->status) {
                                    'active'   => 'badge-active',
                                    'inactive' => 'badge-inactive',
                                    'on_leave' => 'badge-on-leave',
                                    default    => 'bg-secondary text-white'
                                };
                            @endphp
                            <span class="badge {{ $cls }} px-3 py-2" style="font-size:.8rem">
                                <i class="fas fa-circle me-1" style="font-size:.5rem;vertical-align:middle;"></i>
                                {{ ucwords(str_replace('_', ' ', $teacher->status)) }}
                            </span>
                        </div>
                        @if($teacher->experience_years !== null)
                        <div class="experience-pill">
                            <div class="exp-num">{{ $teacher->experience_years }}</div>
                            <div class="exp-label">Yrs Experience</div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Personal Information --}}
            <div class="card mb-4">
                <div class="card-header"><i class="fas fa-user"></i> Personal Information</div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="info-item">
                                <div class="info-label"><i class="fas fa-envelope"></i> Email</div>
                                <div class="info-val"><a href="mailto:{{ $teacher->email }}">{{ $teacher->email }}</a></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <div class="info-label"><i class="fas fa-phone"></i> Phone</div>
                                <div class="info-val">{{ $teacher->phone ?? '—' }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <div class="info-label"><i class="fas fa-birthday-cake"></i> Date of Birth</div>
                                <div class="info-val">
                                    @if($teacher->date_of_birth)
                                        {{ $teacher->date_of_birth->format('M j, Y') }}
                                        <span class="text-muted">(Age {{ $teacher->age }})</span>
                                    @else
                                        —
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <div class="info-label"><i class="fas fa-graduation-cap"></i> Qualification</div>
                                <div class="info-val">{{ $teacher->qualification ?? '—' }}</div>
                            </div>
                        </div>
                        @if($teacher->address)
                        <div class="col-12">
                            <div class="info-item">
                                <div class="info-label"><i class="fas fa-map-marker-alt"></i> Address</div>
                                <div class="info-val">{{ $teacher->address }}</div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Teaching Information --}}
            <div class="card mb-4">
                <div class="card-header"><i class="fas fa-chalkboard"></i> Teaching Details</div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="info-item">
                                <div class="info-label"><i class="fas fa-book-open"></i> Subject</div>
                                <div class="info-val">{{ $teacher->subject ?? '—' }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <div class="info-label"><i class="fas fa-building"></i> Department</div>
                                <div class="info-val">{{ $teacher->department ?? '—' }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <div class="info-label"><i class="fas fa-calendar-check"></i> Joined Date</div>
                                <div class="info-val">
                                    @if($teacher->joined_date)
                                        {{ $teacher->joined_date->format('M j, Y') }}
                                    @else
                                        —
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <div class="info-label"><i class="fas fa-clock"></i> Experience</div>
                                <div class="info-val">
                                    {{ $teacher->experience_years !== null ? $teacher->experience_years . ' year(s)' : '—' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- RIGHT: Quick Actions & Meta --}}
        <div class="col-lg-4">

            {{-- Quick Actions --}}
            <div class="card mb-4">
                <div class="card-header"><i class="fas fa-bolt"></i> Quick Actions</div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('teachers.edit', $teacher) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Edit Teacher
                        </a>
                        <a href="mailto:{{ $teacher->email }}" class="btn btn-secondary">
                            <i class="fas fa-envelope"></i> Send Email
                        </a>
                        <form method="POST" action="{{ route('teachers.destroy', $teacher) }}"
                              onsubmit="confirmDelete(event, this, 'Delete teacher {{ addslashes($teacher->name) }}?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="fas fa-trash"></i> Delete Teacher
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Meta Info --}}
            <div class="card mb-4">
                <div class="card-header"><i class="fas fa-info-circle"></i> Record Info</div>
                <div class="card-body">
                    <div class="meta-row">
                        <span class="meta-key">Teacher ID</span>
                        <span class="meta-val">#{{ $teacher->id }}</span>
                    </div>
                    <div class="meta-row">
                        <span class="meta-key">Created</span>
                        <span class="meta-val">{{ $teacher->created_at->format('M j, Y') }}</span>
                    </div>
                    <div class="meta-row">
                        <span class="meta-key">Last Updated</span>
                        <span class="meta-val">{{ $teacher->updated_at->format('M j, Y') }}</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
/* Hero */
.profile-hero { background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 100%); border: none; }
.profile-hero .card-body { padding: 32px; }
.profile-avatar {
    width: 80px; height: 80px;
    border-radius: 20px;
    background: linear-gradient(135deg, #7c3aed, #a78bfa);
    color: white;
    font-weight: 800;
    font-size: 1.6rem;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    box-shadow: 0 8px 24px rgba(124,58,237,.4);
}
.profile-name { font-size: 1.5rem; font-weight: 800; color: white; }
.profile-sub   { color: rgba(255,255,255,.6); font-size: .875rem; }
.experience-pill {
    background: rgba(255,255,255,.1);
    border-radius: 16px;
    padding: 16px 20px;
    text-align: center;
    backdrop-filter: blur(8px);
    border: 1px solid rgba(255,255,255,.15);
}
.exp-num   { font-size: 2rem; font-weight: 800; color: #60a5fa; line-height: 1; }
.exp-label { font-size: .68rem; color: rgba(255,255,255,.5); text-transform: uppercase; letter-spacing: .5px; }

/* Info items */
.info-item { padding: 12px 16px; background: #f8fafc; border-radius: 12px; }
.info-label { font-size: .72rem; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; color: #94a3b8; margin-bottom: 4px; }
.info-label i { margin-right: 5px; color: var(--primary); }
.info-val   { font-size: .9rem; font-weight: 600; color: #1e293b; }
.info-val a { color: var(--primary); text-decoration: none; }
.info-val a:hover { text-decoration: underline; }

/* Meta */
.meta-row { display: flex; justify-content: space-between; align-items: center; padding: 10px 0; border-bottom: 1px solid var(--border); }
.meta-row:last-child { border-bottom: none; }
.meta-key { font-size: .78rem; font-weight: 600; color: #94a3b8; }
.meta-val { font-size: .82rem; font-weight: 700; color: #1e293b; }

.badge-on-leave { background: #fef3c7; color: #92400e; }
</style>
@endsection
