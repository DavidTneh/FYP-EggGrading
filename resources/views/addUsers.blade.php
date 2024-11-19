@extends('/admin')

@section('title', 'Create Users')

@section('content_header')
<h1>Create Users</h1>
@stop

@section('content')
<div class="container" style="width: 80%; margin-top: 20px;">
    <div class="row">
        <div class="col-md-12 mt-5">
            <h1 class="mt-5">Create Users <i class="fas fa-plus"></i></h1>
            <form method="POST" action="{{ route('users.store') }}">
                @csrf
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" class="form-control" id="name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control" id="email" required>
                </div>
                <div class="form-group">
                    <label for="phoneNo">Phone No</label>
                    <input type="text" name="phoneNo" class="form-control" id="phoneNo">
                </div>
                <div class="form-group">
                    <label for="dob">Date Of Birth</label>
                    <input type="date" name="dob" class="form-control" id="dob">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control" id="password" required>
                </div>
                <div class="form-group">
                    <label for="role">Role</label>
                    <select name="roleID" class="form-control">
                        @foreach($roles as $role)
                        <option value="{{ $role->roleID }}">{{ $role->roleName }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" name="address" class="form-control" id="address">
                </div>
                <button type="submit" class="btn btn-success float-right">Create User</button>
            </form>
        </div>
    </div>
</div>
@stop