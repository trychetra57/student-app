@extends('layouts.app')

@section('title', 'Classes - LEARN Academy Admin')

@section('styles')
<style>
.stat-mini {
    background: white;
    border-radius: 16px;
    padding: 18px 20px;
    display: flex;
    align-items: center;
    gap: 14px;
    box-shadow: 0 2px 12px rgba(0,0,0,.06);
    transition: transform 0.2s, box-shadow 0.2s;
}
.stat-mini:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(79,70,229,.1);
}
.stat-mini-icon {
    width: 48px; height: 48px;
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    color: white;
    font-size: 1.15rem;
    flex-shrink: 0;
}
.stat-mini-val   { font-size: 1.5rem; font-weight: 800; color: #1e293b; line-height: 1; }
.stat-mini-label { font-size: .72rem; color: #94a3b8; font-weight: 600; text-transform: uppercase; letter-spacing: .5px; margin-top: 2px; }

.sort-link { color: inherit; text-decoration: none; }
.sort-link:hover { color: var(--primary); }

.class-avatar {
    width: 38px; height: 38px;
    border-radius: 10px;
    background: linear-gradient(135deg, #4f46e5, #818cf8);
    color: white;
    font-weight: 700;
    font-size: .85rem;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}

.table > :not(caption) > * > * { padding: 14px 16px; vertical-align: middle; }
.table thead th { background: #f8fafc; font-size: .72rem; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; color: #64748b; border-bottom: 2px solid #e2e8f0; }
</style>
@endsection

@section('content')
<div class="container-lg">
    <div class="page-header">
        <h1 class="page-title"><i class="fas fa-door-open"></i> Classes</h1>
        <a href="{{ route('classes.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Class
        </a>
    </div>

    {{-- Stats Row --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-4">
            <div class="stat-mini">
                <div class="stat-mini-icon" style="background:linear-gradient(135deg,#4f46e5,#818cf8)">
                    <i class="fas fa-door-open"></i>
                </div>
                <div>
                    <div class="stat-mini-val">{{ $activeCount + $inactiveCount }}</div>
                    <div class="stat-mini-label">Total Classes</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-4">
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
        <div class="col-12 col-md-4">
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
    </div>

    {{-- Filter Bar --}}
    <div class="card mb-4">
        <div class="card-body" style="padding:16px 24px;">
            <form method="GET" action="{{ route('classes.index') }}" class="row g-2 align-items-end">
                <div class="col-12 col-md-6">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                        <input type="text" name="search" class="form-control border-start-0"
                               placeholder="Search class name or room number…"
                               value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-6 col-md-2">
                    <select name="status" class="form-select">
                        <option value="all"     {{ request('status','all')==='all'    ?'selected':'' }}>All Status</option>
                        <option value="active"   {{ request('status')==='active'      ?'selected':'' }}>Active</option>
                        <option value="inactive" {{ request('status')==='inactive'    ?'selected':'' }}>Inactive</option>
                    </select>
                </div>
                <div class="col-6 col-md-2">
                    <select name="per_page" class="form-select">
                        @foreach([10,25,50,100] as $n)
                        <option value="{{ $n }}" {{ request('per_page',10)==$n?'selected':'' }}>{{ $n }} / page</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-primary flex-fill"><i class="fas fa-search"></i> Filter</button>
                    <a href="{{ route('classes.index') }}" class="btn btn-secondary"><i class="fas fa-times"></i></a>
                </div>
            </form>
        </div>
    </div>

    {{-- Table --}}
    <div class="card">
        <div class="card-body p-0">
            @if($classes->count())
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>
                                <a href="{{ request()->fullUrlWithQuery(['sort'=>'name','direction'=>request('direction')==='asc'?'desc':'asc']) }}" class="sort-link">
                                    Class Name <i class="fas fa-sort{{ request('sort')==='name'?(request('direction')==='asc'?'-up':'-down'):'' }}"></i>
                                </a>
                            </th>
                            <th>
                                <a href="{{ request()->fullUrlWithQuery(['sort'=>'room_number','direction'=>request('direction')==='asc'?'desc':'asc']) }}" class="sort-link">
                                    Room <i class="fas fa-sort"></i>
                                </a>
                            </th>
                            <th>Teacher</th>
                            <th>
                                <a href="{{ request()->fullUrlWithQuery(['sort'=>'capacity','direction'=>request('direction')==='asc'?'desc':'asc']) }}" class="sort-link">
                                    Capacity <i class="fas fa-sort{{ request('sort')==='capacity'?(request('direction')==='asc'?'-up':'-down'):'' }}"></i>
                                </a>
                            </th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($classes as $class)
                        <tr>
                            <td class="text-muted" style="font-size:.75rem;">#{{ $class->id }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="class-avatar">{{ strtoupper(substr($class->name, 0, 2)) }}</div>
                                    <div>
                                        <div class="fw-bold" style="color:#1e293b;">{{ $class->name }}</div>
                                        @if($class->room_number)
                                        <div class="text-muted" style="font-size:.78rem;"><i class="fas fa-map-pin me-1"></i>Room {{ $class->room_number }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td>{{ $class->room_number ?? '—' }}</td>
                            <td>
                                @if($class->teacher)
                                <div class="fw-bold" style="font-size:.875rem;">{{ $class->teacher->name }}</div>
                                <div class="text-muted" style="font-size:.75rem;">{{ $class->teacher->subject ?? '' }}</div>
                                @else
                                <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>
                                <span class="d-flex align-items-center gap-1">
                                    <i class="fas fa-users text-muted" style="font-size:.8rem;"></i>
                                    <strong>{{ $class->capacity }}</strong>
                                </span>
                            </td>
                            <td>
                                @php $cls = $class->status === 'active' ? 'badge-active' : 'badge-inactive'; @endphp
                                <span class="badge {{ $cls }}">
                                    <i class="fas fa-circle me-1" style="font-size:.45rem;vertical-align:middle;"></i>
                                    {{ ucfirst($class->status) }}
                                </span>
                            </td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('classes.enroll.show', $class) }}" class="btn btn-sm btn-outline-primary" title="Enroll Students">
                                        <i class="fas fa-user-plus"></i>
                                    </a>
                                    <a href="{{ route('classes.edit', $class) }}" class="btn btn-sm btn-outline-secondary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if(Auth::user()->isAdmin())
                                    <form method="POST" action="{{ route('classes.destroy', $class) }}"
                                          onsubmit="confirmDelete(event, this, 'Delete class {{ addslashes($class->name) }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($classes->hasPages())
            <div class="d-flex justify-content-between align-items-center px-4 py-3 border-top">
                <small class="text-muted">
                    Showing {{ $classes->firstItem() }}–{{ $classes->lastItem() }} of {{ $classes->total() }} classes
                </small>
                {{ $classes->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>
            @endif

            @else
            <div class="text-center py-5 text-muted">
                <div style="width:72px;height:72px;background:#f1f5f9;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
                    <i class="fas fa-door-open" style="font-size:1.8rem;color:#cbd5e1;"></i>
                </div>
                <p class="fw-bold mb-1" style="color:#475569;">No classes found</p>
                <small>Try adjusting your filters or <a href="{{ route('classes.create') }}" class="text-primary">add a class</a>.</small>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
