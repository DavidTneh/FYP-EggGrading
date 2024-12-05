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

            <div class="alert alert-danger" role="alert">
                <strong>Are you sure you want to delete this vaccination plan?</strong>
            </div>

            <dl class="row">
                <dt class="col-sm-3">Vaccination Plan ID:</dt>
                <dd class="col-sm-9">{{ $plan->vaccinationplanID }}</dd>

                <dt class="col-sm-3">Vaccination Type:</dt>
                <dd class="col-sm-9">{{ $plan->vaccinationType->vaccineName ?? 'Unknown' }}</dd>

                <dt class="col-sm-3">Vaccination per Chicken:</dt>
                <dd class="col-sm-9">{{ $plan->vaccinationPerChicken }}</dd>

                <dt class="col-sm-3">Age Thres Hold:</dt>
                <dd class="col-sm-9">{{ $plan->ageThreshold }}</dd>

                {{-- <dt class="col-sm-3">Cage:</dt>
                <dd class="col-sm-9">{{ $plan->cage->name ?? 'Unknown' }}</dd>

                <dt class="col-sm-3">Total Vaccinations Required:</dt>
                <dd class="col-sm-9">{{ $plan->totalVaccinationRequired }}</dd> --}}
            </dl>

            <form action="{{ route('vaccinationplan.destroy') }}" method="POST">
                @csrf
                @method('DELETE')
                <input type="hidden" name="vaccinationplanID" value="{{ $plan->vaccinationplanID }}">
                <div class="float-right">
                    <button type="submit" class="btn btn-danger"
                        onclick="return confirm('Are you sure you want to delete this plan?')">Delete</button>
                    <a href="{{ route('vaccinationplan.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@stop