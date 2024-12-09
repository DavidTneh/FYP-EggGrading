@extends('/admin')

@section('title', 'Update Vaccination Plan')

@section('content_header')
<h1>Update Vaccination Plan</h1>
@stop

@section('content')
<div class="container" style="width: 80%; margin-top: 20px;">
    <div class="row">
        <div class="col-md-12 mt-5">
            <h1 class="mt-5">Update Vaccination Plan <i class="fas fa-edit"></i></h1>
            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif

            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <form action="{{ route('vaccinationplan.update') }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="vaccinationplanID" value="{{ $plan->vaccinationplanID }}">

                <div class="form-group">
                    <label for="vaccinationtypeID">Vaccination Type</label>
                    <select name="vaccinationtypeID" class="form-control" id="vaccinationtypeID" required>
                        @foreach($vaccinationTypes as $type)
                        <option value="{{ $type->vaccinationtypeID }}" {{ $type->vaccinationtypeID ==
                            $plan->vaccinationtypeID ? 'selected' : '' }}>
                            {{ $type->vaccineName }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="vaccinationPerChicken">Vaccination per Chicken</label>
                    <input type="number" name="vaccinationPerChicken" class="form-control" id="vaccinationPerChicken"
                        value="{{ $plan->vaccinationPerChicken }}" required>
                </div>

                <div class="form-group">
                    <label for="ageThreshold">Age Thres Hold</label>
                    <input type="number" name="ageThreshold" class="form-control" id="ageThreshold" min="1"
                        value="{{ $plan->ageThreshold }}" required>
                </div>

                {{-- <div class="form-group">
                    <label for="cageID">Cage</label>
                    <select name="cageID" class="form-control" id="cageID" required>
                        @foreach($cages as $cage)
                        <option value="{{ $cage->cageID }}" {{ $cage->cageID == $plan->cageID ? 'selected' : '' }}>
                            {{ $cage->name }}
                        </option>
                        @endforeach
                    </select>
                </div> --}}

                {{-- <div class="form-group">
                    <label for="date">Date</label>
                    <input type="date" id="date" name="date" class="form-control" value="{{ $plan->date }}" required>
                </div> --}}

                <button type="submit" class="btn btn-success float-right">Update Vaccination Plan</button>
            </form>
        </div>
    </div>
</div>
@stop