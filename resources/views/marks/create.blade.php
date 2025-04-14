@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Enter Student Marks</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('marks.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="student_id">Select Student:</label>
            <select name="student_id" class="form-control">
                @foreach($students as $student)
                    <option value="{{ $student->id }}">{{ $student->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Subject:</label>
            <input type="text" name="subject" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Score:</label>
            <input type="number" name="score" class="form-control" max="100" required>
        </div>

        <button type="submit" class="btn btn-primary">Submit Mark</button>
    </form>
</div>
@endsection
