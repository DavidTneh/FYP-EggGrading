@extends('/admin')

@section('title', 'Confirm Deletion')

@section('content_header')
<h1>Confirm Deletion</h1>
@stop

@section('content')
<div class="container" style="width: 80%; margin-top: 20px;">
    <div class="row">
        <div class="col-md-12 mt-5">
            <h1 class="mt-5">Confirm Deletion</h1>

            <div class="alert alert-danger">
                <strong>Warning!</strong> You are about to delete the cage.
            </div>

            <table class="table">
                <tbody>
                    <tr>
                        <th>ID</th>
                        <td>{{ $cage->cageID }}</td>
                    </tr>
                    <tr>
                        <th>Name</th>
                        <td>{{ $cage->name }}</td>
                    </tr>
                    <tr>
                        <th>Size</th>
                        <td>{{ $cage->size }}</td>
                    </tr>
                    <tr>
                        <th>Capacity</th>
                        <td>{{ $cage->capacity }}</td>
                    </tr>
                    <tr>
                        <th>Type</th>
                        <td>{{ $cage->type }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>{{ $cage->status }}</td>
                    </tr>
                </tbody>
            </table>

            <form method="POST" action="{{ route('cages.destroy') }}">
                @csrf
                @method('DELETE')

                <input type="hidden" name="cageID" value="{{ $cage->cageID }}">

                <div class="form-group float-right">
                    <button type="submit" class="btn btn-danger">Delete</button>
                    <a href="{{ route('cages.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@stop