<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClassController extends Controller
{
    public function index()
    {
        $teacher = Auth::user()->teacherProfile;
        $classSubjects = $teacher->classSubjects()
            ->with(['class', 'subject'])
            ->get();
        
        return view('teacher.classes.index', compact('classSubjects'));
    }
    
    public function show($classId)
    {
        $teacher = Auth::user()->teacherProfile;
        
        // Check if teacher is assigned to this class
        $teacherClass = $teacher->classes()->where('classes.id', $classId)->first();
        
        if (!$teacherClass) {
            abort(403, 'Unauthorized action.');
        }
        
        $class = SchoolClass::findOrFail($classId);
        $students = Student::where('class_id', $classId)->get();
        $subjects = $teacher->subjects()
            ->wherePivot('class_id', $classId)
            ->get();
            
        return view('teacher.classes.show', compact('class', 'students', 'subjects'));
    }
}