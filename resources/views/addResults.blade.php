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
            <form action="{{ route('egg_grading.store') }}" method="POST">
                @csrf
                <!-- Dropdown for Grade -->
                <div class="form-group">
                    <label for="gradeID">Grade</label>
                    <select name="gradeID" class="form-control" id="gradeID" required>
                        <option value="">Select a grade</option>
                        @foreach ($eggGrades as $grade)
                        <option value="{{ $grade->eggGradeID }}">{{ $grade->name }}</option>
                        @endforeach
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
                    <label for="cageID">Cage</label>
                    <select name="cageID" class="form-control" id="cageID" required>
                        <option value="">Select a cage</option>
                        @foreach ($cages as $cage)
                        <option value="{{ $cage->cageID }}">{{ $cage->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="quantity">Quantity</label>
                    <input type="number" name="quantity" class="form-control" id="quantity" required>
                </div>

                <button type="submit" class="btn btn-success">Save</button>
            </form>
        </div>
    </div>
</div>
@stop