@extends('/admin')

@section('title', 'Delete Culling Plan')

@section('content_header')
    <h1>Delete Culling Plan</h1>
@stop

@section('content')
<div class="container" style="width: 80%; margin-top: 20px;">
    <div class="row">
        <div class="col-md-12 mt-5">
            <h1 class="mt-5">Delete Culling Plan <i class="fas fa-trash-alt"></i></h1>
            
            <!-- Hard-coded culling plan details -->
            @php
                $plan = [
                    'id' => 1,
                    'eliminateAgeThreshold' => '24 weeks',
                    'reasons' => 'Low productivity',
                    'healthStatus' => 'Poor',
                    'notes' => 'Monitor regularly',
                ];
            @endphp

            <div class="alert alert-danger" role="alert">
                <strong>Are you sure you want to delete this culling plan?</strong>
            </div>
            
            <dl class="row">
                <dt class="col-sm-3">Plan ID:</dt>
                <dd class="col-sm-9">{{ $plan['id'] }}</dd>

                <dt class="col-sm-3">Eliminate Age Threshold:</dt>
                <dd class="col-sm-9">{{ $plan['eliminateAgeThreshold'] }}</dd>

                <dt class="col-sm-3">Reasons:</dt>
                <dd class="col-sm-9">{{ $plan['reasons'] }}</dd>

                <dt class="col-sm-3">Health Status:</dt>
                <dd class="col-sm-9">{{ $plan['healthStatus'] }}</dd>

                <dt class="col-sm-3">Notes:</dt>
                <dd class="col-sm-9">{{ $plan['notes'] }}</dd>
            </dl>
            {{-- action="{{ route('culling-plans.destroy', $plan['id']) }}" --}}
            <form  method="POST">
                @csrf
                @method('DELETE')
                <div class="float-right">
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this plan?')">Delete</button>
                {{-- href="{{ route('culling-plans.index') }}" --}}
                <a  class="btn btn-secondary">Cancel</a>
            </div>
            </form>
        </div>
    </div>
</div>
@stop
