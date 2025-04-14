<!-- resources/views/messages/index.blade.php -->

@extends('layouts.app') <!-- Extend the main layout -->

@section('content')
<div class="container">
    <h2>Communicate with Parents or Headteachers</h2>

    <!-- Display success message if message is sent -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Form to send a new message -->
    <form action="{{ route('messages.send') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="recipient_id">Recipient</label>
            <select name="recipient_id" id="recipient_id" class="form-control" required>
                <!-- Assuming you have a list of users (teachers, parents, headteachers) to populate -->
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="message">Message</label>
            <textarea name="message" id="message" class="form-control" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Send Message</button>
    </form>

    <h3>Sent Messages</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Recipient</th>
                <th>Message</th>
                <th>Sent At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($messages as $message)
                <tr>
                    <td>{{ $message->recipient->name }}</td>
                    <td>{{ $message->message }}</td>
                    <td>{{ $message->created_at->format('d-m-Y H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
