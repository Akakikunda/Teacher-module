<!--@extends('layouts.app')

@section('content')
<div class="content">
  <div class="row">
    <div class="col-md-8">
      <div class="card">
        <div class="card-header">
          <h5 class="title">Register Student</h5>
        </div>
        <div class="card-body">
          @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
          @endif

          <form method="POST" action="{{ route('students.store') }}">
            @csrf
            <div class="form-group">
              <label>Name</label>
              <input name="name" class="form-control" type="text" required>
            </div>
            <div class="form-group">
              <label>Class</label>
              <input name="class" class="form-control" type="text" required>
            </div>
            <div class="form-group">
              <label>Email</label>
              <input name="email" class="form-control" type="email" required>
            </div>
            <button type="submit" class="btn btn-primary">Register Student</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection-->
@extends('layouts.app')

@section('content')
<div class="content">
    <div class="row">
        <div class="col-md-8">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h5 class="title">Register Student</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('students.store') }}">
                        @csrf
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Student Name" required>
                        </div>

                        <div class="form-group">
                            <label>Class</label>
                            <input type="text" name="class" class="form-control" placeholder="Class" required>
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Student Email" required>
                        </div>

                        <button type="submit" class="btn btn-fill btn-primary">Register</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

