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

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif
                
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                
            <a href="{{ route('users.create') }}" class="btn btn-success mb-3 float-right">Add New User</a>

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
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $user->userID }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phoneNo }}</td>
                        <td>{{ $user->dob }}</td>
                        <td>{{ $user->role->roleName ?? 'N/A' }}</td>
                        <td>{{ $user->address }}</td>
                        <td>
                            @if ($user->status)
                            <span class="badge badge-success">Active</span>
                            @else
                            <span class="badge badge-danger">Disabled</span>
                            @endif
                        </td>
                        <td>
                            <!-- Edit Button -->
                            <form method="POST" action="{{ route('users.edit') }}" style="display: inline;">
                                @csrf
                                @method('POST')
                                <input type="hidden" name="userID" value="{{ $user->userID }}">
                                <button type="submit" class="btn btn-primary btn-sm">Edit</button>
                            </form>

                            <!-- Delete Button -->
                            <form method="POST" action="{{ route('users.showDelete') }}" style="display: inline;">
                                @csrf
                                @method('POST')
                                <input type="hidden" name="userID" value="{{ $user->userID }}">
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>

                            <!-- Disable Button -->
                            @if ($user->status)
                            <form method="POST" action="{{ route('users.disable') }}" style="display: inline;">
                                @csrf
                                <input type="hidden" name="userID" value="{{ $user->userID }}">
                                <button type="submit" class="btn btn-warning btn-sm"
                                    onclick="return confirm('Are you sure you want to disable this account?')">
                                    Disable
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination Controls -->
            <div class="mt-3">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</div>
@stop