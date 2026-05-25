@extends('layouts.app')
@section('title', 'Edit User')
@section('content')
<div class="page-header">
    <h1 class="page-title"><i class="fas fa-user-edit"></i> Edit User</h1>
    <a href="{{ route('users.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back</a>
</div>

<div class="row">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header"><i class="fas fa-user"></i> User Details</div>
            <div class="card-body">
                <form method="POST" action="{{ route('users.update', $user) }}">
                    @csrf @method('PUT')
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" value="{{ old('name',$user->name) }}" class="form-control @error('name') is-invalid @enderror" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" value="{{ old('email',$user->email) }}" class="form-control @error('email') is-invalid @enderror" required>
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Role <span class="text-danger">*</span></label>
                            <select name="role" class="form-select @error('role') is-invalid @enderror">
                                @php
                                    $roles = ['admin','teacher','staff','student'];
                                    if(auth()->user()->isSuperAdmin()) {
                                        array_unshift($roles, 'super_admin');
                                    } elseif($user->role === 'super_admin') {
                                        // If editing a super admin but we're not one (shouldn't happen due to controller logic, but just in case)
                                        $roles[] = 'super_admin';
                                    }
                                @endphp
                                @foreach($roles as $r)
                                    <option value="{{ $r }}" {{ old('role',$user->role)==$r?'selected':'' }}>{{ ucwords(str_replace('_', ' ', $r)) }}</option>
                                @endforeach
                            </select>
                            @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 d-flex align-items-end pb-1">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active',$user->is_active)?'checked':'' }}>
                                <label class="form-check-label fw-600" for="is_active" style="font-weight:600;">Active Account</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">New Password <span class="text-muted">(leave blank to keep)</span></label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Min 6 characters">
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Repeat password">
                        </div>
                    </div>
                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save Changes</button>
                        <a href="{{ route('users.index') }}" class="btn btn-secondary"><i class="fas fa-times"></i> Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card">
            <div class="card-header"><i class="fas fa-info-circle"></i> Account Info</div>
            <div class="card-body" style="font-size:.88rem;">
                <div class="d-flex justify-content-between py-2 border-bottom">
                    <span class="text-muted">User ID</span><span style="font-weight:600;">#{{ $user->id }}</span>
                </div>
                <div class="d-flex justify-content-between py-2 border-bottom">
                    <span class="text-muted">Created</span><span style="font-weight:600;">{{ $user->created_at->format('M j, Y') }}</span>
                </div>
                <div class="d-flex justify-content-between py-2">
                    <span class="text-muted">Last Updated</span><span style="font-weight:600;">{{ $user->updated_at->format('M j, Y') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
