@extends('/admin')

@section('title', 'Culling Plans Management')

@section('content_header')
    <h1>Culling Plans Management</h1>
@stop

@section('content')
<div class="container" style="width: 80%; margin-top: 20px;">
    <div class="row">
        <div class="col-md-12 mt-5">
            <h1 class="mt-5">Culling Plans</h1>
            {{-- href="{{ route('culling-plans.create') }}" --}}
            <a  class="btn btn-success mb-3 float-right">Add New Culling Plan</a>

            <!-- Culling Plans List Table -->
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Eliminate Age Threshold</th>
                        <th>Reasons</th>
                        <th>Health Status</th>
                        <th>Notes</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $cullingPlans = [
                            ['id' => 1, 'eliminateAgeThreshold' => '24 weeks', 'reasons' => 'Low productivity', 'healthStatus' => 'Poor', 'notes' => 'Monitor regularly'],
                            ['id' => 2, 'eliminateAgeThreshold' => '18 weeks', 'reasons' => 'Infection', 'healthStatus' => 'Fair', 'notes' => 'Immediate action required'],
                            // Add more plans for pagination demonstration
                            ['id' => 3, 'eliminateAgeThreshold' => '30 weeks', 'reasons' => 'Behavioral issues', 'healthStatus' => 'Good', 'notes' => 'Reevaluate in 2 weeks'],
                            ['id' => 4, 'eliminateAgeThreshold' => '20 weeks', 'reasons' => 'Overcrowding', 'healthStatus' => 'Poor', 'notes' => 'Consider increasing space'],
                        ];
                        $currentPage = 1;
                        $perPage = 2;
                        $total = count($cullingPlans);
                        $pagination = array_slice($cullingPlans, ($currentPage - 1) * $perPage, $perPage);
                    @endphp

                    @foreach($pagination as $plan)
                        <tr>
                            <td>{{ $plan['id'] }}</td>
                            <td>{{ $plan['eliminateAgeThreshold'] }}</td>
                            <td>{{ $plan['reasons'] }}</td>
                            <td>{{ $plan['healthStatus'] }}</td>
                            <td>{{ $plan['notes'] }}</td>
                            <td>
                                {{-- href="{{ route('culling-plans.edit', $plan['id']) }}"  --}}
                                <a class="btn btn-primary btn-sm">Edit</a>
                                {{-- action="{{ route('culling-plans.destroy', $plan['id']) }}" --}}
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
                                {{-- href="{{ route('culling-plans.index', ['page' => $currentPage - 1]) }}" --}}
                                <a class="page-link"  aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                        @endif

                        @for($i = 1; $i <= $totalPages; $i++)
                            <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                                {{-- href="{{ route('culling-plans.index', ['page' => $i]) }}" --}}
                                <a class="page-link" >{{ $i }}</a>
                            </li>
                        @endfor

                        @if($currentPage < $totalPages)
                            <li class="page-item">
                                {{-- href="{{ route('culling-plans.index', ['page' => $currentPage + 1]) }}" --}}
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
