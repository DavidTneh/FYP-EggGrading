@extends('admin')

@section('content')
<div class="container">
    <h1>Update Vaccination Records</h1>

    @if (session('status'))
    <div class="alert alert-success alert-dismissible">
        <h5><i class="icon fas fa-check"></i> Success!</h5>
        {{ session('status') }}
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

    <form action="{{ route('vaccination_records.updateGroup') }}" method="POST">
        @csrf
        @method('PUT')

        <input type="hidden" name="cageID" value="{{ $cageID }}">
        <input type="hidden" name="breedID" value="{{ $breedID }}">

        <div class="mb-3">
            <label for="vaccinationplanID" class="form-label">Vaccination Plan</label>
            <select name="vaccinationplanID" id="vaccinationplanID" class="form-select" required>
                @foreach($vaccinationPlans as $plan)
                <option value="{{ $plan->vaccinationplanID }}">
                    {{ $plan->vaccinationType->vaccineName ?? 'N/A' }} - {{ $plan->date }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="new_breedID" class="form-label">New Breed</label>
            <select name="new_breedID" id="new_breedID" class="form-select" required>
                @foreach($breeds as $breed)
                <option value="{{ $breed->breedID }}" {{ $breed->breedID == $breedID ? 'selected' : '' }}>
                    {{ $breed->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-select" required>
                <option value="pending" selected>Pending</option>
                <option value="completed">Completed</option>
                <option value="in_progress">In Progress</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="notes" class="form-label">Notes</label>
            <textarea name="notes" id="notes" class="form-control"
                rows="3">{{ $vaccinationRecords->first()->notes ?? '' }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update Group</button>
        <a href="{{ route('vaccination_records.index') }}" class="btn btn-secondary">Cancel</a>
    </form>

    <h2 class="mt-5">Current Vaccination Records</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Chicken ID</th>
                <th>Vaccination Plan</th>
                <th>Date Administered</th>
                <th>Administered By</th>
                <th>Status</th>
                <th>Notes</th>
            </tr>
        </thead>
        <tbody>
            @foreach($vaccinationRecords as $record)
            <tr>
                <td>{{ $record->chicken->chickenID ?? 'N/A' }}</td>
                <td>{{ $record->vaccinationplan->vaccinationType->vaccineName ?? 'N/A' }}</td>
                <td>{{ $record->date_administered ?? 'N/A' }}</td>
                <td>{{ $record->user->name ?? 'N/A' }}</td>
                <td>{{ $record->status }}</td>
                <td>{{ $record->notes }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection