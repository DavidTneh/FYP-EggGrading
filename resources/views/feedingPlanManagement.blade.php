@extends('/admin')

@section('title', 'Feeding Plans Management')

@section('content_header')
    <h1>Feeding Plans Management</h1>
@stop

@section('content')
<div class="container" style="width: 80%; margin-top: 20px;">
    <div class="row">
        <div class="col-md-12 mt-5">
            <h1 class="mt-5">Feeding Plans</h1>
            {{-- href="{{ route('Feeding-plans.create') }}" --}}
            <a  class="btn btn-success mb-3 float-right">Add New Feeding Plan</a>

            <!-- Feeding Plans List Table -->
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Time</th>
                        <th>Frequency</th>
                        <th>Repeat</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $FeedingPlans = [
                            ['id' => 1, 'time' => '09:00 AM', 'frequency' => 'Daily', 'repeat' => 'Yes'],
                            ['id' => 2, 'time' => '02:00 PM', 'frequency' => 'Weekly', 'repeat' => 'No'],
                            // Add more plans for pagination demonstration
                            ['id' => 3, 'time' => '06:00 AM', 'frequency' => 'Monthly', 'repeat' => 'Yes'],
                            ['id' => 4, 'time' => '08:00 PM', 'frequency' => 'Daily', 'repeat' => 'No'],
                        ];
                        $currentPage = 1;
                        $perPage = 2;
                        $total = count($FeedingPlans);
                        $pagination = array_slice($FeedingPlans, ($currentPage - 1) * $perPage, $perPage);
                    @endphp

                    @foreach($pagination as $plan)
                        <tr>
                            <td>{{ $plan['id'] }}</td>
                            <td>{{ $plan['time'] }}</td>
                            <td>{{ $plan['frequency'] }}</td>
                            <td>{{ $plan['repeat'] }}</td>
                            <td>
                                {{-- href="{{ route('Feeding-plans.edit', $plan['id']) }}" --}}
                                <a  class="btn btn-primary btn-sm">Edit</a>
                                {{-- action="{{ route('Feeding-plans.destroy', $plan['id']) }}" --}}
                                <form  method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this plan?')">Delete</button>
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
                                {{-- href="{{ route('Feeding-plans.index', ['page' => $currentPage - 1]) }}" --}}
                                <a class="page-link"  aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                        @endif

                        @for($i = 1; $i <= $totalPages; $i++)
                            <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                                {{-- href="{{ route('Feeding-plans.index', ['page' => $i]) }}" --}}
                                <a class="page-link" >{{ $i }}</a>
                            </li>
                        @endfor

                        @if($currentPage < $totalPages)
                            <li class="page-item">
                                {{-- href="{{ route('Feeding-plans.index', ['page' => $currentPage + 1]) }}" --}}
                                <a class="page-link"  aria-label="Next">
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
