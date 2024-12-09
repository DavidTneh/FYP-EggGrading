@extends('admin')

@section('title', 'Update Vaccination Group Status')

@section('content')
<div class="container mt-5">
    <h1>Update Vaccination Records for Group</h1>

    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

    <form method="POST" action="{{ route('employee.updateVaccinationGroupStatus') }}">
        @csrf
        <input type="hidden" name="cageID" value="{{ $cage->cageID }}">
        <input type="hidden" name="breedID" value="{{ $breed->breedID }}">
        <input type="hidden" name="vaccinationplanID" value="{{ $vaccinationPlan->vaccinationplanID }}">
        <input type="hidden" name="date_administered" value="{{ $vaccinationRecords->first()->date_administered }}">

        <h3>Group Details</h3>
        <p><strong>Cage:</strong> {{ $cage->name }}</p>
        <p><strong>Breed:</strong> {{ $breed->name }}</p>
        <p><strong>Vaccination Plan:</strong> {{ $vaccinationPlan->vaccinationType->vaccineName }}</p>
        <p><strong>Date Administered:</strong> {{ $vaccinationRecords->first()->date_administered }}</p>

        <div class="form-group mt-4">
            <label for="status">Group Status</label>
            <select name="status" id="status" class="form-control" required>
                <option value="pending" selected>Pending</option>
                <option value="completed">Completed</option>
                <option value="skipped">Skipped</option>
            </select>
        </div>

        <div class="form-group mt-3">
            <label for="notes">Notes</label>
            <textarea name="notes" id="notes" class="form-control" rows="4"
                placeholder="Add notes for this vaccination group"></textarea>
        </div>

        <button type="submit" class="btn btn-success mt-4">Update Group Status</button>
        <a href="{{ route('employee.listAssignedTasks') }}" class="btn btn-secondary mt-4">Cancel</a>
    </form>
</div>
@endsection