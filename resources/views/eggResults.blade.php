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
            {{-- method="GET" action="{{ route('grading-results') }}"  --}}
            <form class="mb-4">
                <div class="form-row">
                    <div class="col">
                        <input type="date" name="start_date" class="form-control" placeholder="Start Date">
                    </div>
                    <div class="col">
                        <input type="date" name="end_date" class="form-control" placeholder="End Date">
                    </div>
                    <div class="col">
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </div>
                </div>
            </form>

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
                    <!-- Hardcoded values -->
                    <tr>
                        <td>Chicken</td>
                        <td>Free-range chicken eggs</td>
                        <td>2024-07-01</td>
                        <td>2024-07-15</td>
                        <td>A</td>
                        <td>50-60g</td>
                        <td>$0.50</td>
                        <td>300</td>
                        <td>
                            <button type="button" class="btn btn-primary"><i class="fas fa-edit"></i></button>
                            <button type="button" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>Chicken</td>
                        <td>Caged eggs</td>
                        <td>2024-07-02</td>
                        <td>2024-07-25</td>
                        <td>B</td>
                        <td>60-70g</td>
                        <td>$0.60</td>
                        <td>250</td>
                        <td>
                            <button type="button" class="btn btn-primary"><i class="fas fa-edit"></i></button>
                            <button type="button" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>Chicken</td>
                        <td>Organic Eggs</td>
                        <td>2024-07-03</td>
                        <td>2024-07-30</td>
                        <td>C</td>
                        <td>10-15g</td>
                        <td>$0.20</td>
                        <td>600</td>
                        <td>
                            <button type="button" class="btn btn-primary"><i class="fas fa-edit"></i></button>
                            <button type="button" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
            
            <!-- Pagination (Dummy Links) -->
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item"><a class="page-link" href="#">Next</a></li>
                </ul>
            </nav>

            <button type="submit" class="btn btn-success mt-2" style="float: right">Add Eggs</button>
        </div>
    </div>
</div>
@stop
