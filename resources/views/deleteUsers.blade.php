@extends('/admin')

@section('title', 'Delete Users')

@section('content_header')
<h1>Delete Users</h1>
@stop

@section('content')
<div class="container" style="width: 80%; margin-top: 20px;">
    <div class="row">
        <div class="col-md-12 mt-5">
            <h1>Delete Users <i class="fas fa-trash-alt"></i></h1>
            <div class="alert alert-danger" role="alert">
                <strong>Are you sure you want to delete this user?</strong>
            </div>
            <div class="card">
                <div class="card-body">
                    <p class="card-text"><strong>Name:</strong> {{ $user->name }}</p>
                    <p class="card-text"><strong>Email:</strong> {{ $user->email }}</p>
                    <p class="card-text"><strong>Phone No:</strong> {{ $user->phoneNo }}</p>
                    <p class="card-text"><strong>Date Of Birth:</strong> {{ $user->dob }}</p>
                    <p class="card-text"><strong>Role:</strong> {{ $user->role->roleName ?? 'N/A' }}</p>
                    <p class="card-text"><strong>Address:</strong> {{ $user->address }}</p>
                    <div class="float-right">
                        <form method="POST" action="{{ route('users.destroy') }}">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="userID" value="{{ $user->userID }}">
                            <button type="submit" class="btn btn-danger"
                                onclick="return confirm('Are you sure you want to delete this user? Once deleted, it cannot be recovered!');">Delete</button>
                            <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop