@extends('/admin')

@section('title', 'User Management')

@section('content_header')
    <h1>User Management</h1>
@stop

@section('content')
<div class="container" style="width: 80%; margin-top: 20px;">
    <div class="row">
        <div class="col-md-12 mt-5">
            <h1 class="mt-5">Users</h1>
            <a href="#" class="btn btn-success mb-3 float-right">Add New User</a>

            <!-- Users List Table -->
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Date of Birth</th>
                        <th>Role</th>
                        <th>Address</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Hardcoded Users -->
                    <tr>
                        <td>1</td>
                        <td>John Doe</td>
                        <td>john.doe@example.com</td>
                        <td>123-456-7890</td>
                        <td>1990-01-01</td>
                        <td>Admin</td>
                        <td>123 Main St, Cityville</td>
                        <td>
                            <a href="#" class="btn btn-primary btn-sm">Edit</a>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="_token" value="CSRF_TOKEN">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Jane Smith</td>
                        <td>jane.smith@example.com</td>
                        <td>987-654-3210</td>
                        <td>1985-05-15</td>
                        <td>User</td>
                        <td>456 Elm St, Townsville</td>
                        <td>
                            <a href="#" class="btn btn-primary btn-sm">Edit</a>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="_token" value="CSRF_TOKEN">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <!-- Add more hardcoded users as needed -->
                </tbody>
            </table>

            <!-- Pagination Controls -->
            <div class="mt-3">
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1">Previous</a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
@stop
