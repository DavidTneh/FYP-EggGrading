@extends('admin')

@section('title', 'Edit Task Scheduling')

@section('content_header')
<h1>Edit Task Scheduling</h1>
@stop

@section('content')
<div class="container" style="width: 80%; margin-top: 20px;">
    <div class="row">
        <div class="col-md-12 mt-5">
            <h1 class="mt-5">Edit Task Scheduling <i class="fas fa-edit"></i></h1>

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
                        <option value="{{ $plan->collectionplanID }}" {{ $taskScheduling->collectionPlanID ==
                            $plan->collectionplanID ? 'selected' : '' }}>
                            {{ $plan->time }} - {{ $plan->frequency }} ({{ $plan->repeat ? 'Repeats' : 'One-time' }})
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="feedingPlanID">Feeding Plan</label>
                    <select class="form-control" id="feedingPlanID" name="feedingPlanID" required>
                        @foreach($feedingPlans as $plan)
                        <option value="{{ $plan->feedingplanID }}" {{ $taskScheduling->feedingPlanID ==
                            $plan->feedingplanID ? 'selected' : '' }}>
                            {{ $plan->time }} - {{ $plan->frequency }} ({{ $plan->repeat ? 'Repeats' : 'One-time' }})
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="cullingPlanID">Culling Plan</label>
                    <select class="form-control" id="cullingPlanID" name="cullingPlanID" required>
                        @foreach($cullingPlans as $plan)
                        <option value="{{ $plan->cullingplanID }}" {{ $taskScheduling->cullingPlanID ==
                            $plan->cullingplanID ? 'selected' : '' }}>
                            {{ $plan->eliminateAgeThreshold }} weeks - {{ $plan->healthStatus }} ({{ $plan->reasons }})
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="Pending" {{ $taskScheduling->status == 'Pending' ? 'selected' : '' }}>Pending
                        </option>
                        <option value="In Progress" {{ $taskScheduling->status == 'In Progress' ? 'selected' : '' }}>In
                            Progress</option>
                        <option value="Completed" {{ $taskScheduling->status == 'Completed' ? 'selected' : ''
                            }}>Completed</option>
                    </select>
                </div>

                <div class="float-right">
                    <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Update Task</button>
                    <a href="{{ route('task-schedulings.index') }}" class="btn btn-secondary"><i
                            class="fas fa-arrow-left"></i> Back</a>
                </div>
            </form>
        </div>
    </div>
</div>
@stop