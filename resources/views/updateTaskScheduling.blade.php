@extends('/admin')

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
            {{-- action="{{ route('task-schedulings.update', 1) }}" --}}
            <form  method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label for="taskName">Task Name</label>
                    <input type="text" class="form-control" id="taskName" name="taskName" value="Hardcoded Task Name" required>
                </div>

                <div class="form-group">
                    <label for="taskDescription">Task Description</label>
                    <textarea class="form-control" id="taskDescription" name="taskDescription" required>Hardcoded Task Description</textarea>
                </div>

                <div class="form-group">
                    <label for="collectionPlanID">Collection Plan</label>
                    <select class="form-control" id="collectionPlanID" name="collectionPlanID">
                        <option value="1" selected>Plan 1 - Morning, Daily</option>
                        <option value="2">Plan 2 - Afternoon, Weekly</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="feedingPlanID">Feeding Plan</label>
                    <select class="form-control" id="feedingPlanID" name="feedingPlanID">
                        <option value="1" selected>Plan 1 - Morning, Daily</option>
                        <option value="2">Plan 2 - Evening, Weekly</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="cullingPlanID">Culling Plan</label>
                    <select class="form-control" id="cullingPlanID" name="cullingPlanID">
                        <option value="1" selected>Plan 1 - Age: 6 months, Reason: Disease</option>
                        <option value="2">Plan 2 - Age: 1 year, Reason: Low Production</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="Pending" selected>Pending</option>
                        <option value="In Progress">In Progress</option>
                        <option value="Completed">Completed</option>
                    </select>
                </div>
                <div class="float-right">
                <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Update Task</button>
                <a  class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back</a>
                {{-- href="{{ route('task-schedulings.index') }}" --}}
            </div>
            </form>
        </div>
    </div>
</div>
@stop
