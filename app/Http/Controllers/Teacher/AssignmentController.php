<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Student;
use App\Models\StudentAssignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AssignmentController extends Controller
{
    public function index()
    {
        $teacher = Auth::user()->teacherProfile;
        $assignments = $teacher->assignments()
            ->with(['class', 'subject'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('teacher.assignments.index', compact('assignments'));
    }
    
    public function create()
    {
        $teacher = Auth::user()->teacherProfile;
        $classSubjects = $teacher->classSubjects()
            ->with(['class', 'subject'])
            ->get()
            ->map(function ($item) {
                return [
                    'class_id' => $item->class_id,
                    'subject_id' => $item->subject_id,
                    'class_name' => $item->class->name,
                    'subject_name' => $item->subject->name,
                    'display' => $item->class->name . ' - ' . $item->subject->name,
                ];
            });
        
        return view('teacher.assignments.create', compact('classSubjects'));
    }
    
    public function store(Request $request)
    {
        $teacher = Auth::user()->teacherProfile;
        
        // Verify that the teacher teaches this class and subject
        $teacherClassSubjects = $teacher->classSubjects()
            ->where('class_id', $request->class_id)
            ->where('subject_id', $request->subject_id)
            ->exists();
            
        if (!$teacherClassSubjects) {
            return back()->with('error', 'You are not authorized to create assignments for this class and subject.');
        }
        
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'class_id' => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'due_date' => 'required|date|after:today',
            'max_score' => 'required|integer|min:1',
        ]);
        
        $assignment = new Assignment($request->all());
        $assignment->teacher_profile_id = $teacher->id;
        $assignment->save();
        
        // Automatically assign to all students in the class
        $students = Student::where('class_id', $request->class_id)->get();
        foreach ($students as $student) {
            StudentAssignment::create([
                'student_id' => $student->id,
                'assignment_id' => $assignment->id,
            ]);
        }
        
        return redirect()->route('teacher.assignments.index')
            ->with('success', 'Assignment created and assigned to students successfully!');
    }
    
    public function edit(Assignment $assignment)
    {
        $this->authorizeTeacherForAssignment($assignment);
        
        $teacher = Auth::user()->teacherProfile;
        $classSubjects = $teacher->classSubjects()
            ->with(['class', 'subject'])
            ->get()
            ->map(function ($item) {
                return [
                    'class_id' => $item->class_id,
                    'subject_id' => $item->subject_id,
                    'class_name' => $item->class->name,
                    'subject_name' => $item->subject->name,
                    'display' => $item->class->name . ' - ' . $item->subject->name,
                ];
            });
        
        return view('teacher.assignments.edit', compact('assignment', 'classSubjects'));
    }
    
    public function update(Request $request, Assignment $assignment)
    {
        $this->authorizeTeacherForAssignment($assignment);
        
        $teacher = Auth::user()->teacherProfile;
        
        // Verify that the teacher teaches this class and subject
        $teacherClassSubjects = $teacher->classSubjects()
            ->where('class_id', $request->class_id)
            ->where('subject_id', $request->subject_id)
            ->exists();
            
        if (!$teacherClassSubjects) {
            return back()->with('error', 'You are not authorized to create assignments for this class and subject.');
        }
        
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'class_id' => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'due_date' => 'required|date',
            'max_score' => 'required|integer|min:1',
        ]);
        
        $assignment->update($request->all());
        
        return redirect()->route('teacher.assignments.index')
            ->with('success', 'Assignment updated successfully!');
    }
    
    public function destroy(Assignment $assignment)
    {
        $this->authorizeTeacherForAssignment($assignment);
        
        $assignment->delete();
        
        return redirect()->route('teacher.assignments.index')
            ->with('success', 'Assignment deleted successfully!');
    }
    
    public function grade(Assignment $assignment)
    {
        $this->authorizeTeacherForAssignment($assignment);
        
        $studentAssignments = StudentAssignment::with('student')
            ->where('assignment_id', $assignment->id)
            ->get();
        
        return view('teacher.assignments.grade', compact('assignment', 'studentAssignments'));
    }
    
    public function updateGrades(Request $request, Assignment $assignment)
    {
        $this->authorizeTeacherForAssignment($assignment);
        
        // Validate scores
        $scores = $request->input('scores', []);
        $remarks = $request->input('remarks', []);
        
        foreach ($scores as $studentId => $score) {
            if ($score !== null && $score !== '') {
                $studentAssignment = StudentAssignment::where('student_id', $studentId)
                    ->where('assignment_id', $assignment->id)
                    ->first();
                    
                if ($studentAssignment) {
                    // Validate the score
                    $validScore = min(max(0, (int)$score), $assignment->max_score);
                    
                    // Calculate grade based on score percentage
                    $percentage = ($validScore / $assignment->max_score) * 100;
                    $grade = $this->calculateGrade($percentage);
                    
                    // Update the record
                    $studentAssignment->update([
                        'score' => $validScore,
                        'remarks' => $remarks[$studentId] ?? null,
                        'grade' => $grade,
                    ]);
                }
            }
        }
        
        return redirect()->route('teacher.assignments.grade', $assignment->id)
            ->with('success', 'Grades updated successfully!');
    }
    
    private function calculateGrade($percentage)
    {
        if ($percentage >= 90) return 'A';
        if ($percentage >= 80) return 'B';
        if ($percentage >= 70) return 'C';
        if ($percentage >= 60) return 'D';
        return 'F';
    }
    
    private function authorizeTeacherForAssignment(Assignment $assignment)
    {
        $teacher = Auth::user()->teacherProfile;
        
        if ($assignment->teacher_profile_id !== $teacher->id) {
            abort(403, 'Unauthorized action.');
        }
    }
}