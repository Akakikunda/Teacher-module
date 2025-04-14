<!-- resources/views/marks/index.blade.php -->

@extends('layouts.app') <!-- Extend the main layout -->

@section('content')
<div class="container">
    <h2>Enter Marks</h2>

    <!-- Display success message if marks are saved -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Form for entering marks -->
    <form action="{{ route('marks.store') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label for="student_id">Student</label>
            <select name="student_id" id="student_id" class="form-control" required>
                <!-- Assuming you have a list of students to populate here -->
                @foreach($students as $student)
                    <option value="{{ $student->id }}">{{ $student->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="subject">Subject</label>
            <input type="text" name="subject" id="subject" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="marks">Marks</label>
            <input type="number" name="marks" id="marks" class="form-control" max="100" required>
        </div>

        <button type="submit" class="btn btn-primary">Save Marks</button>
    </form>

    <h3>Existing Marks</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Student</th>
                <th>Subject</th>
                <th>Marks</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $student)
                @foreach($student->marks as $mark)
                    <tr>
                        <td>{{ $student->name }}</td>
                        <td>{{ $mark->subject }}</td>
                        <td>{{ $mark->marks }}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>


    </table>
    <h2>Students Marks</h2>
    @foreach($students as $student)
        <h4>{{ $student->name }}</h4>
        <ul>
            @foreach($student->marks as $mark)
                <li>{{ $mark->subject }}: {{ $mark->mark }} ({{ $mark->grade }})</li>
            @endforeach
        </ul>
    @endforeach
    <button onclick="window.print()">Print Report</button>

</div>
@endsection

    


