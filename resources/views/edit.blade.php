<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Edit Subject</title>
</head>
<body>
    <h1>Edit Subject</h1>

    <!-- Error Message -->
    @if (session('error'))
        <div style="color: red;">
            {{ session('error') }}
        </div>
    @endif

    <!-- Edit Form -->
    <form action="{{ url('/home/update/' . $subject->code) }}" method="POST">
        @csrf
        <p>Subject Code:<br><input type="text" name="code" value="{{ $subject->code }}" size="20"></p>
        <p>Title:<br><input type="text" name="title" value="{{ $subject->title }}" size="20"></p>
        <p>Credit Value:<br><input type="text" name="credit" value="{{ $subject->credit }}" size="20"></p>
        <p>Year of Study:<br><input type="text" name="year" value="{{ $subject->yearOfStudy }}" size="20"></p>
        <input type="submit" value="Update" name="Update">
    </form>
</body>
</html>
