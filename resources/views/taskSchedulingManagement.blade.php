@extends('admin')

@section('title', 'Task Scheduling Management')

@section('content_header')
<h1>Task Scheduling Management</h1>
@stop

@section('content')
<div class="container mt-5">
    <h1>Task Schedulings</h1>
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

    <a href="{{ route('task-schedulings.create') }}" class="btn btn-success mb-3">
        <i class="fas fa-plus"></i> Add New Task Scheduling
    </a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Task Name</th>
                <th>Status</th>
                <th>Assigned Employees</th>
                <th>Cages</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($taskSchedulings as $task)
            <tr>
                <td>{{ $task->scheduleID }}</td>
                <td>{{ $task->taskName }}</td>
                <td>{{ $task->status }}</td>
                <td>
                    @foreach ($task->assignedEmployees as $employee)
                    {{ $employee->user->name ?? 'N/A' }},
                    @endforeach
                </td>
                <td>
                    @foreach ($task->cageSchedules as $cage)
                    {{ $cage->cage->name ?? 'N/A' }},
                    @endforeach
                </td>
                <td>
                    <!-- View Button -->
                    <form action="{{ route('task-schedulings.view') }}" method="POST" style="display:inline;">
                        @csrf
                        <input type="hidden" name="scheduleID" value="{{ $task->scheduleID }}">
                        <button type="submit" class="btn btn-secondary btn-sm">
                            <i class="fas fa-eye"></i> View
                        </button>
                    </form>

                    <!-- Edit Button -->
                    <form action="{{ route('task-schedulings.edit') }}" method="POST" style="display:inline;">
                        @csrf
                        <input type="hidden" name="scheduleID" value="{{ $task->scheduleID }}">
                        <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i>
                            Edit</button>
                    </form>
                    <form action="{{ route('task-schedulings.showDelete') }}" method="POST" class="d-inline"
                        onsubmit="return confirm('Are you sure?');">
                        @csrf
                        @method('POST')
                        <input type="hidden" name="scheduleID" value="{{ $task->scheduleID }}">
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $taskSchedulings->links() }}
</div>
@stop