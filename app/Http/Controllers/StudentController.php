<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;


class StudentController extends Controller
{
    public function create()
    {
        //return view('students.create');
        return view('students.create', ['pageSlug' => 'register']);
    }

    public function store(Request $request)
    {
        //basic validation
        $request->validate([
            'name' => 'required',
            'class' => 'required',
            'email' => 'required|email|unique:students,email',
        ]);

        Student::create($request->all());

        //return redirect()->back()->with('success', 'Student registered successfully!');
        return redirect()->route('students.create')->with('success', 'Student registered successfully!');
    }
}


