@extends('admin')

@section('title', 'Update Group of Chickens')

@section('content')
<div class="container">
    <h1>Update Group of Chickens</h1>
    <h3>Cage: {{ $cage->name }} | Breed: {{ $breed->name }}</h3>

    <!-- Chicken List Table -->
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>Chicken ID</th>
                <th>Date of Birth</th>
                <th>Cage</th>
                <th>Breed</th>
            </tr>
        </thead>
        <tbody>
            @foreach($chickens as $chicken)
            <tr>
                <td>{{ $chicken->chickenID }}</td>
                <td>{{ $chicken->dob }}</td>
                <td>{{ $chicken->cage->name }}</td>
                <td>{{ $chicken->breed->name }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Update Form -->
    <form method="POST"
        action="{{ route('chickens.updateGroup', ['cageID' => $cage->cageID, 'breedID' => $breed->breedID]) }}">
        @csrf
        @method('PUT')

        <input type="hidden" name="cageID" id="cageID" value="{{ $cage->cageID }}">
        <input type="hidden" name="breedID" id="breedID" value="{{ $breed->breedID }}">

        <div class="form-group">
            <label for="new_breedid">New Breed</label>
            <select name="new_breedid" class="form-control" required>
                @foreach($breeds as $breedOption)
                <option value="{{ $breedOption->breedID }}" {{ $breedOption->breedID == $breed->breedID ? 'selected' :
                    '' }}>
                    {{ $breedOption->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="new_dob">New Date of Birth</label>
            <input type="date" name="new_dob" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="new_cageid">New Cage</label>
            <select name="new_cageid" class="form-control" required>
                @foreach($cages as $cageOption)
                <option value="{{ $cageOption->cageID }}" {{ $cageOption->cageID == $cage->cageID ? 'selected' : '' }}>
                    {{ $cageOption->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="form-group d-flex">
            <button type="submit" class="btn btn-success mr-2">Update Group</button>
            <a href="{{ route('chickens.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@stop