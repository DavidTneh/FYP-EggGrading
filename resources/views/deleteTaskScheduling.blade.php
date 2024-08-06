@extends('/admin')

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
                    <p class="card-text"><strong>Task Name:</strong> {{ $taskScheduling->taskName ?? 'Daily Operation' }}</p>
                    <p class="card-text"><strong>Description:</strong> {{ $taskScheduling->taskDescription ?? 'Collect and Feeding daily operation' }}</p>
                    <p class="card-text"><strong>Collection Plan:</strong> {{ $taskScheduling->collectionPlan->name ?? '9am' }}</p>
                    <p class="card-text"><strong>Feeding Plan:</strong> {{ $taskScheduling->feedingPlan->name ?? '10am' }}</p>
                    <p class="card-text"><strong>Culling Plan:</strong> {{ $taskScheduling->cullingPlan->name ?? '24 weeks' }}</p>
                    <p class="card-text"><strong>Status:</strong> {{ $taskScheduling->status ?? 'Pending' }}</p>

                    <form action="#" method="POST" onsubmit="return confirm('Are you sure you want to delete this task scheduling? Once deleted, it cannot be recovered!');">
                        @csrf
                        @method('DELETE')
                        <div class="float-right">
                            <button type="submit" class="btn btn-danger">Delete</button>
                            <a href="#" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
