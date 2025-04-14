<!-- resources/views/assignments/create.blade.php -->

@extends('layouts.app') <!-- Extend the main layout -->

@section('content')
<div class="container">
    <h2>Create Assignment</h2>

    <!-- Display success message if assignment is created -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Form for creating an assignment -->
    <form action="{{ route('assignments.store') }}" method="POST">
        @csrf <!-- CSRF Token for security -->
        
        <div class="form-group">
            <label for="title">Assignment Title</label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control" required></textarea>
        </div>

        <div class="form-group">
            <label for="due_date">Due Date</label>
            <input type="date" name="due_date" id="due_date" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Create Assignment</button>
    </form>
</div>
@endsection
