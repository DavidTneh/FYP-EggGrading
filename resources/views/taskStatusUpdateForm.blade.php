@extends('admin')

@section('title', 'Update Task Status')

@section('content_header')
<h1>Update Task Status</h1>
@stop

@section('content')
<div class="container mt-5">
    <h1>Update Task Status</h1>

    @if ($errors->any())
    <div class="alert alert-danger">
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

    <form method="POST" action="{{ route('employee.updateTaskStatus') }}">
        @csrf
        <input type="hidden" name="scheduleID" value="{{ $taskScheduling->scheduleID }}">
    
        <div class="form-group">
            <label for="taskName">Task Name</label>
            <input type="text" class="form-control" id="taskName" name="taskName" value="{{ $taskScheduling->taskName }}"
                readonly>
        </div>
    
        <div class="form-group">
            <label for="log_date">Date</label>
            <input type="date" class="form-control" id="log_date" name="log_date" required
                min="{{ now()->format('Y-m-d') }}">
        </div>
    
        <div class="form-group">
            <label for="collectionStatus">Collection Status</label>
            <select class="form-control" id="collectionStatus" name="collectionStatus">
                <option value="pending" {{ old('collectionStatus', 'pending' )=='pending' ? 'selected' : '' }}>Pending
                </option>
                <option value="in_progress" {{ old('collectionStatus')=='in_progress' ? 'selected' : '' }}>In Progress
                </option>
                <option value="completed" {{ old('collectionStatus')=='completed' ? 'selected' : '' }}>Completed</option>
            </select>
        </div>
    
        <div class="form-group">
            <label for="feedingStatus">Feeding Status</label>
            <select class="form-control" id="feedingStatus" name="feedingStatus">
                <option value="pending" {{ old('feedingStatus', 'pending' )=='pending' ? 'selected' : '' }}>Pending</option>
                <option value="in_progress" {{ old('feedingStatus')=='in_progress' ? 'selected' : '' }}>In Progress</option>
                <option value="completed" {{ old('feedingStatus')=='completed' ? 'selected' : '' }}>Completed</option>
            </select>
        </div>
    
        <div class="form-group">
            <label for="cullingStatus">Culling Status</label>
            <select class="form-control" id="cullingStatus" name="cullingStatus">
                <option value="pending" {{ old('cullingStatus', 'pending' )=='pending' ? 'selected' : '' }}>Pending</option>
                <option value="in_progress" {{ old('cullingStatus')=='in_progress' ? 'selected' : '' }}>In Progress</option>
                <option value="completed" {{ old('cullingStatus')=='completed' ? 'selected' : '' }}>Completed</option>
            </select>
        </div>
    
        <div class="form-group">
            <label for="status">Overall Task Status</label>
            <select class="form-control" id="status" name="status">
                <option value="pending" {{ old('status', 'pending' )=='pending' ? 'selected' : '' }}>Pending</option>
                <option value="in_progress" {{ old('status')=='in_progress' ? 'selected' : '' }}>In Progress</option>
                <option value="completed" {{ old('status')=='completed' ? 'selected' : '' }}>Completed</option>
            </select>
        </div>
    
        <button type="submit" class="btn btn-success">Update Task Status</button>
    </form>
</div>
@stop