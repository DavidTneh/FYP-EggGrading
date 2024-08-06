@extends('/admin')

@section('title', 'Confirm Deletion')

@section('content_header')
    <h1>Confirm Deletion</h1>
@stop

@section('content')
<div class="container" style="width: 80%; margin-top: 20px;">
    <div class="row">
        <div class="col-md-12 mt-5">
            {{-- <i class="fas fa-10x fa-exclamation-triangle"></i> --}}
            <h1 class="mt-5">Confirm Deletion</h1>
            
            <div class="alert alert-danger">
                <strong>Warning!</strong> You are about to delete a cage.
            </div>
            
            <table class="table">
                <tbody>
                    <!-- Hard-coded values -->
                    <tr>
                        <th>ID</th>
                        <td>1</td>
                    </tr>
                    <tr>
                        <th>Size</th>
                        <td>Large</td>
                    </tr>
                    <tr>
                        <th>Capacity</th>
                        <td>50</td>
                    </tr>
                    <tr>
                        <th>Type</th>
                        <td>Free Range</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>Active</td>
                    </tr>
                </tbody>
            </table>
            
            <form method="POST" action="#">
                @csrf
                @method('DELETE')
                <div class="form-group float-right">
                    <button type="submit" class="btn btn-danger">Delete</button>
                    <a class="btn btn-secondary">Cancel</a>
                    {{-- href="{{ route('cages.index') }}"  --}}
                </div>
            </form>
        </div>
    </div>
</div>
@stop
