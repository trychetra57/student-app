<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use App\Models\Teacher;
use Illuminate\Http\Request;

class WebSchoolClassController extends Controller
{
    public function index(Request $request)
    {
        $query = SchoolClass::query()->with('teacher');

        // Search
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(fn($q) => $q
                ->where('name', 'like', "%$s%")
                ->orWhere('room_number', 'like', "%$s%")
            );
        }

        // Status filter
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Sorting
        $sort = $request->get('sort', 'name');
        $direction = $request->get('direction', 'asc');
        $allowed = ['name', 'room_number', 'capacity', 'status'];
        if (in_array($sort, $allowed)) {
            $query->orderBy($sort, $direction);
        }

        $perPage = $request->get('per_page', 10);
        $classes = $query->paginate($perPage)->withQueryString();

        $activeCount = SchoolClass::where('status', 'active')->count();
        $inactiveCount = SchoolClass::where('status', 'inactive')->count();

        return view('classes.index', compact('classes', 'activeCount', 'inactiveCount'));
    }

    public function create()
    {
        $teachers = Teacher::orderBy('name')->get();
        return view('classes.create', compact('teachers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'room_number' => 'nullable|string|max:100',
            'teacher_id' => 'nullable|exists:teachers,id',
            'capacity' => 'nullable|integer|min:1|max:1000',
            'status' => 'nullable|in:active,inactive',
        ]);

        $data['status'] = $data['status'] ?? 'active';
        $data['capacity'] = $data['capacity'] ?? 30;

        $schoolClass = SchoolClass::create($data);

        return redirect()->route('classes.index')
            ->with('success', "Class '{$schoolClass->name}' added successfully!");
    }

    public function edit(SchoolClass $class)
    {
        $teachers = Teacher::orderBy('name')->get();
        return view('classes.edit', ['schoolClass' => $class, 'teachers' => $teachers]);
    }

    public function update(Request $request, SchoolClass $class)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'room_number' => 'nullable|string|max:100',
            'teacher_id' => 'nullable|exists:teachers,id',
            'capacity' => 'nullable|integer|min:1|max:1000',
            'status' => 'sometimes|required|in:active,inactive',
        ]);

        $class->update($data);
        return redirect()->route('classes.index')
            ->with('success', 'Class updated successfully!');
    }

    public function destroy(SchoolClass $class)
    {
        $class->delete();
        return redirect()->route('classes.index')
            ->with('success', "Class '{$class->name}' deleted.");
    }
}
