@extends('/admin')

@section('title', 'Update Cage')

@section('content_header')
    <h1>Update Cage</h1>
@stop

@section('content')
<div class="container" style="width: 80%; margin-top: 20px;">
    <div class="row">
        <div class="col-md-12 mt-5">
            
            <h1 class="mt-5">Update Cage <i class="fas fa-edit"></i></h1>
            <form method="POST" action="#">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="size">Size</label>
                    <input type="text" name="size" class="form-control" id="size" value="Large" required>
                </div>
                <div class="form-group">
                    <label for="capacity">Capacity</label>
                    <input type="number" name="capacity" class="form-control" id="capacity" value="50" required>
                </div>
                <div class="form-group">
                    <label for="type">Type</label>
                    <select name="type" class="form-control" id="type" required>
                        <option value="Battery">Battery</option>
                        <option value="Free Range" selected>Free Range</option>
                        <option value="Organic">Organic</option>
                        <option value="Caged">Caged</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" class="form-control" id="status" required>
                        <option value="Active" selected>Active</option>
                        <option value="Inactive">Inactive</option>
                        <option value="Maintenance">Maintenance</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success float-right">Update Cage</button>
            </form>
        </div>
    </div>
</div>
@stop
