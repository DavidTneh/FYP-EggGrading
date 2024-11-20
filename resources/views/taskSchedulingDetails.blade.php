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
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title"><strong>{{ $taskScheduling->taskName }}</strong></h3>
                    <p class="card-text"><strong>Task Description:</strong> {{ $taskScheduling->taskDescription }}</p>
                    <p class="card-text"><strong>Status:</strong> {{ $taskScheduling->status }}</p>

                    <hr>
                    <h4>Plans Associated with the Task</h4>

                    <p class="card-text"><strong>Collection Plan:</strong></p>
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