@extends('admin')

@section('title', 'Edit Task Scheduling')

@section('content_header')
<h1>Edit Task Scheduling</h1>
@stop

@section('content')
<div class="container mt-5">
    <h1>Edit Task Scheduling</h1>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('task-schedulings.update') }}" method="POST">
        @csrf
        @method('PUT')

        <input type="hidden" name="scheduleID" value="{{ $taskScheduling->scheduleID }}">

        <div class="form-group">
            <label for="taskName">Task Name</label>
            <input type="text" class="form-control" id="taskName" name="taskName"
                value="{{ $taskScheduling->taskName }}" required>
        </div>

        <div class="form-group">
            <label for="taskDescription">Task Description</label>
            <textarea class="form-control" id="taskDescription" name="taskDescription"
                required>{{ $taskScheduling->taskDescription }}</textarea>
        </div>

        <div class="form-group">
            <label for="collectionPlanID">Collection Plan</label>
            <select class="form-control" id="collectionPlanID" name="collectionPlanID" required>
                @foreach($collectionPlans as $plan)
                <option value="{{ $plan->collectionplanID }}" {{ $taskScheduling->collectionplanID ==
                    $plan->collectionplanID ? 'selected' : '' }}>
                    {{ $plan->time }} - {{ $plan->frequency }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="feedingPlanID">Feeding Plan</label>
            <select class="form-control" id="feedingPlanID" name="feedingPlanID" required>
                @foreach($feedingPlans as $plan)
                <option value="{{ $plan->feedingplanID }}" {{ $taskScheduling->feedingplanID == $plan->feedingplanID ?
                    'selected' : '' }}>
                    {{ $plan->time }} - {{ $plan->frequency }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="cullingPlanID">Culling Plan</label>
            <select class="form-control" id="cullingPlanID" name="cullingPlanID" required>
                @foreach($cullingPlans as $plan)
                <option value="{{ $plan->cullingplanID }}" {{ $taskScheduling->cullingplanID == $plan->cullingplanID ?
                    'selected' : '' }}>
                    {{ $plan->eliminateAgeThreshold }} weeks - {{ $plan->reasons }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="assignedEmployees">Assigned Employees</label>
            <select class="form-control" id="assignedEmployees" name="assignedEmployees[]" multiple required>
                @foreach($employees as $employee)
                <option value="{{ $employee->userID }}" {{ in_array($employee->userID,
                    $taskScheduling->assignedEmployees->pluck('userID')->toArray()) ? 'selected' : '' }}>
                    {{ $employee->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="cageSchedules">Cages</label>
            <select class="form-control" id="cageSchedules" name="cageSchedules[]" multiple required>
                @foreach($cages as $cage)
                <option value="{{ $cage->cageID }}" {{ in_array($cage->cageID,
                    $taskScheduling->cageSchedules->pluck('cageID')->toArray()) ? 'selected' : '' }}>
                    {{ $cage->name }}
                </option>
                @endforeach
            </select>
        </div>

<div class="form-group">
    <label for="start_date">Start Date</label>
    <input type="date" class="form-control" id="start_date" name="start_date"
        value="{{ $taskScheduling->cageSchedules->first()->start_date ?? '' }}" min="{{ date('Y-m-d') }}" required>
</div>

<div class="form-group">
    <label for="end_date">End Date</label>
    <input type="date" class="form-control" id="end_date" name="end_date"
        value="{{ $taskScheduling->cageSchedules->first()->end_date ?? '' }}"
        min="{{ $taskScheduling->cageSchedules->first()->start_date ?? date('Y-m-d') }}" required>
</div>

        <div class="form-group">
            <label for="status">Status</label>
            <select class="form-control" id="status" name="status" required>
                <option value="Pending" {{ $taskScheduling->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                <option value="In Progress" {{ $taskScheduling->status == 'In Progress' ? 'selected' : '' }}>In Progress
                </option>
                <option value="Completed" {{ $taskScheduling->status == 'Completed' ? 'selected' : '' }}>Completed
                </option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update Task Scheduling</button>
    </form>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const startDateInput = document.getElementById("start_date");
        const endDateInput = document.getElementById("end_date");

        // Ensure the end date is always after or equal to the start date
        startDateInput.addEventListener("change", function () {
            endDateInput.min = startDateInput.value;
        });

        endDateInput.addEventListener("change", function () {
            if (new Date(endDateInput.value) < new Date(startDateInput.value)) {
                endDateInput.value = startDateInput.value;
            }
        });
    });
</script>

@stop