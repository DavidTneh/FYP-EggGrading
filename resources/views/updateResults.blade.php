@extends('/admin')

@section('title', 'Batch Edit Egg Grading')

@section('content_header')
<h1>Batch Edit Egg Grading</h1>
@stop

@section('content')
<div class="container" style="width: 80%; margin-top: 20px;">
    <div class="row">
        <div class="col-md-12 mt-5">
            <h1>Batch Edit Egg Grading</h1>
            <form action="{{ route('egg_grading.batchUpdate') }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Hidden fields for batch criteria -->
                <input type="hidden" name="receivedDate" value="{{ $egg->created_at }}">
                <input type="hidden" name="type" value="{{ $egg->type }}">
                <input type="hidden" name="description" value="{{ $egg->description }}">
                <input type="hidden" name="eggGradeID" value="{{ $egg->eggGradeID }}">

                <!-- Display the current grade with option to change -->
                <div class="form-group">
                    <label for="new_grade">Grade</label>
                    <select name="new_grade" class="form-control" id="new_grade">
                        @foreach($grades as $grade)
                        <option value="{{ $grade->eggGradeID }}" {{ $egg->eggGradeID == $grade->eggGradeID ? 'selected'
                            : '' }}>
                            {{ $grade->grade }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Display the current cage with option to change -->
                <div class="form-group">
                    <label for="new_cage">Cage</label>
                    <select name="new_cage" class="form-control" id="new_cage">
                        @foreach($cages as $cage)
                        <option value="{{ $cage->cageID }}" {{ $egg->cageID == $cage->cageID ? 'selected' : '' }}>
                            {{ $cage->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- Display the current type with option to change -->
                <div class="form-group">
                    <label for="new_type">Type</label>
                    <select name="new_type" class="form-control" id="new_type" required>
                        <option value="Free Range" {{ $egg->type == 'Free Range' ? 'selected' : '' }}>Free Range
                        </option>
                        <option value="Organic" {{ $egg->type == 'Organic' ? 'selected' : '' }}>Organic</option>
                        <option value="Caged" {{ $egg->type == 'Caged' ? 'selected' : '' }}>Caged</option>
                    </select>
                </div>

                <!-- Display the current description with option to change -->
                <div class="form-group">
                    <label for="new_description">Description</label>
                    <select name="new_description" class="form-control" id="new_description" required>
                        <option value="Large brown eggs" {{ $egg->description == 'Large brown eggs' ? 'selected' : ''
                            }}>
                            Large brown eggs
                        </option>
                        <option value="Medium white eggs" {{ $egg->description == 'Medium white eggs' ? 'selected' : ''
                            }}>
                            Medium white eggs
                        </option>
                        <option value="Small mixed color eggs" {{ $egg->description == 'Small mixed color eggs' ?
                            'selected' : '' }}>
                            Small mixed color eggs
                        </option>
                    </select>
                </div>

                <!-- Display the current calculated quantity -->
                <div class="form-group">
                    <label for="quantity">Quantity</label>
                    <!-- The current quantity is displayed as the default value and is editable -->
                    <input type="number" name="quantity" class="form-control" id="quantity" value="{{ $quantity }}"
                        min="1" required>
                </div>

                <button type="submit" class="btn btn-success">Update Batch</button>
            </form>
        </div>
    </div>
</div>
@stop