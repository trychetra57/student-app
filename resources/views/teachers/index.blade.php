@extends('layouts.app')

@section('title', 'Teachers - BelTei University Admin')

@section('content')
<div class="container-lg">
    <div class="page-header">
        <h1 class="page-title"><i class="fas fa-chalkboard-teacher"></i> Teachers</h1>
        <a href="{{ route('teachers.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Teacher
        </a>
    </div>

    {{-- Stats Row --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="stat-mini">
                <div class="stat-mini-icon" style="background:linear-gradient(135deg,#2563eb,#60a5fa)">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <div>
                    <div class="stat-mini-val">{{ $activeCount + $inactiveCount + $onLeaveCount }}</div>
                    <div class="stat-mini-label">Total</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-mini">
                <div class="stat-mini-icon" style="background:linear-gradient(135deg,#16a34a,#4ade80)">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div>
                    <div class="stat-mini-val">{{ $activeCount }}</div>
                    <div class="stat-mini-label">Active</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-mini">
                <div class="stat-mini-icon" style="background:linear-gradient(135deg,#e11d48,#fb7185)">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div>
                    <div class="stat-mini-val">{{ $inactiveCount }}</div>
                    <div class="stat-mini-label">Inactive</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-mini">
                <div class="stat-mini-icon" style="background:linear-gradient(135deg,#d97706,#fbbf24)">
                    <i class="fas fa-user-clock"></i>
                </div>
                <div>
                    <div class="stat-mini-val">{{ $onLeaveCount }}</div>
                    <div class="stat-mini-label">On Leave</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Filter Bar --}}
    <div class="card mb-4">
        <div class="card-body" style="padding:16px 24px;">
            <form method="GET" action="{{ route('teachers.index') }}" class="row g-2 align-items-end">
                <div class="col-12 col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="&#xf002; Search name, email, subject…"
                        style="font-family:'Inter',FontAwesome,sans-serif;"
                        value="{{ request('search') }}">
                </div>
                <div class="col-6 col-md-2">
                    <select name="status" class="form-select">
                        <option value="all" {{ request('status','all')==='all'?'selected':'' }}>All Status</option>
                        <option value="active"   {{ request('status')==='active'  ?'selected':'' }}>Active</option>
                        <option value="inactive" {{ request('status')==='inactive'?'selected':'' }}>Inactive</option>
                        <option value="on_leave" {{ request('status')==='on_leave'?'selected':'' }}>On Leave</option>
                    </select>
                </div>
                <div class="col-6 col-md-2">
                    <select name="department" class="form-select">
                        <option value="">All Departments</option>
                        @foreach($departments as $dept)
                        <option value="{{ $dept }}" {{ request('department')===$dept?'selected':'' }}>{{ $dept }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6 col-md-2">
                    <select name="per_page" class="form-select">
                        @foreach([10,25,50,100] as $n)
                        <option value="{{ $n }}" {{ request('per_page',10)==$n?'selected':'' }}>{{ $n }} / page</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6 col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-primary flex-fill"><i class="fas fa-search"></i> Filter</button>
                    <a href="{{ route('teachers.index') }}" class="btn btn-secondary"><i class="fas fa-times"></i></a>
                </div>
            </form>
        </div>
    </div>

    {{-- Table --}}
    <div class="card">
        <div class="card-body p-0">
            @if($teachers->count())
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>
                                <a href="{{ request()->fullUrlWithQuery(['sort'=>'name','direction'=>request('direction')==='asc'?'desc':'asc']) }}" class="sort-link">
                                    Name <i class="fas fa-sort{{ request('sort')==='name'?(request('direction')==='asc'?'-up':'-down'):'' }}"></i>
                                </a>
                            </th>
                            <th>Contact</th>
                            <th>
                                <a href="{{ request()->fullUrlWithQuery(['sort'=>'subject','direction'=>request('direction')==='asc'?'desc':'asc']) }}" class="sort-link">
                                    Subject <i class="fas fa-sort"></i>
                                </a>
                            </th>
                            <th>
                                <a href="{{ request()->fullUrlWithQuery(['sort'=>'department','direction'=>request('direction')==='asc'?'desc':'asc']) }}" class="sort-link">
                                    Department <i class="fas fa-sort"></i>
                                </a>
                            </th>
                            <th>Status</th>
                            <th>Joined</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($teachers as $teacher)
                        <tr>
                            <td class="text-muted" style="font-size:.75rem;">#{{ $teacher->id }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="teacher-avatar">{{ strtoupper(substr($teacher->name,0,2)) }}</div>
                                    <div>
                                        <div class="fw-600">{{ $teacher->name }}</div>
                                        <div class="text-muted" style="font-size:.75rem;">{{ $teacher->qualification ?? '—' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div style="font-size:.82rem;">{{ $teacher->email }}</div>
                                <div class="text-muted" style="font-size:.75rem;">{{ $teacher->phone ?? '—' }}</div>
                            </td>
                            <td>{{ $teacher->subject ?? '—' }}</td>
                            <td>{{ $teacher->department ?? '—' }}</td>
                            <td>
                                @php
                                    $cls = match($teacher->status) {
                                        'active'   => 'badge-active',
                                        'inactive' => 'badge-inactive',
                                        'on_leave' => 'badge-on-leave',
                                        default    => 'bg-secondary text-white'
                                    };
                                @endphp
                                <span class="badge {{ $cls }}">{{ ucwords(str_replace('_',' ',$teacher->status)) }}</span>
                            </td>
                            <td class="text-muted" style="font-size:.82rem;">
                                {{ $teacher->joined_date ? $teacher->joined_date->format('M j, Y') : '—' }}
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('teachers.show', $teacher) }}" class="btn btn-sm btn-outline-primary" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('teachers.edit', $teacher) }}" class="btn btn-sm btn-outline-secondary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="POST" action="{{ route('teachers.destroy', $teacher) }}"
                                          onsubmit="confirmDelete(event, this, 'Delete teacher {{ addslashes($teacher->name) }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
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

            {{-- Pagination --}}
            @if($teachers->hasPages())
            <div class="d-flex justify-content-between align-items-center px-4 py-3 border-top">
                <small class="text-muted">
                    Showing {{ $teachers->firstItem() }}–{{ $teachers->lastItem() }} of {{ $teachers->total() }} teachers
                </small>
                {{ $teachers->links() }}
            </div>
            @endif

            @else
            <div class="text-center py-5 text-muted">
                <i class="fas fa-chalkboard-teacher fa-3x mb-3 opacity-25"></i>
                <p class="fw-600 mb-1">No teachers found</p>
                <small>Try adjusting your filters or <a href="{{ route('teachers.create') }}">add a teacher</a>.</small>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
.stat-mini {
    background: white;
    border-radius: 16px;
    padding: 16px 20px;
    display: flex;
    align-items: center;
    gap: 14px;
    box-shadow: 0 2px 12px rgba(0,0,0,.06);
}
.stat-mini-icon {
    width: 44px; height: 44px;
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    color: white;
    font-size: 1.1rem;
    flex-shrink: 0;
}
.stat-mini-val  { font-size: 1.4rem; font-weight: 800; color: #1e293b; line-height: 1; }
.stat-mini-label { font-size: .72rem; color: #94a3b8; font-weight: 600; text-transform: uppercase; letter-spacing: .5px; }

.teacher-avatar {
    width: 36px; height: 36px;
    border-radius: 10px;
    background: linear-gradient(135deg, #7c3aed, #a78bfa);
    color: white;
    font-weight: 700;
    font-size: .78rem;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.fw-600 { font-weight: 600; }
.sort-link { color: inherit; text-decoration: none; }
.sort-link:hover { color: var(--primary); }
.badge-on-leave { background: #fef3c7; color: #92400e; }
</style>
@endsection
