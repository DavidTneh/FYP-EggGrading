@extends('admin')

@section('title', 'Task Schedulings Management')

@section('content_header')
<h1>Task Schedulings Management</h1>
@stop

@section('content')
<div class="container" style="width: 80%; margin-top: 20px;">
    <div class="row">
        <div class="col-md-12 mt-5">
            <h1 class="mt-5">Task Schedulings <i class="fas fa-tasks"></i></h1>

            <!-- Add New Task Scheduling Button -->
            <div class="mb-3 float-right">
                <a href="{{ route('task-schedulings.create') }}" class="btn btn-success">
                    <i class="fas fa-plus-circle"></i> Add New Task Scheduling
                </a>
            </div>

            <!-- Task Schedulings List Table -->
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Task ID</th>
                        <th>Task Name</th>
                        <th>Task Description</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($taskSchedulings as $task)
                    <tr>
                        <td>{{ $task->scheduleID }}</td>
                        <td>{{ $task->taskName }}</td>
                        <td>{{ $task->taskDescription }}</td>
                        <td>{{ $task->status }}</td>
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

                            <!-- Delete Button -->
                            <form action="{{ route('task-schedulings.showDelete') }}" method="POST"
                                style="display:inline;">
                                @csrf
                                <input type="hidden" name="scheduleID" value="{{ $task->scheduleID }}">
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure you want to delete this task?')">
                                    <i class="fas fa-trash-alt"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination Controls -->
            <div class="mt-3">
                {{ $taskSchedulings->links() }}
            </div>
        </div>
    </div>
</div>
@stop