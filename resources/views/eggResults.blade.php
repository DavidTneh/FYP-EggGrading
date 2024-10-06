@extends('/admin')

@section('title', 'Egg Grading Results')

@section('content_header')
<h1>Egg Grading Results</h1>
@stop

@section('content')
<div class="container" style="width: 80%; margin-top: 20px;">
    <div class="row">
        <div class="col-md-12 mt-5">
            <h1>Egg Grading Results</h1>

            <!-- Date Filter Form -->
            <div class="mb-4 d-flex justify-content-between align-items-center">
                <!-- Date Filter Form -->
                <form class="d-flex" method="GET">
                    <div class="form-row">
                        <div class="col">
                            <input type="date" name="start_date" class="form-control" placeholder="Start Date"
                                value="{{ request('start_date') }}">
                        </div>
                        <div class="col">
                            <input type="date" name="end_date" class="form-control" placeholder="End Date"
                                value="{{ request('end_date') }}">
                        </div>
                        <div class="col">
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </div>
                    </div>
                </form>

                <a href="{{ route('egg_grading.create') }}" class="btn btn-success">Add Eggs</a>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Description</th>
                        <th>Received Date</th>
                        <th>Last Updated</th>
                        <th>Grade</th>
                        <th>Estimated Weight Range</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($eggs as $egg)
                    <tr>
                        <td>{{ $egg->type }}</td>
                        <td>{{ $egg->description }}</td>
                        <td>{{ $egg->date }}</td>
                        <td>{{ $egg->updated_at }}</td>
                        <td>{{ $egg->eggGrade->grade ?? 'N/A' }}</td>
                        <td>{{ $egg->eggGrade->estimatedWeightRange }}</td>
                        <td>${{ number_format($egg->eggGrade->price, 2) }}</td>
                        <td>{{ $egg->quantity }}</td>
                        <td>
                            <div class="d-flex">
                                <a href="{{ route('egg_grading.batchEdit', ['created_at' => $egg->created_at->format('Y-m-d H:i:s'), 'type' => $egg->type, 'description' => $egg->description, 'eggGradeID' => $egg->eggGradeID]) }}"
                                    class="btn btn-primary mr-2">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('egg_grading.batchDelete') }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="created_at" value="{{ $egg->created_at }}">
                                    <input type="hidden" name="type" value="{{ $egg->type }}">
                                    <input type="hidden" name="description" value="{{ $egg->description }}">
                                    <input type="hidden" name="eggGradeID" value="{{ $egg->eggGradeID }}">
                                    <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center">No eggs found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            <nav aria-label="Page navigation example">
                {{ $eggs->links() }}
            </nav>

        </div>
    </div>
</div>
@stop