@extends('/admin')

@section('title', 'Delete Vaccination Plan')

@section('content_header')
    <h1>Delete Vaccination Plan</h1>
@stop

@section('content')
<div class="container" style="width: 80%; margin-top: 20px;">
    <div class="row">
        <div class="col-md-12 mt-5">
            <h1 class="mt-5">Delete Vaccination Plan <i class="fas fa-trash-alt"></i></h1>
            
            <!-- Hard-coded vaccination plan details -->
            @php
                $plan = [
                    'id' => 1,
                    'vaccinationtypeID' => 1,
                    'vaccinationperchicken' => 1,
                    'cage' => 1,
                    'totalvaccinationrequired' => 100,
                ];

                $vaccinationTypes = [
                    ['id' => 1, 'vaccinename' => 'Vaccine A'],
                    ['id' => 2, 'vaccinename' => 'Vaccine B'],
                ];
                
                $vaccinationTypeName = collect($vaccinationTypes)->firstWhere('id', $plan['vaccinationtypeID'])['vaccinename'] ?? 'Unknown';
            @endphp

            <div class="alert alert-danger" role="alert">
                <strong>Are you sure you want to delete this vaccination plan?</strong>
            </div>
            
            <dl class="row">
                <dt class="col-sm-3">Vaccination Plan ID:</dt>
                <dd class="col-sm-9">{{ $plan['id'] }}</dd>

                <dt class="col-sm-3">Vaccination Type:</dt>
                <dd class="col-sm-9">{{ $vaccinationTypeName }}</dd>

                <dt class="col-sm-3">Vaccination per Chicken:</dt>
                <dd class="col-sm-9">{{ $plan['vaccinationperchicken'] }}</dd>

                <dt class="col-sm-3">Cage ID:</dt>
                <dd class="col-sm-9">{{ $plan['cage'] }}</dd>

                <dt class="col-sm-3">Total Vaccinations Required:</dt>
                <dd class="col-sm-9">{{ $plan['totalvaccinationrequired'] }}</dd>
            </dl>
            {{-- action="{{ route('vaccination-plans.destroy', $plan['id']) }}" --}}
            <form  method="POST">
                @csrf
                @method('DELETE')
                <div class="float-right">
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this plan?')">Delete</button>
                <a  class="btn btn-secondary">Cancel</a>
                {{-- href="{{ route('vaccination-plans.index') }}" --}}
            </div>
            </form>
        </div>
    </div>
</div>
@stop
