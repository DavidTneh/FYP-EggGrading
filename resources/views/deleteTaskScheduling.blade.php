@extends('admin')

@section('title', 'Delete Task Scheduling')

@section('content_header')
<h1>Delete Task Scheduling</h1>
@stop

@section('content')
<div class="container" style="width: 80%; margin-top: 20px;">
    <div class="row">
        <div class="col-md-12 mt-5">
            <h1>Delete Task Scheduling <i class="fas fa-trash-alt"></i></h1>
            <div class="alert alert-danger" role="alert">
                <strong>Are you sure you want to delete this task scheduling?</strong>
            </div>
            <div class="card">
                <div class="card-body">
                    <!-- Task Details -->
                    <p class="card-text"><strong>Task Name:</strong> {{ $taskScheduling->taskName }}</p>
                    <p class="card-text"><strong>Description:</strong> {{ $taskScheduling->taskDescription }}</p>

                    <!-- Assigned Employees -->
                    <h4>Assigned Employees:</h4>
                    @if($assignedEmployees->isNotEmpty())
                    <ul>
                        @foreach($assignedEmployees as $employee)
                        <li>{{ $employee->name ?? 'Unknown' }} ({{ $employee->email ?? 'No email' }})</li>
                        @endforeach
                    </ul>
                    @else
                    <p class="text-muted">No employees assigned.</p>
                    @endif

                    <!-- Cages -->
                    <h4>Related Cages:</h4>
                    @if($cageSchedules->isNotEmpty())
                    <ul>
                        @foreach($cageSchedules as $cage)
                        <li>{{ $cage->name ?? 'Unknown' }} - {{ $cage->size ?? 'Unknown' }} (Capacity: {{
                            $cage->capacity ??
                            'Unknown' }})</li>
                        @endforeach
                    </ul>
                    @else
                    <p class="text-muted">No cages assigned.</p>
                    @endif

                    <!-- Related Plans -->
                    <h4>Collection Plan:</h4>
                    <p>{{ $collectionPlan->time ?? 'N/A' }} - {{ $collectionPlan->frequency ?? 'N/A' }}</p>

                    <h4>Feeding Plan:</h4>
                    <p>{{ $feedingPlan->time ?? 'N/A' }} - {{ $feedingPlan->frequency ?? 'N/A' }}</p>

                    <h4>Culling Plan:</h4>
                    <p>{{ $cullingPlan->eliminateAgeThreshold ?? 'N/A' }} weeks - {{ $cullingPlan->healthStatus ?? 'N/A'
                        }}</p>

                    <!-- Actions -->
                    <form action="{{ route('task-schedulings.destroy') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="scheduleID" value="{{ $taskScheduling->scheduleID }}">
                        <div class="float-right">
                            <button type="submit" class="btn btn-danger">Delete</button>
                            <a href="{{ route('task-schedulings.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop