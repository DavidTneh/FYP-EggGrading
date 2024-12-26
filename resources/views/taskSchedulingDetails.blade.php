@extends('admin')

@section('title', 'Task Scheduling Details')

@section('content_header')
<h1>Task Scheduling Details</h1>
@stop

@section('content')
<div class="container" style="width: 80%; margin-top: 20px;">
    <div class="row">
        <div class="col-md-12 mt-5">
            <h1>Task Scheduling Details <i class="fas fa-info-circle"></i></h1>
            @if ($errors->any())
            <div class="alert alert-danger alert-dismissible">
                <h5><i class="icon fas fa-ban"></i> Error!</h5>
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            <div class="card">
                <div class="card-body">
                    <h3 class="card-title"><strong>{{ $taskScheduling->taskName }}</strong></h3>
                    <p class="card-text"><strong>Task Description:</strong> {{ $taskScheduling->taskDescription }}</p>
                    <p class="card-text"><strong>Status:</strong> {{ $taskScheduling->status }}</p>

                    <p class="card-text"><strong>Task Duration:</strong></p>
                    @if ($cageSchedules->isNotEmpty())
                    <ul>
                        @foreach ($cageSchedules as $cageSchedule)
                        <li>
                            <strong>Cage:</strong> {{ $cageSchedule->cageName }}<br>
                            <!-- Use cageName instead of name -->
                            <strong>Start Date:</strong> {{ $cageSchedule->start_date }}<br>
                            <strong>End Date:</strong> {{ $cageSchedule->end_date }}
                        </li>
                        @endforeach
                    </ul>
                    @else
                    <p class="text-muted">No cage schedules assigned.</p>
                    @endif

                    <hr>
                    <!-- Assigned Employees -->
                    <h4>Assigned Employees</h4>
                    @if ($assignedEmployees->isNotEmpty())
                    <ul>
                        @foreach ($assignedEmployees as $employee)
                        <li><strong>Name:</strong> {{ $employee->name }}</li>
                        @endforeach
                    </ul>
                    @else
                    <p class="text-muted">No employees assigned to this task.</p>
                    @endif

                    <hr>
                    <h4>Plans Associated with the Task</h4>

                    <p class="card-text"><strong>Egg Collection Plan:</strong></p>
                    @if ($collectionPlan)
                    <ul>
                        <li><strong>Time:</strong> {{ $collectionPlan->time }}</li>
                        <li><strong>Frequency:</strong> {{ $collectionPlan->frequency }}</li>
                        <li><strong>Repeat:</strong> {{ $collectionPlan->repeat ? 'Yes' : 'No' }}</li>
                    </ul>
                    @else
                    <p class="text-muted">No collection plan assigned.</p>
                    @endif

                    <p class="card-text"><strong>Feeding Plan:</strong></p>
                    @if ($feedingPlan)
                    <ul>
                        <li><strong>Time:</strong> {{ $feedingPlan->time }}</li>
                        <li><strong>Frequency:</strong> {{ $feedingPlan->frequency }}</li>
                        <li><strong>Repeat:</strong> {{ $feedingPlan->repeat ? 'Yes' : 'No' }}</li>
                    </ul>
                    @else
                    <p class="text-muted">No feeding plan assigned.</p>
                    @endif

                    <p class="card-text"><strong>Culling Plan:</strong></p>
                    @if ($cullingPlan)
                    <ul>
                        <li><strong>Eliminate Age Threshold:</strong> {{ $cullingPlan->eliminateAgeThreshold }} weeks
                        </li>
                        <li><strong>Health Status:</strong> {{ $cullingPlan->healthStatus }}</li>
                        <li><strong>Reasons:</strong> {{ $cullingPlan->reasons }}</li>
                    </ul>
                    @else
                    <p class="text-muted">No culling plan assigned.</p>
                    @endif

                    <hr>
                    <h4>Task Metadata</h4>
                    <p class="card-text"><strong>Created At:</strong> {{ $taskScheduling->created_at }}</p>
                    <p class="card-text"><strong>Last Updated At:</strong> {{ $taskScheduling->updated_at }}</p>

                    <hr>
                    <div class="float-right">
                        <a href="{{ route('task-schedulings.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                        <form action="{{ route('task-schedulings.showDelete') }}" method="POST"
                            style="display: inline-block;">
                            @csrf
                            <input type="hidden" name="scheduleID" value="{{ $taskScheduling->scheduleID }}">
                            <button type="submit" class="btn btn-danger"
                                onclick="return confirm('Are you sure you want to delete this task?')">
                                <i class="fas fa-trash-alt"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop