@extends('admin')

@section('content')
<div class="container">
    <h1>Vaccination Records Management</h1>

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

    <a href="{{ route('vaccination_records.create') }}" class="btn btn-success mb-3">Add Vaccination Record</a>

    @foreach($vaccinationRecordsGrouped as $cageID => $breeds)
    @php
    $firstChickenInCage = $breeds->first()->first(); // Get the first chicken in the cage
    @endphp

    <h2>Cage: {{ $firstChickenInCage->cage->name ?? 'Unknown Cage' }}</h2>

    @foreach($breeds as $breedID => $chickens)
    @php
    $totalChickens = $chickens->count(); // Count chickens in this breed
    $firstChickenInBreed = $chickens->first(); // Get the first chicken in the breed

    // Group vaccination records by unique attributes
    $vaccinationPlans = $chickens->flatMap(function($chicken) {
    return $chicken->vaccinationRecords;
    })->groupBy(function($record) {
    return $record->vaccinationPlanID . '-' . $record->date_administered;
    });
    @endphp

    <h3>Breed: {{ $firstChickenInBreed->breed->name ?? 'Unknown Breed' }}</h3>
    <p><strong>Total Chickens:</strong> {{ $totalChickens }}</p>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Vaccination Plan</th>
                <th>Date Administered</th>
                <th>Administered By</th>
                <th>Instructions</th>
                <th>Status</th>
                <th>Notes</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($vaccinationPlans as $key => $records)
            @php
            $firstRecord = $records->first(); // Get the first record in the group
            @endphp
            <tr>
                <td>{{ optional($firstRecord->vaccinationplan->vaccinationType)->vaccineName ?? 'N/A' }}</td>
                <td>{{ $firstRecord->date_administered ?? 'N/A' }}</td>
                <td>{{ optional($firstRecord->user)->name ?? 'N/A' }}</td>
                <td>
                    {{ optional($firstRecord->vaccinationplan->vaccinationType)->methodConsume ?? 'N/A' }}
                    <ul>
                        <li>{{ optional($firstRecord->vaccinationplan->vaccinationType)->criteria ?? 'N/A' }}</li>
                        <li>Vaccination Per Chicken: {{ $firstRecord->vaccinationplan->vaccinationPerChicken ?? 'N/A' }}
                        </li>
                    </ul>
                </td>
                <td>{{ $firstRecord->status ?? 'N/A' }}</td>
                <td>{{ $firstRecord->notes ?? 'N/A' }}</td>
                <td>
                    <!-- Upgrade Form -->
                    <form action="{{ route('vaccination_records.editGroup') }}" method="POST" style="display:inline;">
                        @csrf
                        <input type="hidden" name="cageID" value="{{ $cageID }}">
                        <input type="hidden" name="breedID" value="{{ $breedID }}">
                        <input type="hidden" name="vaccinationPlanID" value="{{ $firstRecord->vaccinationPlanID }}">
                        <input type="hidden" name="date_administered" value="{{ $firstRecord->date_administered }}">
                        <button type="submit" class="btn btn-primary btn-sm">Upgrade</button>
                    </form>

                    <!-- Delete Form -->
                    <form action="{{ route('vaccination_records.deleteGroup') }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="cageID" value="{{ $cageID }}">
                        <input type="hidden" name="breedID" value="{{ $breedID }}">
                        <input type="hidden" name="vaccinationPlanID" value="{{ $firstRecord->vaccinationPlanID }}">
                        <input type="hidden" name="date_administered" value="{{ $firstRecord->date_administered }}">
                        <button type="submit" class="btn btn-danger btn-sm"
                            onclick="return confirm('Are you sure you want to delete all vaccination records for this group?')">
                            Delete Group
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endforeach
    @endforeach
</div>
@endsection