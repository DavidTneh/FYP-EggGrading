@extends('admin')

@section('content')
<div class="container">
    <h1>Update Chicken</h1>
    <form method="POST" action="{{ route('chickens.update') }}">
        @csrf
        @method('PUT')
        <input type="hidden" name="chickenID" value="{{ $chicken->chickenID }}">

        <div class="form-group">
            <label for="breed">Breed</label>
            <select name="breedid" class="form-control" required>
                @foreach($breeds as $breed)
                <option value="{{ $breed->breedID }}" {{ $chicken->breedID == $breed->breedID ? 'selected' : '' }}>{{
                    $breed->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="dob">Date of Birth</label>
            <input type="date" name="dob" class="form-control" value="{{ $chicken->dob }}" required>
        </div>
        <div class="form-group">
            <label for="cage">Cage</label>
            <select name="cageid" class="form-control" required>
                @foreach($cages as $cage)
                <option value="{{ $cage->cageID }}" {{ $chicken->cageID == $cage->cageID ? 'selected' : '' }}>{{
                    $cage->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-success">Update Chicken</button>
    </form>
</div>
@stop