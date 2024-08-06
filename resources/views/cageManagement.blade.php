@extends('/admin')

@section('title', 'Cage Management')

@section('content_header')
    <h1>Cage Management</h1>
@stop

@section('content')
<div class="container" style="width: 80%; margin-top: 20px;">
    <div class="row">
        <div class="col-md-12 mt-5">
            <i class="fas fa-10x fa-warehouse"></i>
            <h1 class="mt-5">Cage Management</h1>
            
            <!-- Add New Cage Button -->
            <div class="mb-3 float-right">
                <a href="#" class="btn btn-success">Add New Cage</a>
            </div>
            
            <!-- Cage List Table -->
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Size</th>
                        <th>Capacity</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Sample Data for Page 1 -->
                    @php
                        $cages = [
                            ['id' => 1, 'size' => 'Large', 'capacity' => 50, 'type' => 'Free Range', 'status' => 'Active'],
                            ['id' => 2, 'size' => 'Medium', 'capacity' => 30, 'type' => 'Organic', 'status' => 'Inactive'],
                            ['id' => 3, 'size' => 'Small', 'capacity' => 20, 'type' => 'Battery', 'status' => 'Maintenance'],
                            ['id' => 4, 'size' => 'Large', 'capacity' => 50, 'type' => 'Free Range', 'status' => 'Active'],
                            ['id' => 5, 'size' => 'Medium', 'capacity' => 30, 'type' => 'Organic', 'status' => 'Inactive'],
                            ['id' => 6, 'size' => 'Small', 'capacity' => 20, 'type' => 'Battery', 'status' => 'Maintenance'],
                            // Add more sample data as needed
                        ];

                        $perPage = 3; // Number of items per page
                        $totalPages = ceil(count($cages) / $perPage);
                        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                        $offset = ($currentPage - 1) * $perPage;
                        $pagedCages = array_slice($cages, $offset, $perPage);
                    @endphp

                    @foreach($pagedCages as $cage)
                        <tr>
                            <td>{{ $cage['id'] }}</td>
                            <td>{{ $cage['size'] }}</td>
                            <td>{{ $cage['capacity'] }}</td>
                            <td>{{ $cage['type'] }}</td>
                            <td>{{ $cage['status'] }}</td>
                            <td>
                                <a href="#" class="btn btn-primary btn-sm">Edit</a>
                                <button class="btn btn-danger btn-sm" onclick="alert('Delete action')">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination Controls -->
            <nav>
                <ul class="pagination">
                    @if($currentPage > 1)
                        <li class="page-item">
                            <a class="page-link" href="?page={{ $currentPage - 1 }}" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                    @endif

                    @for($i = 1; $i <= $totalPages; $i++)
                        <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                            <a class="page-link" href="?page={{ $i }}">{{ $i }}</a>
                        </li>
                    @endfor

                    @if($currentPage < $totalPages)
                        <li class="page-item">
                            <a class="page-link" href="?page={{ $currentPage + 1 }}" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>
    </div>
</div>
@stop
