<!-- resources/views/teacher/classes/index.blade.php -->
@extends('layouts.teacher')

@section('title', 'My Classes')
@section('page-title', 'My Classes')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">My Classes and Subjects</h6>
            </div>
            <div class="card-body">
                @if($classSubjects->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Class</th>
                                    <th>Grade Level</th>
                                    <th>Academic Year</th>
                                    <th>Subject</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($classSubjects as $cs)
                                <tr>
                                    <td>{{ $cs->class->name }}</td>
                                    <td>{{ $cs->class->grade_level }}</td>
                                    <td>{{ $cs->class->academic_year }}</td>
                                    <td>{{ $cs->subject->name }} ({{ $cs->subject->code }})</td>
                                    <td>
                                        <a href="{{ route('teacher.classes.show', $cs->class_id) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i> View Class
                                        </a>
                                        <a href="{{ route('teacher.assignments.create') }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-plus"></i> Add Assignment
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-center">You haven't been assigned to any classes yet. Please contact the administrator.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

<!-- resources/views/teacher/classes/show.blade.php -->
@extends('layouts.teacher')

@section('title', $class->name . ' - Class Details')
@section('page-title', $class->name . ' - Class Details')

@section('content')
<div class="row">
    <!-- Class Info Card -->
    <div class="col-md-4 mb-4">
        <div class="card shadow h-100">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Class Information</h6>
            </div>
            <div class="card-body">
                <p><strong>Name:</strong> {{ $class->name }}</p>
                <p><strong>Grade Level:</strong> {{ $class->grade_level }}</p>
                <p><strong>Academic Year:</strong> {{ $class->academic_year }}</p>
                <p><strong>Description:</strong> {{ $class->description ?? 'N/A' }}</p>
                <p><strong>Total Students:</strong> {{ $students->count() }}</p>
                <hr>
                <h6 class="font-weight-bold">Subjects Teaching:</h6>
                <ul class="list-group">
                    @foreach($subjects as $subject)
                        <li class="list-group-item">{{ $subject->name }} ({{ $subject->code }})</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    
    <!-- Students List Card -->
    <div class="col-md-8 mb-4">
        <div class="card shadow">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Students in {{ $class->name }}</h6>
                <a href="{{ route('teacher.students.create') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-user-plus"></i> Add Student
                </a>
            </div>
            <div class="card-body">
                @if($students->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Admission #</th>
                                    <th>Name</th>
                                    <th>Gender</th>
                                    <th>Guardian</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($students as $student)
                                <tr>
                                    <td>{{ $student->admission_number }}</td>
                                    <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                                    <td>{{ ucfirst($student->gender) }}</td>
                                    <td>{{ $student->guardian_name }} ({{ $student->guardian_phone }})</td>
                                    <td>
                                        <a href="{{ route('teacher.students.edit', $student->id) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-center">No students in this class yet. <a href="{{ route('teacher.students.create') }}">Add your first student</a>.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Recent Assignments for this Class -->
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Recent Assignments for {{ $class->name }}</h6>
                <a href="{{ route('teacher.assignments.create') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus"></i> Create Assignment
                </a>
            </div>
            <div class="card-body">
                @if($class->assignments->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Subject</th>
                                    <th>Due Date</th>
                                    <th>Max Score</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($class->assignments->sortByDesc('created_at')->take(5) as $assignment)
                                <tr>
                                    <td>{{ $assignment->title }}</td>
                                    <td>{{ $assignment->subject->name }}</td>
                                    <td>{{ $assignment->due_date->format('M d, Y') }}</td>
                                    <td>{{ $assignment->max_score }}</td>
                                    <td>
                                        <a href="{{ route('teacher.assignments.grade', $assignment->id) }}" class="btn btn-sm btn-success">
                                            <i class="fas fa-star"></i> Grade
                                        </a>
                                        <a href="{{ route('teacher.assignments.edit', $assignment->id) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-center">No assignments for this class yet. <a href="{{ route('teacher.assignments.create') }}">Create your first assignment</a>.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection