@extends('admin')

@section('title', 'Add Task Scheduling')

@section('content_header')
<h1>Add Task Scheduling</h1>
@stop

@section('content')
<div class="container" style="width: 80%; margin-top: 20px;">
    <div class="row">
        <div class="col-md-12 mt-5">
            <h1 class="mt-5">Add Task Scheduling <i class="fas fa-plus"></i></h1>

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
                            {{ $plan->frequency }} - {{ $plan->time }}
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
                            Age: {{ $plan->eliminateAgeThreshold }} weeks - Reason: {{ $plan->reasons }}
                        </option>
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

                <div class="float-right">
                    <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Save Task</button>
                    <a href="{{ route('task-schedulings.index') }}" class="btn btn-secondary"><i
                            class="fas fa-arrow-left"></i> Back</a>
                </div>
            </form>
        </div>
    </div>
</div>
@stop