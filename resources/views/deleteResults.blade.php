@extends('/admin')

@section('title', 'Delete Egg Grading')

@section('content_header')
    <h1>Delete Egg Grading</h1>
@stop

@section('content')
<div class="container" style="width: 80%; margin-top: 20px;">
    <div class="row">
        <div class="col-md-12 mt-5">
            <h1>Delete Egg Grading</h1>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Are you sure you want to delete this egg grading?</h5>
                    <p class="card-text"><strong>Type:</strong> Free Range</p>
                    <p class="card-text"><strong>Description:</strong> Large brown eggs</p>
                    <p class="card-text"><strong>Received Date:</strong> 2024-07-31</p>
                    <p class="card-text"><strong>Last Updated:</strong> 2024-07-31</p>
                    <p class="card-text"><strong>Grade:</strong> A</p>
                    <p class="card-text"><strong>Estimated Weight Range:</strong> 60-70g</p>
                    <p class="card-text"><strong>Price:</strong> 0.50</p>
                    <p class="card-text"><strong>Quantity:</strong> 100</p>
                    {{-- action="{{ route('grading-results.destroy', $egg['id']) }}" --}}
                    <form method="POST" onsubmit="return confirm('Are you sure you want to delete this egg grading? Once deleted no way to recover back!');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                        <a href="#" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
