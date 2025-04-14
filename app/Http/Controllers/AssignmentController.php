<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assignment;

class AssignmentController extends Controller
{
    public function create()
    {
        return view('assignments.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'due_date' => 'required|date',
        ]);

        Assignment::create([
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'teacher_id' => auth()->teacher_id,
        ]);

        return redirect()->route('teacher.dashboard')->with('success', 'Assignment created successfully!');
    }
}

