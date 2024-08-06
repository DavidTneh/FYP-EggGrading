@extends('/admin')

@section('title', 'Chicken Management')

@section('content_header')
    <h1>Chicken Management</h1>
@stop

@section('content')
<div class="container" style="width: 80%; margin-top: 20px;">
    <div class="row">
        <div class="col-md-12 mt-5">
            <i class="fas fa-10x fa-chicken"></i>
            <h1 class="mt-5">Chicken Management</h1>
            
            <!-- Add New Chicken Button -->
            <div class="mb-3">
                <a href="#" class="btn btn-success float-right">Add New Chicken</a>
            </div>
            
            <!-- Chicken List Table -->
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Chicken ID</th>
                        <th>Breed</th>
                        <th>Date of Birth</th>
                        <th>Cage ID</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Hard-coded data -->
                    @php
                        $chickens = [
                            ['id' => 1, 'breedid' => 1, 'dob' => '2023-01-15', 'cageid' => 1],
                            ['id' => 2, 'breedid' => 2, 'dob' => '2023-02-10', 'cageid' => 2],
                            ['id' => 3, 'breedid' => 1, 'dob' => '2023-03-05', 'cageid' => 1],
                            ['id' => 4, 'breedid' => 3, 'dob' => '2023-04-20', 'cageid' => 3],
                            ['id' => 5, 'breedid' => 2, 'dob' => '2023-05-15', 'cageid' => 2],
                            ['id' => 6, 'breedid' => 1, 'dob' => '2023-06-10', 'cageid' => 1],
                            // Add more as needed
                        ];

                        $breeds = [
                            ['id' => 1, 'name' => 'Rhode Island Red'],
                            ['id' => 2, 'name' => 'Leghorn'],
                            ['id' => 3, 'name' => 'Plymouth Rock'],
                        ];

                        // Pagination variables
                        $currentPage = 1; // Example: current page
                        $perPage = 5; // Items per page
                        $total = count($chickens);
                        $totalPages = ceil($total / $perPage);
                        $start = ($currentPage - 1) * $perPage;
                        $paginatedChickens = array_slice($chickens, $start, $perPage);
                    @endphp

                    @foreach($paginatedChickens as $chicken)
                        <tr>
                            <td>{{ $chicken['id'] }}</td>
                            <td>{{ $breeds[array_search($chicken['breedid'], array_column($breeds, 'id'))]['name'] ?? 'Unknown' }}</td>
                            <td>{{ $chicken['dob'] }}</td>
                            <td>{{ $chicken['cageid'] }}</td>
                            <td>
                                <a href="#" class="btn btn-primary btn-sm">Edit</a>
                                <form action="#" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this chicken?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination Links -->
            <div class="mt-3">
                <ul class="pagination">
                    <!-- Previous Page Link -->
                    <li class="page-item {{ $currentPage == 1 ? 'disabled' : '' }}">
                        <a class="page-link" href="?page={{ $currentPage - 1 }}">Previous</a>
                    </li>

                    <!-- Page Number Links -->
                    @for($i = 1; $i <= $totalPages; $i++)
                        <li class="page-item {{ $currentPage == $i ? 'active' : '' }}">
                            <a class="page-link" href="?page={{ $i }}">{{ $i }}</a>
                        </li>
                    @endfor

                    <!-- Next Page Link -->
                    <li class="page-item {{ $currentPage == $totalPages ? 'disabled' : '' }}">
                        <a class="page-link" href="?page={{ $currentPage + 1 }}">Next</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@stop
