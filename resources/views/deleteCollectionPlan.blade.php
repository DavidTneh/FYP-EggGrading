@extends('/admin')

@section('title', 'Delete Collection Plan')

@section('content_header')
<h1>Delete Collection Plan</h1>
@stop

@section('content')
<div class="container" style="width: 80%; margin-top: 20px;">
    <div class="row">
        <div class="col-md-12 mt-5">
            <h1 class="mt-5">Delete Collection Plan <i class="fas fa-trash-alt"></i></h1>

            <div class="alert alert-danger" role="alert">
                <strong>Are you sure you want to delete this collection plan?</strong>
                <p>This will also delete all related tasks, assigned employees, and cage schedules associated with this
                    plan.</p>
            </div>

            <dl class="row">
                <dt class="col-sm-3">Plan ID:</dt>
                <dd class="col-sm-9">{{ $plan->collectionplanID }}</dd>

                <dt class="col-sm-3">Time:</dt>
                <dd class="col-sm-9">{{ $plan->time }}</dd>

                <dt class="col-sm-3">Frequency:</dt>
                <dd class="col-sm-9">{{ $plan->frequency }}</dd>

                <dt class="col-sm-3">Repeat:</dt>
                <dd class="col-sm-9">{{ $plan->repeat ? 'Yes' : 'No' }}</dd>
            </dl>

            <h3>Related Tasks and Data to be Deleted:</h3>

            @foreach ($tasks as $task)
            <div class="card mb-3">
                <div class="card-header">
                    <strong>Task ID:</strong> {{ $task->scheduleID }} - {{ $task->taskName }}
                </div>
                <div class="card-body">
                    <p><strong>Description:</strong> {{ $task->taskDescription }}</p>
                    <p><strong>Status:</strong> {{ $task->status }}</p>

                    <h5>Assigned Employees:</h5>
                    <ul>
                        @foreach ($relatedData[$loop->index]['assignedEmployees'] as $employee)
                        <li>{{ $employee->userID }}</li>
                        @endforeach
                    </ul>

                    <h5>Cage Schedules:</h5>
                    <ul>
                        @foreach ($relatedData[$loop->index]['cageSchedules'] as $cageSchedule)
                        <li>Cage ID: {{ $cageSchedule->cageID }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endforeach

            <form action="{{ route('collectionplan.destroy', $plan->collectionplanID) }}" method="POST">
                @csrf
                @method('DELETE')

                <!-- Hidden field to pass the collection plan ID -->
                <input type="hidden" name="collectionplanID" value="{{ $plan->collectionplanID }}">

                <div class="float-right">
                    <button type="submit" class="btn btn-danger"
                        onclick="return confirm('Are you sure you want to delete this plan and all related data?')">Delete</button>
                    <a href="{{ route('collectionplan.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@stop