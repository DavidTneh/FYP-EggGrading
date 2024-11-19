@extends('admin')

@section('title', 'Confirm Deletion')

@section('content_header')
<h1>Confirm Deletion</h1>
@stop

@section('content')
<div class="container" style="width: 80%; margin-top: 20px;">
    <div class="row">
        <div class="col-md-12 mt-5">
            <h1 class="mt-5">Confirm Deletion</h1>

            <div class="alert alert-danger">
                <strong>Warning!</strong> You are about to delete the cage and all its related data.
            </div>

            <!-- Cage Information -->
            <h3>Cage Information</h3>
            <table class="table">
                <tbody>
                    <tr>
                        <th>ID</th>
                        <td>{{ $cage->cageID }}</td>
                    </tr>
                    <tr>
                        <th>Name</th>
                        <td>{{ $cage->name }}</td>
                    </tr>
                    <tr>
                        <th>Size</th>
                        <td>{{ $cage->size }}</td>
                    </tr>
                    <tr>
                        <th>Capacity</th>
                        <td>{{ $cage->capacity }}</td>
                    </tr>
                    <tr>
                        <th>Type</th>
                        <td>{{ $cage->type }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>{{ $cage->status }}</td>
                    </tr>
                </tbody>
            </table>

            <!-- Related Chickens -->
            <h3>Related Chickens</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Chicken ID</th>
                        <th>Breed ID</th>
                        <th>Date of Birth</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($chickens as $chicken)
                    <tr>
                        <td>{{ $chicken->chickenID }}</td>
                        <td>{{ $chicken->breedID }}</td>
                        <td>{{ $chicken->dob }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Related Eggs -->
            <h3>Related Eggs</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Egg ID</th>
                        <th>Type</th>
                        <th>Grade</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($eggs as $egg)
                    <tr>
                        <td>{{ $egg->eggsID }}</td>
                        <td>{{ $egg->type }}</td>
                        <td>{{ $egg->eggGradeID }}</td>
                        <td>{{ $egg->description }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Related Vaccination Plans -->
            <h3>Related Vaccination Plans</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Plan ID</th>
                        <th>Type ID</th>
                        <th>Vaccination per Chicken</th>
                        <th>Total Required</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($vaccinationPlans as $plan)
                    <tr>
                        <td>{{ $plan->vaccinationplanID }}</td>
                        <td>{{ $plan->vaccinationtypeID }}</td>
                        <td>{{ $plan->vaccinationPerChicken }}</td>
                        <td>{{ $plan->totalVaccinationRequired }}</td>
                        <td>{{ $plan->date }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Related Cage Schedules -->
            <h3>Related Cage Schedules</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Schedule ID</th>
                        <th>Task ID</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cageSchedules as $schedule)
                    <tr>
                        <td>{{ $schedule->cageScheduleID }}</td>
                        <td>{{ $schedule->scheduleID }}</td>
                        <td>{{ $schedule->created_at }}</td>
                        <td>{{ $schedule->updated_at }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Delete Confirmation Form -->
            <form method="POST" action="{{ route('cages.destroy') }}">
                @csrf
                @method('DELETE')

                <input type="hidden" name="cageID" value="{{ $cage->cageID }}">

                <div class="form-group float-right">
                    <button type="submit" class="btn btn-danger">Delete</button>
                    <a href="{{ route('cages.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@stop