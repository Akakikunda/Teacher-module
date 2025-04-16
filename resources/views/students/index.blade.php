@extends('layouts.app') {{-- or use @extends('layouts.master') if your layout is named differently --}}

@section('content')
<div class="container">
    <h1>Registered Students</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Class</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
        @foreach($students as $student)
            <tr>
                <td>{{ $student->name }}</td>
                <td>{{ $student->class }}</td>
                <td>{{ $student->status }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
