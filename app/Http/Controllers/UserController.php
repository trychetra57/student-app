<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Only administrators can manage users.');
        }

        $query = User::query();
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(fn($q) => $q->where('name','like',"%$s%")->orWhere('email','like',"%$s%"));
        }
        if ($request->filled('role')) $query->where('role', $request->role);

        $users = $query->orderBy('name')->paginate(15)->withQueryString();
        return view('users.index', compact('users'));
    }

    public function edit(User $user)
    {
        if (!auth()->user()->isAdmin()) abort(403);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        if (!auth()->user()->isAdmin()) abort(403);

        $data = $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email,'.$user->id,
            'role'      => 'required|in:super_admin,admin,teacher,staff,student',
            'is_active' => 'boolean',
            'password'  => 'nullable|string|min:6|confirmed',
        ]);

        if ($data['role'] === 'super_admin' && !auth()->user()->isSuperAdmin()) {
            return redirect()->back()->with('error', 'Only a Super Admin can assign the Super Admin role.')->withInput();
        }

        if ($user->isSuperAdmin() && !auth()->user()->isSuperAdmin()) {
            return redirect()->back()->with('error', 'Only a Super Admin can edit another Super Admin.')->withInput();
        }

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }
        $data['is_active'] = $request->boolean('is_active');

        $user->update($data);
        return redirect()->route('users.index')->with('success', "User '{$user->name}' updated.");
    }

    public function destroy(User $user)
    {
        if (!auth()->user()->isAdmin()) abort(403);
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'You cannot delete your own account.');
        }
        if ($user->isSuperAdmin() && !auth()->user()->isSuperAdmin()) {
            return redirect()->back()->with('error', 'Only a Super Admin can delete another Super Admin.');
        }
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted.');
    }

    public function toggleActive(User $user)
    {
        if (!auth()->user()->isAdmin()) abort(403);
        $user->update(['is_active' => !$user->is_active]);
        $status = $user->is_active ? 'activated' : 'deactivated';
        return redirect()->back()->with('success', "User {$status}.");
    }

    public function profile()
    {
        $user = auth()->user();
        return view('users.profile', compact('user'));
    }
}
