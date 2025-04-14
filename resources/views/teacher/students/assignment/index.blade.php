<!-- resources/views/teacher/assignments/index.blade.php -->
@extends('layouts.teacher')

@section('title', 'Assignments')
@section('page-title', 'Assignments Management')

@section('page-actions')
<a href="{{ route('teacher.assignments.create') }}" class="btn btn-sm btn-primary">
    <i class="fas fa-plus"></i> Create New Assignment
</a>
@endsection

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Your Assignments</h6>
    </div>
    <div class="card-body">
        @if($assignments->count() > 0)
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Class</th>
                            <th>Subject</th>
                            <th>Due Date</th>
                            <th>Max Score</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($assignments as $assignment)
                        <tr>
                            <td>{{ $assignment->title }}</td>
                            <td>{{ $assignment->class->name }}</td>
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
                                <form action="{{ route('teacher.assignments.destroy', $assignment->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this assignment?')">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $assignments->links() }}
            </div>
        @else
            <p class="text-center">No assignments created yet. <a href="{{ route('teacher.assignments.create') }}">Create your first assignment</a>.</p>
        @endif
    </div>
</div>
@endsection

<!-- resources/views/teacher/assignments/create.blade.php -->
@extends('layouts.teacher')

@section('title', 'Create Assignment')
@section('page-title', 'Create New Assignment')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Assignment Details</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('teacher.assignments.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="title" class="form-label">Assignment Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="class_subject" class="form-label">Class & Subject <span class="text-danger">*</span></label>
                        <div class="row">
                            <div class="col-md-6">
                                <select id="class_subject" class="form-select @error('class_id') is-invalid @enderror" required>
                                    <option value="">Select Class & Subject</option>
                                    @foreach($classSubjects as $cs)
                                        <option value="{{ $cs['class_id'] }}-{{ $cs['subject_id'] }}" 
                                                {{ (old('class_id') == $cs['class_id'] && old('subject_id') == $cs['subject_id']) ? 'selected' : '' }}>
                                            {{ $cs['display'] }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('class_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <input type="hidden" name="class_id" id="class_id" value="{{ old('class_id') }}">
                        <input type="hidden" name="subject_id" id="subject_id" value="{{ old('subject_id') }}">
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Assignment Description <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="5" required>{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="due_date" class="form-label">Due Date <span class="text-danger">*</span></label>
                                <input type="datetime-local" class="form-control @error('due_date') is-invalid @enderror" id="due_date" name="due_date" value="{{ old('due_date') }}" required>
                                @error('due_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="max_score" class="form-label">Maximum Score <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('max_score') is-invalid @enderror" id="max_score" name="max_score" value="{{ old('max_score', 100) }}" min="1" max="1000" required>
                                @error('max_score')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('teacher.assignments.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Create Assignment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle the class_subject select to update hidden fields
        const classSubjectSelect = document.getElementById('class_subject');
        const classIdInput = document.getElementById('class_id');
        const subjectIdInput = document.getElementById('subject_id');
        
        classSubjectSelect.addEventListener('change', function() {
            if (this.value) {
                const [classId, subjectId] = this.value.split('-');
                classIdInput.value = classId;
                subjectIdInput.value = subjectId;
            } else {
                classIdInput.value = '';
                subjectIdInput.value = '';
            }
        });
        
        // Trigger on page load if there's a selected value
        if (classSubjectSelect.value) {
            const [classId, subjectId] = classSubjectSelect.value.split('-');
            classIdInput.value = classId;
            subjectIdInput.value = subjectId;
        }
    });
</script>
@endsection

<!-- resources/views/teacher/assignments/edit.blade.php -->
@extends('layouts.teacher')

@section('title', 'Edit Assignment')
@section('page-title', 'Edit Assignment')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Edit Assignment: {{ $assignment->title }}</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('teacher.assignments.update', $assignment->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="title" class="form-label">Assignment Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $assignment->title) }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="class_subject" class="form-label">Class & Subject <span class="text-danger">*</span></label>
                        <div class="row">
                            <div class="col-md-6">
                                <select id="class_subject" class="form-select @error('class_id') is-invalid @enderror" required>
                                    <option value="">Select Class & Subject</option>
                                    @foreach($classSubjects as $cs)
                                        <option value="{{ $cs['class_id'] }}-{{ $cs['subject_id'] }}" 
                                                {{ (old('class_id', $assignment->class_id) == $cs['class_id'] && old('subject_id', $assignment->subject_id) == $cs['subject_id']) ? 'selected' : '' }}>
                                            {{ $cs['display'] }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('class_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <input type="hidden" name="class_id" id="class_id" value="{{ old('class_id', $assignment->class_id) }}">
                        <input type="hidden" name="subject_id" id="subject_id" value="{{ old('subject_id', $assignment->subject_id) }}">
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">Assignment Description <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="5" required>{{ old('description', $assignment->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="due_date" class="form-label">Due Date <span class="text-danger">*</span></label>
                                <input type="datetime-local" class="form-control @error('due_date') is-invalid @enderror" id="due_date" name="due_date" 
                                       value="{{ old('due_date', $assignment->due_date->format('Y-m-d\TH:i')) }}" required>
                                @error('due_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="max_score" class="form-label">Maximum Score <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('max_score') is-invalid @enderror" id="max_score" name="max_score" 
                                       value="{{ old('max_score', $assignment->max_score) }}" min="1" max="1000" required>
                                @error('max_score')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('teacher.assignments.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update Assignment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle the class_subject select to update hidden fields
        const classSubjectSelect = document.getElementById('class_subject');
        const classIdInput = document.getElementById('class_id');
        const subjectIdInput = document.getElementById('subject_id');
        
        classSubjectSelect.addEventListener('change', function() {
            if (this.value) {
                const [classId, subjectId] = this.value.split('-');
                classIdInput.value = classId;
                subjectIdInput.value = subjectId;
            } else {
                classIdInput.value = '';
                subjectIdInput.value = '';
            }
        });
        
        // Trigger on page load if there's a selected value
        if (classSubjectSelect.value) {
            const [classId, subjectId] = classSubjectSelect.value.split('-');
            classIdInput.value = classId;
            subjectIdInput.value = subjectId;
        }
    });
</script>
@endsection

<!-- resources/views/teacher/assignments/grade.blade.php -->
@extends('layouts.teacher')

@section('title', 'Grade Assignment')
@section('page-title', 'Grade Assignment: ' . $assignment->title)

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Assignment Details</h6>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <p><strong>Class:</strong> {{ $assignment->class->name }}</p>
                <p><strong>Subject:</strong> {{ $assignment->subject->name }}</p>
                <p><strong>Due Date:</strong> {{ $assignment->due_date->format('M d, Y h:i A') }}</p>
            </div>
            <div class="col-md-6">
                <p><strong>Maximum Score:</strong> {{ $assignment->max_score }}</p>
                <p><strong>Total Students:</strong> {{ $studentAssignments->count() }}</p>
                <p><strong>Graded:</strong> {{ $studentAssignments->whereNotNull('score')->count() }} / {{ $studentAssignments->count() }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <p><strong>Description:</strong> {{ $assignment->description }}</p>
            </div>
        </div>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Student Grades</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('teacher.assignments.update-grades', $assignment->id) }}" method="POST">
            @csrf
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Student Name</th>
                            <th>Admission #</th>
                            <th>Submission Status</th>
                            <th>Score (Max: {{ $assignment->max_score }})</th>
                            <th>Grade</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($studentAssignments as $sa)
                        <tr>
                            <td>{{ $sa->student->first_name }} {{ $sa->student->last_name }}</td>
                            <td>{{ $sa->student->admission_number }}</td>
                            <td>
                                @if($sa->submitted_at)
                                    <span class="badge bg-success">Submitted</span>
                                    <small class="d-block">{{ $sa->submitted_at->format('M d, Y h:i A') }}</small>
                                @else
                                    <span class="badge bg-warning">Not Submitted</span>
                                @endif
                            </td>
                            <td>
                                <input type="number" class="form-control" name="scores[{{ $sa->student_id }}]" 
                                       value="{{ $sa->score }}" min="0" max="{{ $assignment->max_score }}">
                            </td>
                            <td>
                                <span class="badge {{ $sa->grade == 'A' ? 'bg-success' : ($sa->grade == 'F' ? 'bg-danger' : 'bg