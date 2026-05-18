@extends('layouts.app')
@section('title', 'User Management')
@section('content')
<div class="page-header">
    <h1 class="page-title"><i class="fas fa-user-shield"></i> User Management</h1>
</div>

<div style="background:white;border-radius:16px;box-shadow:0 2px 12px rgba(0,0,0,.06);padding:20px 24px;margin-bottom:24px;">
    <form method="GET" class="row g-3 align-items-end">
        <div class="col-12 col-md-5">
            <label class="form-label">Search</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Name or email…" class="form-control">
        </div>
        <div class="col-12 col-md-3">
            <label class="form-label">Role</label>
            <select name="role" class="form-select">
                <option value="">All Roles</option>
                @foreach(['admin','teacher','staff','student'] as $r)
                    <option value="{{ $r }}" {{ request('role')==$r?'selected':'' }}>{{ ucfirst($r) }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12 col-md-4 d-flex gap-2">
            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Search</button>
            <a href="{{ route('users.index') }}" class="btn btn-secondary"><i class="fas fa-times"></i> Clear</a>
        </div>
    </form>
</div>

<div style="background:white;border-radius:16px;box-shadow:0 2px 12px rgba(0,0,0,.06);overflow:hidden;">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Role</th>
                    <th class="d-none d-md-table-cell">Status</th>
                    <th class="d-none d-lg-table-cell">Joined</th>
                    <th width="160">Actions</th>
                </tr>
            </thead>
            <tbody>
            @forelse($users as $user)
            <tr>
                <td>
                    <div class="d-flex align-items-center gap-3">
                        <div style="width:38px;height:38px;border-radius:10px;background:linear-gradient(135deg,#2563eb,#60a5fa);display:flex;align-items:center;justify-content:center;font-weight:700;color:white;font-size:.8rem;flex-shrink:0;">
                            {{ strtoupper(substr($user->name,0,2)) }}
                        </div>
                        <div>
                            <div style="font-weight:600;">{{ $user->name }}
                                @if($user->id === auth()->id())
                                    <span style="background:#eff6ff;color:#2563eb;padding:2px 8px;border-radius:20px;font-size:.7rem;font-weight:600;margin-left:6px;">You</span>
                                @endif
                            </div>
                            <div style="font-size:.78rem;color:#94a3b8;">{{ $user->email }}</div>
                        </div>
                    </div>
                </td>
                <td>
                    @php
                        $roleColors = ['admin'=>['#fef3c7','#92400e'],'teacher'=>['#ede9fe','#5b21b6'],'staff'=>['#dbeafe','#1d4ed8'],'student'=>['#dcfce7','#15803d']];
                        $rc = $roleColors[$user->role] ?? ['#f1f5f9','#475569'];
                    @endphp
                    <span style="background:{{ $rc[0] }};color:{{ $rc[1] }};padding:4px 12px;border-radius:20px;font-size:.75rem;font-weight:700;">{{ ucfirst($user->role ?? 'staff') }}</span>
                </td>
                <td class="d-none d-md-table-cell">
                    @if($user->is_active)
                        <span class="badge badge-active"><i class="fas fa-check-circle"></i> Active</span>
                    @else
                        <span class="badge badge-inactive"><i class="fas fa-times-circle"></i> Inactive</span>
                    @endif
                </td>
                <td class="d-none d-lg-table-cell" style="color:#94a3b8;font-size:.8rem;">{{ $user->created_at->format('M j, Y') }}</td>
                <td>
                    <div class="d-flex gap-1">
                        <a href="{{ route('users.edit',$user) }}" class="btn btn-sm btn-outline-primary" title="Edit"><i class="fas fa-edit"></i></a>
                        <form method="POST" action="{{ route('users.toggle',$user) }}" class="d-inline">
                            @csrf
                            <button class="btn btn-sm {{ $user->is_active ? 'btn-outline-warning' : 'btn-outline-success' }}" title="{{ $user->is_active ? 'Deactivate' : 'Activate' }}">
                                <i class="fas fa-{{ $user->is_active ? 'pause' : 'play' }}"></i>
                            </button>
                        </form>
                        @if($user->id !== auth()->id())
                        <form method="POST" action="{{ route('users.destroy',$user) }}" class="d-inline" onsubmit="confirmDelete(event,this,'Delete user {{ addslashes($user->name) }}?');">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" title="Delete"><i class="fas fa-trash"></i></button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="5">
                <div class="text-center py-5" style="color:#94a3b8;">
                    <i class="fas fa-users fa-3x mb-3" style="opacity:.3;"></i>
                    <p>No users found.</p>
                </div>
            </td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if($users->hasPages())
    <div class="px-4 py-3 border-top d-flex justify-content-center">
        {{ $users->appends(request()->query())->links() }}
    </div>
    @endif
</div>
@endsection
