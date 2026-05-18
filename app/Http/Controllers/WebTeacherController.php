<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;

class WebTeacherController extends Controller
{
    public function index(Request $request)
    {
        $query = Teacher::query();

        // Search
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(fn($q) => $q
                ->where('name',        'like', "%$s%")
                ->orWhere('email',     'like', "%$s%")
                ->orWhere('phone',     'like', "%$s%")
                ->orWhere('subject',   'like', "%$s%")
                ->orWhere('department','like', "%$s%")
            );
        }

        // Status filter
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Department filter
        if ($request->filled('department')) {
            $query->where('department', $request->department);
        }

        // Sorting
        $sort      = $request->get('sort', 'name');
        $direction = $request->get('direction', 'asc');
        $allowed   = ['name', 'email', 'subject', 'department', 'status', 'joined_date'];
        if (in_array($sort, $allowed)) {
            $query->orderBy($sort, $direction);
        }

        $perPage  = $request->get('per_page', 10);
        $teachers = $query->paginate($perPage)->withQueryString();

        // Sidebar counts
        $activeCount   = Teacher::where('status', 'active')->count();
        $inactiveCount = Teacher::where('status', 'inactive')->count();
        $onLeaveCount  = Teacher::where('status', 'on_leave')->count();

        // Department list for filter dropdown
        $departments = Teacher::whereNotNull('department')
            ->distinct()->orderBy('department')->pluck('department');

        return view('teachers.index', compact(
            'teachers', 'activeCount', 'inactiveCount', 'onLeaveCount', 'departments'
        ));
    }

    public function create()
    {
        return view('teachers.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:teachers,email',
            'phone'         => 'nullable|string|max:50',
            'subject'       => 'nullable|string|max:100',
            'department'    => 'nullable|string|max:100',
            'address'       => 'nullable|string|max:500',
            'date_of_birth' => 'nullable|date|before:today',
            'joined_date'   => 'nullable|date',
            'qualification' => 'nullable|string|max:255',
            'status'        => 'nullable|in:active,inactive,on_leave',
        ]);

        $data['status'] = $data['status'] ?? 'active';
        $teacher = Teacher::create($data);

        return redirect()->route('teachers.index')
            ->with('success', "Teacher '{$teacher->name}' added successfully!");
    }

    public function show(Teacher $teacher)
    {
        return view('teachers.show', compact('teacher'));
    }

    public function edit(Teacher $teacher)
    {
        return view('teachers.edit', compact('teacher'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        $data = $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:teachers,email,'.$teacher->id,
            'phone'         => 'nullable|string|max:50',
            'subject'       => 'nullable|string|max:100',
            'department'    => 'nullable|string|max:100',
            'address'       => 'nullable|string|max:500',
            'date_of_birth' => 'nullable|date|before:today',
            'joined_date'   => 'nullable|date',
            'qualification' => 'nullable|string|max:255',
            'status'        => 'sometimes|required|in:active,inactive,on_leave',
        ]);

        $teacher->update($data);
        return redirect()->route('teachers.show', $teacher)
            ->with('success', 'Teacher updated successfully!');
    }

    public function destroy(Teacher $teacher)
    {
        $teacher->delete();
        return redirect()->route('teachers.index')
            ->with('success', "Teacher '{$teacher->name}' deleted.");
    }
}
