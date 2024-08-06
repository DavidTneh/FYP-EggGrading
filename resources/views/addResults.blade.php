@extends('/admin')

@section('title', 'Add Egg Grading')

@section('content_header')
    <h1>Add Egg Grading</h1>
@stop

@section('content')
<div class="container" style="width: 80%; margin-top: 20px;">
    <div class="row">
        <div class="col-md-12 mt-5">
            <h1>Add Egg Grading</h1>
            {{-- action="{{ route('grading-results.store') }}" --}}
            <form  method="POST">
                @csrf
                <div class="form-group">
                    <label for="grade">Grade</label>
                    <select name="grade" class="form-control" id="grade" required>
                        <option value="">Select a grade</option>
                        <option value="AA">AA</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                        <option value="E">E`</option>
                        <!-- Add more options as needed -->
                    </select>
                </div>
                <div class="form-group">
                    <label for="type">Type</label>
                    <input type="text" name="type" class="form-control" id="type" required>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <input type="text" name="description" class="form-control" id="description" required>
                </div>
                <div class="form-group">
                    <label for="received_date">Received Date</label>
                    <input type="date" name="received_date" class="form-control" id="received_date" required>
                </div>
                

                
                <button type="submit" class="btn btn-success">Save</button>
            </form>
        </div>
    </div>
</div>
@stop