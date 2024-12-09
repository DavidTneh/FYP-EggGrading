@extends('/admin')

@section('title', 'Delete Feeding Plan')

@section('content_header')
<h1>Delete Feeding Plan</h1>
@stop

@section('content')
<div class="container" style="width: 80%; margin-top: 20px;">
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

    @if (session('status'))
    <div class="alert alert-success alert-dismissible">
        <h5><i class="icon fas fa-check"></i> Success!</h5>
        {{ session('status') }}
    </div>
    @endif

    <div class="alert alert-danger" role="alert">
        <strong>Are you sure you want to delete this feeding plan?</strong>
        <p>This will also delete all related tasks, assigned employees, and cage schedules associated with this plan.
        </p>
    </div>

    <dl class="row">
        <dt class="col-sm-3">Plan ID:</dt>
        <dd class="col-sm-9">{{ $plan->feedingplanID }}</dd>
        <dt class="col-sm-3">Time:</dt>
        <dd class="col-sm-9">{{ $plan->time }}</dd>
        <dt class="col-sm-3">Frequency:</dt>
        <dd class="col-sm-9">{{ $plan->frequency }}</dd>
        <dt class="col-sm-3">Repeat:</dt>
        <dd class="col-sm-9">{{ $plan->is_repeating ? 'Yes' : 'No' }}</dd>
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
        </div>
    </div>
    @endforeach

    <form action="{{ route('feedingplan.destroy') }}" method="POST">
        @csrf
        @method('DELETE')
        <input type="hidden" name="feedingplanID" value="{{ $plan->feedingplanID }}">
        <button type="submit" class="btn btn-danger float-right">Delete</button>
    </form>
</div>
@stop