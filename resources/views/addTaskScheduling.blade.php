@extends('admin')

@section('title', 'Add Task Scheduling')

@section('content_header')
<h1>Add Task Scheduling</h1>
@stop

@section('content')
<div class="container mt-5">
    <h1>Add New Task Scheduling</h1>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('task-schedulings.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="taskName">Task Name</label>
            <input type="text" class="form-control" id="taskName" name="taskName" required>
        </div>

        <div class="form-group">
            <label for="taskDescription">Task Description</label>
            <textarea class="form-control" id="taskDescription" name="taskDescription" required></textarea>
        </div>

        <div class="form-group">
            <label for="collectionPlanID">Collection Plan</label>
            <select class="form-control" id="collectionPlanID" name="collectionPlanID" required>
                @foreach($collectionPlans as $plan)
                <option value="{{ $plan->collectionplanID }}">
                    {{ $plan->time }} - {{ $plan->frequency }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="feedingPlanID">Feeding Plan</label>
            <select class="form-control" id="feedingPlanID" name="feedingPlanID" required>
                @foreach($feedingPlans as $plan)
                <option value="{{ $plan->feedingplanID }}">
                    {{ $plan->time }} - {{ $plan->frequency }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="cullingPlanID">Culling Plan</label>
            <select class="form-control" id="cullingPlanID" name="cullingPlanID" required>
                @foreach($cullingPlans as $plan)
                <option value="{{ $plan->cullingplanID }}">
                    {{ $plan->eliminateAgeThreshold }} weeks - {{ $plan->reasons }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="assignedEmployees">Assigned Employees</label>
            <select class="form-control" id="assignedEmployees" name="assignedEmployees[]" multiple required>
                @foreach($employees as $employee)
                <option value="{{ $employee->userID }}">{{ $employee->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="cageSchedules">Cages</label>
            <select class="form-control" id="cageSchedules" name="cageSchedules[]" multiple required>
                @foreach($cages as $cage)
                <option value="{{ $cage->cageID }}">{{ $cage->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <select class="form-control" id="status" name="status" required>
                <option value="Pending">Pending</option>
                <option value="In Progress">In Progress</option>
                <option value="Completed">Completed</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Create Task Scheduling</button>
    </form>
</div>
@stop