@extends('/admin')

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
                {{-- href="{{ route('task-schedulings.create') }}" --}}
                <a  class="btn btn-success"><i class="fas fa-plus-circle"></i> Add New Task Scheduling</a>
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
                    @php
                        $taskSchedulings = [
                            ['id' => 1, 'taskName' => 'Task A', 'taskDescription' => 'Description A', 'status' => 'Pending'],
                            ['id' => 2, 'taskName' => 'Task B', 'taskDescription' => 'Description B', 'status' => 'Completed'],
                            // Add more tasks for pagination demonstration
                            ['id' => 3, 'taskName' => 'Task C', 'taskDescription' => 'Description C', 'status' => 'In Progress'],
                            ['id' => 4, 'taskName' => 'Task D', 'taskDescription' => 'Description D', 'status' => 'Pending'],
                            // ... More items for paging demonstration
                        ];
                        $currentPage = 1;
                        $perPage = 2;
                        $total = count($taskSchedulings);
                        $pagination = array_slice($taskSchedulings, ($currentPage - 1) * $perPage, $perPage);
                    @endphp

                    @foreach($pagination as $task)
                        <tr>
                            <td>{{ $task['id'] }}</td>
                            <td>{{ $task['taskName'] }}</td>
                            <td>{{ $task['taskDescription'] }}</td>
                            <td>{{ $task['status'] }}</td>
                            <td>
                                {{-- href="{{ route('task-schedulings.edit', $task['id']) }}" --}}
                                <a  class="btn btn-secondary btn-sm"><i class="fas fa-eye"></i> View</a>
                                <a  class="btn btn-primary btn-sm"><i class="fas fa-edit"></i> Edit</a>
                                {{-- action="{{ route('task-schedulings.destroy', $task['id']) }}" --}}
                                <form  method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this task?')"><i class="fas fa-trash-alt"></i> Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination Controls -->
            <div class="mt-3">
                @php
                    $totalPages = ceil($total / $perPage);
                @endphp

                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        @if($currentPage > 1)
                            <li class="page-item">
                                {{-- href="{{ route('task-schedulings.index', ['page' => $currentPage - 1]) }}" --}}
                                <a  class="page-link" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                        @endif

                        @for($i = 1; $i <= $totalPages; $i++)
                            <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                                {{-- href="{{ route('task-schedulings.index', ['page' => $i]) }}" --}}
                                <a  class="page-link">{{ $i }}</a>
                            </li>
                        @endfor

                        @if($currentPage < $totalPages)
                            <li class="page-item">
                                {{-- href="{{ route('task-schedulings.index', ['page' => $currentPage + 1]) }}" --}}
                                <a  class="page-link" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
@stop
