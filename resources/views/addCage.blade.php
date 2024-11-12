@extends('/admin')

@section('title', 'Add Cage')

@section('content_header')
<h1>Add Cage</h1>
@stop

@section('content')
<div class="container" style="width: 80%; margin-top: 20px;">
    <div class="row">
        <div class="col-md-12 mt-5">
            <h1 class="mt-5">Add New Cage</h1>
            <form action="{{ route('cages.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="size">Cage Name</label>
                    <input type="text" name="name" class="form-control" id="name" required>
                </div>

                <div class="form-group">
                    <label for="width">Width (meters)</label>
                    <input type="number" name="width" class="form-control" id="width" step="0.01" min="0.1" required>
                </div>

                <div class="form-group">
                    <label for="length">Length (meters)</label>
                    <input type="number" name="length" class="form-control" id="length" step="0.01" min="0.1" required>
                </div>

                <div class="form-group">
                    <label for="height">Height (meters)</label>
                    <input type="number" name="height" class="form-control" id="height" step="0.01" min="0.1" required>
                </div>

                <div class="form-group">
                    <label for="capacity">Capacity</label>
                    <input type="number" name="capacity" class="form-control" id="capacity" min="1" required>
                </div>

                <div class="form-group">
                    <label for="type">Type</label>
                    <select name="type" class="form-control" id="type" required>
                        <option value="Free Range">Free Range</option>
                        <option value="Organic">Organic</option>
                        <option value="Caged">Caged</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" class="form-control" id="status" required>
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                        <option value="Maintenance">Maintenance</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="status">Availability</label>
                    <select name="availability" class="form-control" id="availability" required>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>


                <button type="submit" class="btn btn-success">Add Cage</button>
            </form>
        </div>
    </div>
</div>
@stop