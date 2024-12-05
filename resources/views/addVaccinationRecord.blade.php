@extends('admin')

@section('content')
<div class="container">
    <h1>Add Vaccination Records for a Group</h1>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('vaccination_records.store') }}" method="POST">
        @csrf

        <!-- Cage Dropdown -->
        <div class="form-group">
            <label for="cageID">Cage</label>
            <select name="cageID" id="cageID" class="form-control" required>
                <option value="" disabled selected>Select Cage</option>
                @foreach($cages as $cage)
                <option value="{{ $cage->cageID }}">{{ $cage->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Breed Dropdown (Filtered Dynamically) -->
        <div class="form-group">
            <label for="breedID">Breed</label>
            <select name="breedID" id="breedID" class="form-control" required>
                <option value="" disabled selected>Select Breed</option>
            </select>
        </div>

        <!-- Vaccination Plan Dropdown -->
        <div class="form-group">
            <label for="vaccinationplanID">Vaccination Plan</label>
            <select name="vaccinationplanID" id="vaccinationplanID" class="form-control" required>
                <option value="" disabled selected>Select Vaccination Plan</option>
                @foreach($vaccinationPlans as $plan)
                <option value="{{ $plan->vaccinationplanID }}">{{ $plan->vaccinationType->vaccineName ?? 'N/A' }}
                </option>
                @endforeach
            </select>
        </div>

        <!-- Administered By Dropdown -->
        <div class="form-group">
            <label for="administered_by">Administered By</label>
            <select name="administered_by" id="administered_by" class="form-control" required>
                <option value="" disabled selected>Select Admin</option>
                @foreach($employees as $employee)
                <option value="{{ $employee->userID }}">{{ $employee->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Status Dropdown -->
        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control" required>
                <option value="pending">Pending</option>
                <option value="completed">Completed</option>
                <option value="skipped">Skipped</option>
            </select>
        </div>

        <!-- Notes -->
        <div class="form-group">
            <label for="notes">Notes</label>
            <textarea name="notes" id="notes" class="form-control" rows="4"
                placeholder="Optional notes about the vaccination"></textarea>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">Add Records</button>
        <a href="{{ route('vaccination_records.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<!-- JavaScript for Dynamic Dropdown -->
<script>
    document.getElementById('cageID').addEventListener('change', function () {
        const selectedCageID = this.value;
        const breedSelect = document.getElementById('breedID');

        // Clear existing options
        breedSelect.innerHTML = '<option value="" disabled selected>Select Breed</option>';

        // Fetch breeds associated with the selected cage
        @foreach($cages as $cage)
        if (selectedCageID == '{{ $cage->cageID }}') {
            @foreach($cage->chickens as $chicken)
            breedSelect.innerHTML += `<option value="{{ $chicken->breed->breedID }}">{{ $chicken->breed->name }}</option>`;
            @endforeach
        }
        @endforeach
    });
</script>
@endsection