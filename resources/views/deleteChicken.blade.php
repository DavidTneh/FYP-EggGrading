@extends('admin')

@section('content')
<div class="container">
    <h1>Confirm Deletion</h1>
    @if ($errors->any())
    <div class="alert alert-danger alert-dismissible">
        <h5><i class="icon fas fa-ban"></i> Error!</h5>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if (session('status'))
    <div class="alert alert-success alert-dismissible">
        <h5><i class="icon fas fa-check"></i> Success!</h5>
        {{ session('status') }}
    </div>
    @endif
    <div class="alert alert-danger">
        <strong>Warning!</strong> You are about to delete a chicken.
    </div>
    <table class="table">
        <tr>
            <th>ID</th>
            <td>{{ $chicken->chickenID }}</td>
        </tr>
        <tr>
            <th>Breed</th>
            <td>{{ $chicken->breed->name }}</td>
        </tr>
        <tr>
            <th>Date of Birth</th>
            <td>{{ $chicken->dob }}</td>
        </tr>
        <tr>
            <th>Cage</th>
            <td>{{ $chicken->cage->name }}</td>
        </tr>
    </table>
    <form action="{{ route('chickens.destroy') }}" method="POST">
        @csrf
        @method('DELETE')
        <input type="hidden" name="chickenID[]" value="{{ $chicken->chickenID }}">
        <button type="submit" class="btn btn-danger">Delete Chicken</button>
        <a href="{{ route('chickens.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@stop