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
                            {{-- <a href="{{ route('users.edit') }}" class="btn btn-primary btn-sm">Edit</a> --}}
                            <form method="POST" action="{{ route('users.edit') }}" style="display: inline;">
                                @csrf
                                @method('POST')
                                <input type="hidden" name="userID" value="{{ $user->userID }}">
                                <button type="submit" class="btn btn-primary btn-sm">Edit</button>
                            </form>

                            <form method="POST" action="{{ route('users.showDelete') }}"
                                style="display:inline;">
                                @csrf
                                @method('POST')
                                <input type="hidden" name="userID" value="{{ $user->userID }}">
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
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