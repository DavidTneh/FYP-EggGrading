<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Home</title>
</head>
<body>
    <h1>Home Page</h1>

    <!-- Success Message -->
    @if (session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
    @endif

    <!-- Display Subjects -->
    <h2>Subjects List</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Subject Code</th>
                <th>Title</th>
                <th>Credit Value</th>
                <th>Year of Study</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($subjects as $subject)
                <tr>
                    <td>{{ $subject->code }}</td>
                    <td>{{ $subject->title }}</td>
                    <td>{{ $subject->credit }}</td>
                    <td>{{ $subject->yearOfStudy }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No subjects found</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>
