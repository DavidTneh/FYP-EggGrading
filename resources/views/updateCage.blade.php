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
            <form method="POST" action="{{ route('cages.update', $cage->cageID) }}">
                @csrf
                @method('PUT')

                <input type="hidden" name="cageID" value="{{ $cage->cageID }}">

                <div class="form-group">
                    <label for="name">Cage Name</label>
                    <input type="text" name="name" class="form-control" id="name" value="{{ $cage->name }}" required>
                </div>

                <div class="form-group">
                    <label for="width">Width (meters)</label>
                    <input type="number" name="width" class="form-control" id="width" step="0.01" min="0.1"
                        value="{{ $width }}" required>
                </div>

                <div class="form-group">
                    <label for="length">Length (meters)</label>
                    <input type="number" name="length" class="form-control" id="length" step="0.01" min="0.1"
                        value="{{ $length }}" required>
                </div>

                <div class="form-group">
                    <label for="height">Height (meters)</label>
                    <input type="number" name="height" class="form-control" id="height" step="0.01" min="0.1"
                        value="{{ $height }}" required>
                </div>

                <div class="form-group">
                    <label for="capacity">Capacity</label>
                    <input type="number" name="capacity" class="form-control" id="capacity"
                        value="{{ $cage->capacity }}" required>
                </div>

                <div class="form-group">
                    <label for="type">Type</label>
                    <select name="type" class="form-control" id="type" required>
                        <option value="Free Range" {{ $cage->type == 'Free Range' ? 'selected' : '' }}>Free Range
                        </option>
                        <option value="Organic" {{ $cage->type == 'Organic' ? 'selected' : '' }}>Organic</option>
                        <option value="Caged" {{ $cage->type == 'Caged' ? 'selected' : '' }}>Caged</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" class="form-control" id="status" required>
                        <option value="Active" {{ $cage->status == 'Active' ? 'selected' : '' }}>Active</option>
                        <option value="Inactive" {{ $cage->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="Maintenance" {{ $cage->status == 'Maintenance' ? 'selected' : '' }}>Maintenance
                        </option>
                    </select>
                </div>

                <button type="submit" class="btn btn-success float-right">Update Cage</button>
            </form>
        </div>
    </div>
</div>
@stop