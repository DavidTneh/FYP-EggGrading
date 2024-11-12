@extends('admin')

@section('content')
<div class="container">
    <h1>Chickens in Cage: {{ $cage->name }} | Breed: {{ $breed->name }}</h1>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Chicken ID</th>
                <th>Date of Birth</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($chickens as $chicken)
            <tr>
                <td>{{ $chicken->chickenID }}</td>
                <td>{{ $chicken->dob }}</td>
                <td>
                    <form action="{{ route('chickens.edit') }}" method="POST" style="display:inline;">
                        @csrf
                        @method('POST')
                        <input type="hidden" name="chickenID" value="{{ $chicken->chickenID }}">
                        <button type="submit" class="btn btn-primary btn-sm">Edit</button>
                    </form>

                    <form action="{{ route('chickens.destroy') }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="chickenID" value="{{ $chicken->chickenID }}">
                        <button type="submit" class="btn btn-danger btn-sm"
                            onclick="return confirm('Are you sure you want to delete this chicken?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('chickens.index') }}" class="btn btn-secondary mt-3">Back to Chicken Management</a>
</div>
@stop