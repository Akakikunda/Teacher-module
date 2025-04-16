<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;


class StudentController extends Controller
{
   // public function create()
    /*{
        //return view('students.create');
        //return view('students.create', ['pageSlug' => 'register']);
    }*/
    public function create()
{
    return view('students.create'); // 👈 This loads the Blade form
}


    /*public function store(Request $request)
    {
        //basic validation
        $request->validate([
            'name' => 'required',
            'class' => 'required',
            'email' => 'required|email|unique:students,email',
        ]);

        $validated['status'] = 'pending'; // 👈 mark as pending
        //$validated['created_by'] = auth()->user()->id; // (optional) track which teacher registered
    

        //Student::create($request->all());
        Student::create($validated);

        //return redirect()->back()->with('success', 'Student registered successfully!');
        //return redirect()->route('students.create')->with('success', 'Student registered successfully!');
        return redirect()->route('students.index')->with('success', 'Student submitted for approval.');

    }*/
    public function store(Request $request)
{
    // Validate required fields
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'class' => 'required|string|max:255',
    ]);

    // Add default status (teacher submits to headteacher)
    $validated['status'] = 'pending';

    // Save to database
    Student::create($validated);

    // Redirect with success message
    return redirect()->route('students.index')->with('success', 'Student submitted for approval.');
}
public function index()
{
    $students = \App\Models\Student::all(); // fetch all students
    return view('students.index', compact('students')); // return the view
}


}

   

