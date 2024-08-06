@extends('/admin')

@section('title', 'Edit Egg Grading')

@section('content_header')
    <h1>Edit Egg Grading</h1>
@stop

@section('content')
<div class="container" style="width: 80%; margin-top: 20px;">
    <div class="row">
        <div class="col-md-12 mt-5">
            <h1>Edit Egg Grading</h1>
            {{-- action="{{ route('grading-results.update', $egg['id']) }}" --}}
            <form  method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="grade">Grade</label>
                    <select name="grade" class="form-control" id="grade" required>
                        <option value="">Select a grade</option>
                        <option value="AA" selected>AA</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                        <option value="E">E</option>
                        <!-- Add more options as needed -->
                    </select>
                </div>
                <div class="form-group">
                    <label for="type">Type</label>
                    <select name="type" class="form-control" id="type" required>
                        <option value="Free Range" selected>Free Range</option>
                        <option value="Organic">Organic</option>
                        <option value="Caged">Caged</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <select name="description" class="form-control" id="description" required>
                        <option value="Large brown eggs" selected>Large brown eggs</option>
                        <option value="Medium white eggs">Medium white eggs</option>
                        <option value="Small mixed color eggs">Small mixed color eggs</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="received_date">Received Date</label>
                    <input type="date" name="received_date" class="form-control" id="received_date" value="2024-07-31" required>
                </div>
                <div class="form-group">
                    <label for="quantity">Quantity</label>
                    <input type="number" name="quantity" class="form-control" id="quantity" value="100" required>
                </div>
                <button type="submit" class="btn btn-success">Update</button>
            </form>
        </div>
    </div>
</div>
@stop
