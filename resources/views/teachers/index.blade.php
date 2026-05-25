@extends('layouts.app')
@section('title', 'Teachers — Student Management')
@section('styles')
<style>
.filter-card{background:white;border-radius:16px;box-shadow:0 2px 12px rgba(0,0,0,.06);padding:20px 24px;margin-bottom:24px;}
.tbl-card{background:white;border-radius:16px;box-shadow:0 2px 12px rgba(0,0,0,.06);overflow:hidden;}
.teacher-avatar{width:36px;height:36px;border-radius:10px;background:linear-gradient(135deg,#4f46e5,#818cf8);display:flex;align-items:center;justify-content:center;font-weight:700;color:white;font-size:.78rem;flex-shrink:0;}
.sort-link{text-decoration:none;color:inherit;display:inline-flex;align-items:center;gap:4px;font-weight:700;font-size:.75rem;}
.sort-link:hover{color:#4f46e5;}
.bulk-bar{background:#312e81;border-radius:12px;padding:12px 20px;align-items:center;gap:12px;flex-wrap:wrap;margin-bottom:16px;display:none;}
.bulk-bar.visible{display:flex;}
.stat-pill{display:inline-flex;align-items:center;gap:6px;padding:5px 14px;border-radius:20px;font-size:.78rem;font-weight:600;}
.pill-total{background:#e0e7ff;color:#4338ca;}
.pill-active{background:#dcfce7;color:#15803d;}
.pill-inactive{background:#ffe4e6;color:#be123c;}
.pill-on-leave{background:#ffedd5;color:#c2410c;}
</style>
@endsection
@section('content')
<div class="page-header">
    <h1 class="page-title"><i class="fas fa-chalkboard-teacher"></i> Teachers</h1>
    <div class="d-flex gap-2 flex-wrap">
        <a href="{{ route('teachers.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add Teacher</a>
        {{-- <a href="#" class="btn btn-secondary"><i class="fas fa-download"></i> Export CSV</a> --}}
    </div>
</div>

<div class="d-flex gap-2 flex-wrap mb-4">
    <span class="stat-pill pill-total"><i class="fas fa-chalkboard-teacher"></i> {{ $teachers->total() }} Total</span>
    <span class="stat-pill pill-active"><i class="fas fa-check-circle"></i> {{ $activeCount }} Active</span>
    <span class="stat-pill pill-inactive"><i class="fas fa-times-circle"></i> {{ $inactiveCount }} Inactive</span>
    <span class="stat-pill pill-on-leave"><i class="fas fa-user-clock"></i> {{ $onLeaveCount }} On Leave</span>
</div>

<div class="filter-card">
    <form method="GET" action="{{ route('teachers.index') }}">
        <div class="row g-3 align-items-end">
            <div class="col-12 col-sm-6 col-lg-4">
                <label class="form-label">Search</label>
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Name, email, subject…" class="form-control border-start-0 ps-0">
                </div>
            </div>
            <div class="col-6 col-sm-3 col-lg-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="all" {{ request('status','all')=='all'?'selected':'' }}>All Status</option>
                    <option value="active"    {{ request('status')=='active'   ?'selected':'' }}>Active</option>
                    <option value="inactive"  {{ request('status')=='inactive' ?'selected':'' }}>Inactive</option>
                    <option value="on_leave"  {{ request('status')=='on_leave' ?'selected':'' }}>On Leave</option>
                </select>
            </div>
            <div class="col-6 col-sm-3 col-lg-3">
                <label class="form-label">Department</label>
                <select name="department" class="form-select">
                    <option value="">All Departments</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept }}" {{ request('department')==$dept?'selected':'' }}>{{ $dept }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-6 col-sm-3 col-lg-2">
                <label class="form-label">Per page</label>
                <select name="per_page" class="form-select" onchange="this.form.submit()">
                    @foreach([10,25,50] as $n)
                        <option value="{{ $n }}" {{ request('per_page',10)==$n?'selected':'' }}>{{ $n }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="d-flex gap-2 mt-3">
            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Search</button>
            <a href="{{ route('teachers.index') }}" class="btn btn-secondary"><i class="fas fa-times"></i> Clear</a>
        </div>
    </form>
</div>

<div class="tbl-card">
    <div class="d-flex align-items-center justify-content-between px-4 py-3 border-bottom">
        <span style="font-size:.82rem;color:#64748b;font-weight:600;">Teachers List</span>
        <span style="font-size:.82rem;color:#94a3b8;">
            {{ $teachers->firstItem()??0 }}–{{ $teachers->lastItem()??0 }} of {{ $teachers->total() }}
        </span>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th><a class="sort-link" href="?{{ http_build_query(array_merge(request()->query(),['sort'=>'name','direction'=>request('sort')=='name'&&request('direction')=='asc'?'desc':'asc'])) }}">Teacher <i class="fas fa-sort{{ request('sort')=='name'?(request('direction')=='asc'?'-up':'-down'):'' }} text-muted"></i></a></th>
                    <th><a class="sort-link" href="?{{ http_build_query(array_merge(request()->query(),['sort'=>'email','direction'=>request('sort')=='email'&&request('direction')=='asc'?'desc':'asc'])) }}">Email <i class="fas fa-sort{{ request('sort')=='email'?(request('direction')=='asc'?'-up':'-down'):'' }} text-muted"></i></a></th>
                    <th class="d-none d-md-table-cell">Phone</th>
                    <th class="d-none d-lg-table-cell"><a class="sort-link" href="?{{ http_build_query(array_merge(request()->query(),['sort'=>'subject','direction'=>request('sort')=='subject'&&request('direction')=='asc'?'desc':'asc'])) }}">Subject <i class="fas fa-sort{{ request('sort')=='subject'?(request('direction')=='asc'?'-up':'-down'):'' }} text-muted"></i></a></th>
                    <th class="d-none d-lg-table-cell"><a class="sort-link" href="?{{ http_build_query(array_merge(request()->query(),['sort'=>'department','direction'=>request('sort')=='department'&&request('direction')=='asc'?'desc':'asc'])) }}">Department <i class="fas fa-sort{{ request('sort')=='department'?(request('direction')=='asc'?'-up':'-down'):'' }} text-muted"></i></a></th>
                    <th><a class="sort-link" href="?{{ http_build_query(array_merge(request()->query(),['sort'=>'status','direction'=>request('sort')=='status'&&request('direction')=='asc'?'desc':'asc'])) }}">Status <i class="fas fa-sort{{ request('sort')=='status'?(request('direction')=='asc'?'-up':'-down'):'' }} text-muted"></i></a></th>
                    <th width="120">Actions</th>
                </tr>
            </thead>
            <tbody>
            @forelse($teachers as $teacher)
            <tr>
                <td>
                    <div class="d-flex align-items-center gap-3">
                        @if($teacher->profile_picture_url)
                            <img src="{{ $teacher->profile_picture_url }}" alt="{{ $teacher->name }}" class="teacher-avatar" style="object-fit:cover;">
                        @else
                            <div class="teacher-avatar">{{ strtoupper(substr($teacher->name,0,2)) }}</div>
                        @endif
                        <div>
                            <div style="font-weight:600;">{{ $teacher->name }}</div>
                            <div class="d-lg-none" style="font-size:.75rem;color:#94a3b8;">{{ $teacher->subject??'—' }}</div>
                        </div>
                    </div>
                </td>
                <td style="color:#64748b;">{{ $teacher->email }}</td>
                <td class="d-none d-md-table-cell" style="color:#64748b;">{{ $teacher->phone??'—' }}</td>
                <td class="d-none d-lg-table-cell">
                    @if($teacher->subject)
                        <span style="background:#f1f5f9;color:#475569;padding:3px 10px;border-radius:20px;font-size:.75rem;font-weight:600;">{{ $teacher->subject }}</span>
                    @else <span style="color:#cbd5e1;">—</span> @endif
                </td>
                <td class="d-none d-lg-table-cell">{{ $teacher->department??'—' }}</td>
                <td>
                    <span class="badge {{ $teacher->status=='active'?'pill-active':($teacher->status=='inactive'?'pill-inactive':'pill-on-leave') }}">
                        <i class="fas fa-{{ $teacher->status=='active'?'check-circle':($teacher->status=='inactive'?'times-circle':'user-clock') }}"></i>
                        {{ ucwords(str_replace('_',' ',$teacher->status)) }}
                    </span>
                </td>
                <td>
                    <div class="d-flex gap-1">
                        <a href="{{ route('teachers.show',$teacher) }}" class="btn btn-sm btn-outline-primary" title="View"><i class="fas fa-eye"></i></a>
                        <a href="{{ route('teachers.edit',$teacher) }}" class="btn btn-sm btn-outline-primary" title="Edit"><i class="fas fa-edit"></i></a>
                        @if(Auth::user()->isAdmin())
                        <form method="POST" action="{{ route('teachers.destroy',$teacher) }}" class="d-inline" onsubmit="confirmDelete(event,this,'Delete {{ addslashes($teacher->name) }}?');">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" title="Delete"><i class="fas fa-trash"></i></button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="7">
                <div class="text-center py-5" style="color:#94a3b8;">
                    <i class="fas fa-chalkboard-teacher fa-3x mb-3" style="opacity:.3;"></i>
                    <p class="mb-0" style="font-weight:600;">No teachers found</p>
                    <a href="{{ route('teachers.create') }}" class="btn btn-primary mt-3"><i class="fas fa-plus"></i> Add First Teacher</a>
                </div>
            </td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($teachers->hasPages())
    <div class="px-4 py-3 border-top d-flex justify-content-center">
        {{ $teachers->appends(request()->query())->links('pagination::bootstrap-5') }}
    </div>
    @endif
</div>
@endsection
