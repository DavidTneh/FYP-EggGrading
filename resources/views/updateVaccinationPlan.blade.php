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
            {{-- action="{{ route('vaccination-plans.update', $plan['id']) }}" --}}
            <form method="POST">
                @csrf
                @method('PUT')

                <!-- Hard-coded vaccination types -->
                @php
                    $vaccinationTypes = [
                        ['id' => 1, 'vaccinename' => 'Vaccine A'],
                        ['id' => 2, 'vaccinename' => 'Vaccine B'],
                    ];
                @endphp

                <div class="form-group">
                    <label for="vaccinationtypeID">Vaccination Type</label>
                    <select name="vaccinationtypeID" class="form-control" id="vaccinationtypeID" required>
                        @foreach($vaccinationTypes as $type)
                            <option value="{{ $type['id'] }}" {{ $type['id'] == 1 ? 'selected' : '' }}>{{ $type['vaccinename'] }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="vaccinationperchicken">Vaccination per Chicken</label>
                    <input type="number" name="vaccinationperchicken" class="form-control" id="vaccinationperchicken" value="1" required>
                </div>

                <div class="form-group">
                    <label for="cage">Cage ID</label>
                    <input type="number" name="cage" class="form-control" id="cage" value="1" required>
                </div>

                <div class="form-group">
                    <label for="totalvaccinationrequired">Total Vaccinations Required</label>
                    <input type="number" name="totalvaccinationrequired" class="form-control" id="totalvaccinationrequired" value="100" required>
                </div>

                <button type="submit" class="btn btn-success float-right">Update Vaccination Plan</button>
            </form>
        </div>
    </div>
</div>
@stop
