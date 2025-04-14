<form action="{{ route('marks.update', $mark->id) }}" method="POST">
    @csrf
    @method('PUT')
    Subject: <input type="text" name="subject" value="{{ $mark->subject }}"><br>
    Mark: <input type="number" name="mark" value="{{ $mark->mark }}"><br>
    Grade:<p>Grade: <strong>{{ $mark->grade }}</strong></p>
    <button type="submit">Update</button>
</form>


