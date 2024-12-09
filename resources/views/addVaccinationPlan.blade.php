@extends('/admin')

@section('title', 'Add Vaccination Plan')

@section('content_header')
<h1>Add Vaccination Plan</h1>
@stop

@section('content')
<div class="container" style="width: 80%; margin-top: 20px;">
    <div class="row">
        <div class="col-md-12 mt-5">
            <h1 class="mt-5">Add Vaccination Plan <i class="fas fa-plus"></i></h1>
            @if ($errors->any())
            <div class="alert alert-danger alert-dismissible">
                <h5><i class="icon fas fa-ban"></i> Error!</h5>
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            @if (session('status'))
            <div class="alert alert-success alert-dismissible">
                <h5><i class="icon fas fa-check"></i> Success!</h5>
                {{ session('status') }}
            </div>
            @endif
            <form action="{{ route('vaccinationplan.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="vaccinationtypeID">Vaccination Type</label>
                    <select name="vaccinationtypeID" class="form-control" id="vaccinationtypeID" required>
                        @foreach($vaccinationTypes as $type)
                        <option value="{{ $type->vaccinationtypeID }}">{{ $type->vaccineName }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="vaccinationPerChicken">Vaccination per Chicken</label>
                    <input type="number" name="vaccinationPerChicken" class="form-control" id="vaccinationPerChicken"
                        min="1" required>
                </div>

                <div class="form-group">
                    <label for="ageThreshold">Age Thres Hold</label>
                    <input type="number" name="ageThreshold" class="form-control" id="ageThreshold" min="1" required>
                </div>

                {{-- <div class="form-group">
                    <label for="cageID">Cage</label>
                    <select name="cageID" class="form-control" id="cageID" required>
                        @foreach($cages as $cage)
                        <option value="{{ $cage->cageID }}">{{ $cage->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="date">Select Date:</label>
                    <input type="date" id="date" name="date" class="form-control" required>
                </div> --}}


                <button type="submit" class="btn btn-success float-right">Add Vaccination Plan</button>
            </form>
        </div>
    </div>
</div>
@stop