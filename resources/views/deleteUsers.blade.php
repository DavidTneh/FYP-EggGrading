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
                    <strong>Are you sure you want to delete this users?</strong>
                </div>
            <div class="card">
                <div class="card-body">
                    <p class="card-text"><strong>Name:</strong> John Doe</p>
                    <p class="card-text"><strong>Email:</strong> johndoe@gmail.com</p>
                    <p class="card-text"><strong>Phone No:</strong> 0145678907</p>
                    <p class="card-text"><strong>Date Of Birth:</strong> 2024-07-31</p>
                    
                    <p class="card-text"><strong>Role:</strong> Admin</p>
                    <p class="card-text"><strong>Address:</strong> Penang</p>
                    {{-- action="{{ route('grading-results.destroy', $egg['id']) }}" --}}
                    <form method="POST" onsubmit="return confirm('Are you sure you want to delete this Users? Once deleted no way to recover back!');">
                        @csrf
                        @method('DELETE')
                        <div class="float-right">
                        <button type="submit" class="btn btn-danger">Delete</button>
                        <a href="#" class="btn btn-secondary">Cancel</a>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
