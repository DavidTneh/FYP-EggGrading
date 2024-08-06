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
            {{-- action="{{ route('Feeding-plans.store') }}" --}}
            <form method="POST" >
                @csrf
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" class="form-control" id="name" value="John Doe" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" name="email" class="form-control" id="email" value="johndoe@gmail.com" required>
                </div>
                <div class="form-group">
                    <label for="phoneno">Phone No</label>
                    <input type="text" name="phoneNo" class="form-control" id="phoneNo" value="0132345678" required>
                </div>
                <div class="form-group">
                    <label for="dob">Date Of Birth</label>
                    <input type="date" name="dob" class="form-control" id="dob" value="Aug-07-2024" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="pwd" class="form-control" id="inputPassword" value="******" required>
                </div>
                <div class="form-group">
                    <label for="role">Role</label>
                    <input type="text" name="role" class="form-control" id="inputRole" value="Admin" required>
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" name="address" class="form-control" id="inputAddress" value="Penang" required>
                </div>
                <button type="submit" class="btn btn-success float-right">Create Users</button>
            </form>
        </div>
    </div>
</div>
@stop