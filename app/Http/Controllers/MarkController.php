<?php

namespace App\Http\Controllers;


use App\Models\Student;
use App\Models\Mark;
use Illuminate\Http\Request;

class MarkController extends Controller
{
public function create()
{
    $students = Student::all();
    return view('marks.create', compact('students'));
}

public function store(Request $request)
{
    $request->validate([
        'student_id' => 'required',
        'subject' => 'required|string',
        'mark' => 'required|numeric|min:0|max:100',
    ]);

    $grade = $this->calculateGrade($request->mark);

    Mark::create([
        'student_id' => $request->student_id,
        'subject' => $request->subject,
        'mark' => $request->mark,
        'grade' => $grade,
    ]);

    return redirect()->route('marks.index')->with('success', 'Mark recorded successfully!');
}



public function index()
{
    $students = Student::with('marks')->get();
    return view('marks.index', compact('students'));
}


public function edit($id)
{
    $mark = Mark::findOrFail($id);
    return view('marks.edit', compact('mark'));
}
public function update(Request $request, $id)
{
    $request->validate([
        'subject' => 'required|string',
        'mark' => 'required|numeric|min:0|max:100',
    ]);

    $grade = $this->calculateGrade($request->mark);

    $mark = Mark::findOrFail($id);
    $mark->update([
        'subject' => $request->subject,
        'mark' => $request->mark,
        'grade' => $grade,
    ]);

    return redirect()->route('marks.index')->with('success', 'Mark updated successfully!');
}

private function calculateGrade($mark)
{
    if ($mark >= 80) return 'A';
    if ($mark >= 70) return 'B';
    if ($mark >= 60) return 'C';
    if ($mark >= 50) return 'D';
    return 'F';
}


public function destroy($id)
{
    $mark = Mark::findOrFail($id);
    $mark->delete();
    return back()->with('success', 'Mark deleted');
}

}
