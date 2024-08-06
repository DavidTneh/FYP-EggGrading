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
            {{-- action="{{ route('grading-results.update', $egg['id']) }}" --}}
            <form  method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="Name">Name</label>
                    <input type="text" name="Name" class="form-control" id="name" value="John Doe" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control" id="email" value="johndoe@gmail.com" required>
                </div>
                <div class="form-group">
                    <label for="phoneNo">Phone No</label>
                    <input type="phoneNo" name="phoneNo" class="form-control" id="phoneNo" value="0123456789" required>
                </div>
                <div class="form-group">
                    <label for="dob">Date Of Birth</label>
                    <input type="date" name="dob" class="form-control" id="dob" value="" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="pwd" class="form-control" id="pwd" value="*******" required>
                </div>
                <div class="form-group">
                    <label for="role">Role</label>
                    <input type="text" name="role" class="form-control" id="role" value="Manager" required>
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" name="address" class="form-control" id="address" value="GeorgeTown" required>
                </div>

                <button type="submit" class="btn btn-success">Update</button>
            </form>
        </div>
    </div>
</div>
@stop
