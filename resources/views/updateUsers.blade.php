@extends('/admin')

@section('title', 'Edit Users')

@section('content_header')
<h1>Edit Users</h1>
@stop

@section('content')
<div class="container" style="width: 80%; margin-top: 20px;">
    <div class="row">
        <div class="col-md-12 mt-5">
            <h1>Edit Users</h1>
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif
            <form method="POST" action="{{ route('users.update') }}">
                @csrf
                @method('PUT')
                <input type="hidden" name="userID" value="{{ $user->userID }}">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" class="form-control" id="name" value="{{ $user->name }}" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control" id="email" value="{{ $user->email }}"
                        required>
                </div>
                <div class="form-group">
                    <label for="phoneNo">Phone No</label>
                    <input type="text" name="phoneNo" class="form-control" id="phoneNo" value="{{ $user->phoneNo }}">
                </div>
                <div class="form-group">
                    <label for="dob">Date Of Birth</label>
                    <input type="date" name="dob" class="form-control" id="dob" value="{{ $user->dob }}">
                </div>
                <div class="form-group">
                    <label for="role">Role</label>
                    <select name="roleID" class="form-control">
                        @foreach($roles as $role)
                        <option value="{{ $role->roleID }}" {{ $role->roleID == $user->roleID ? 'selected' : '' }}>
                            {{ $role->roleName }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" name="address" class="form-control" id="address" value="{{ $user->address }}">
                </div>
                <button type="submit" class="btn btn-success">Update</button>
            </form>
        </div>
    </div>
</div>
@stop