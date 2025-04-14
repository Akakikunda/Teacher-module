<!-- resources/views/teacher/dashboard.blade.php -->
@extends('layouts.teacher')

@section('title', 'Teacher Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="row">
    <!-- Stats Cards -->
    <div class="col-md-4 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Classes</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $classCount }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-chalkboard fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Students</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $studentCount }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-user-graduate fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Assignments</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $assignmentCount }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-tasks fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Assignments -->
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Recent Assignments</h6>
                <a href="{{ route('teacher.assignments.create') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus"></i> Create New
                </a>
            </div>
            <div class="card-body">
                @if($recentAssignments->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Class</th>
                                    <th>Subject</th>
                                    <th>Due Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentAssignments as $assignment)
                                <tr>
                                    <td>{{ $assignment->title }}</td>
                                    <td>{{ $assignment->class->name }}</td>
                                    <td>{{ $assignment->subject->name }}</td>
                                    <td>{{ $assignment->due_date->format('M d, Y') }}</td>
                                    <td>
                                        <a href="{{ route('teacher.assignments.grade', $assignment->id) }}" class="btn btn-sm btn-success">
                                            <i class="fas fa-star"></i> Grade
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-center">No assignments created yet. <a href="{{ route('teacher.assignments.create') }}">Create your first assignment</a>.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Quick Links -->
<div class="row">
    <div class="col-md-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a class="btn btn-primary" href="{{ route('teacher.students.create') }}">
                        <i class="fas fa-user-plus me-2"></i> Register New Student
                    </a>
                    <a class="btn btn-info" href="{{ route('teacher.assignments.create') }}">
                        <i class="fas fa-plus-circle me-2"></i> Create New Assignment
                    </a>
                    <a class="btn btn-success" href="{{ route('teacher.classes.index') }}">
                        <i class="fas fa-chalkboard me-2"></i> View My Classes
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Teacher Information</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 text-center mb-3">
                        <i class="fas fa-user-circle fa-5x text-gray-300"></i>
                    </div>
                    <div class="col-md-8">
                        <h5>{{ Auth::user()->name }}</h5>
                        <p class="mb-1"><strong>Employee ID:</strong> {{ $teacher->employee_id }}</p>
                        <p class="mb-1"><strong>Email:</strong> {{ Auth::user()->email }}</p>
                        <p class="mb-1"><strong>Qualification:</strong> {{ $teacher->qualification ?? 'Not set' }}</p>
                        <p class="mb-1"><strong>Join Date:</strong> {{ $teacher->join_date ? $teacher->join_date->format('M d, Y') : 'Not set' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
