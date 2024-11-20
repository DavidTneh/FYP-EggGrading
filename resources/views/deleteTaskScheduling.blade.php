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
                    <p class="card-text"><strong>Task Name:</strong> {{ $taskScheduling->taskName }}</p>
                    <p class="card-text"><strong>Description:</strong> {{ $taskScheduling->taskDescription }}</p>
                    <p class="card-text"><strong>Collection Plan:</strong>
                        {{ $collectionPlan->time ?? 'N/A' }} -
                        {{ $collectionPlan->frequency ?? 'N/A' }}
                        ({{ $collectionPlan->repeat ? 'Repeats' : 'One-time' }})
                    </p>
                    <p class="card-text"><strong>Feeding Plan:</strong>
                        {{ $feedingPlan->time ?? 'N/A' }} -
                        {{ $feedingPlan->frequency ?? 'N/A' }}
                        ({{ $feedingPlan->repeat ? 'Repeats' : 'One-time' }})
                    </p>
                    <p class="card-text"><strong>Culling Plan:</strong>
                        {{ $cullingPlan->eliminateAgeThreshold ?? 'N/A' }} weeks -
                        {{ $cullingPlan->healthStatus ?? 'N/A' }}
                        ({{ $cullingPlan->reasons ?? 'N/A' }})
                    </p>
                    <p class="card-text"><strong>Status:</strong> {{ $taskScheduling->status }}</p>

                    <form action="{{ route('task-schedulings.destroy') }}" method="POST"
                        onsubmit="return confirm('Are you sure you want to delete this task scheduling? Once deleted, it cannot be recovered!');">
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