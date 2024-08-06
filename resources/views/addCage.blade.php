@extends('/admin')

@section('title', 'Add Cage')

@section('content_header')
    <h1>Add Cage</h1>
@stop

@section('content')
<div class="container" style="width: 80%; margin-top: 20px;">
    <div class="row">
        <div class="col-md-12 mt-5">
            {{-- <i class="fas fa-10x fa-plus-circle"></i> --}}
            <h1 class="mt-5">Add New Cage</h1>
            {{-- action="{{ route('cages.store') }}" --}}
            <form method="POST">
                @csrf
                <div class="form-group">
                    <label for="size">Size</label>
                    <input type="text" name="size" class="form-control" id="size" required>
                </div>
                <div class="form-group">
                    <label for="capacity">Capacity</label>
                    <input type="number" name="capacity" class="form-control" id="capacity" required>
                </div>
                <div class="form-group">
                    <label for="type">Type</label>
                    <select name="type" class="form-control" id="type" required>
                        <option value="Battery">Battery</option>
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
                <button type="submit" class="btn btn-success">Add Cage</button>
            </form>
        </div>
    </div>
</div>
@stop
