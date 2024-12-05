@extends('admin')

@section('content')
<div class="container">
    <h1>Vaccination Records Management</h1>

    <a href="{{ route('vaccination_records.create') }}" class="btn btn-success mb-3">Add Vaccination Record</a>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @foreach($vaccinationRecordsGrouped as $groupKey => $chickens)
    @php
    $firstChicken = $chickens->first(); // Get the first chicken in the group
    @endphp

    <h3>Cage: {{ $firstChicken->cage->name ?? 'Unknown Cage' }}</h3>
    <h4>Breed: {{ $firstChicken->breed->name ?? 'Unknown Breed' }}</h4>
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
            @foreach($chickens as $chicken)
            @foreach($chicken->vaccinationRecords as $record)
            <tr>
                <td>{{ optional($record->vaccinationplan->vaccinationType)->vaccineName ?? 'N/A' }}</td>
                <td>{{ $record->date_administered ?? 'N/A' }}</td>
                <td>{{ optional($record->user)->name ?? 'N/A' }}</td>
                <td>
                    {{ optional($record->vaccinationplan->vaccinationType)->methodConsume ?? 'N/A' }}
                    <ul>
                        <li>
                            {{ optional($record->vaccinationplan->vaccinationType)->criteria ?? 'N/A' }}
                        </li>
                        <li>
                            Vaccination Per Chicken: {{ $record->vaccinationplan->vaccinationPerChicken ?? 'N/A' }}
                        </li>
                    </ul>
                </td>
                <td>{{ $record->status ?? 'N/A' }}</td>
                <td>{{ $record->notes ?? 'N/A' }}</td>
                <td>
                    <!-- Upgrade Form -->
                    <form action="{{ route('vaccination_records.editGroup') }}" method="POST" style="display:inline;">
                        @csrf
                        @method('POST')
                        <input type="hidden" name="vaccinationRecordID" value="{{ $record->recordID }}">
                        <input type="hidden" name="cageID" value="{{ $firstChicken->cageID }}">
                        <input type="hidden" name="breedID" value="{{ $firstChicken->breedID }}">
                        {{-- <select name="new_breedID" class="form-select" required>
                            @foreach($breeds as $breed)
                            <option value="{{ $breed->breedID }}">{{ $breed->name }}</option>
                            @endforeach
                        </select> --}}
                        <button type="submit" class="btn btn-primary btn-sm">Upgrade</button>
                    </form>

                    <!-- Delete Form -->
                    <form action="{{ route('vaccination_records.deleteGroup') }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="vaccinationRecordID" value="{{ $record->recordID }}">
                        <input type="hidden" name="cageID" value="{{ $firstChicken->cageID }}">
                        <input type="hidden" name="breedID" value="{{ $firstChicken->breedID }}">
                        <button type="submit" class="btn btn-danger btn-sm"
                            onclick="return confirm('Are you sure you want to delete all vaccination records for this group?')">
                            Delete Group
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
            @endforeach
        </tbody>
    </table>
    @endforeach
</div>
@endsection