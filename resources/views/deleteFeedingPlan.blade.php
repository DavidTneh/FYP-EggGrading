@extends('/admin')

@section('title', 'Delete Feeding Plan')

@section('content_header')
    <h1>Delete Feeding Plan</h1>
@stop

@section('content')
<div class="container" style="width: 80%; margin-top: 20px;">
    <div class="row">
        <div class="col-md-12 mt-5">
            <h1 class="mt-5">Delete Feeding Plan <i class="fas fa-trash-alt"></i></h1>
            
            <!-- Hard-coded Feeding plan details -->
            @php
                $plan = [
                    'id' => 1,
                    'time' => '09:00 AM',
                    'frequency' => 'Daily',
                    'repeat' => 'Yes',
                ];
            @endphp

            <div class="alert alert-danger" role="alert">
                <strong>Are you sure you want to delete this Feeding plan?</strong>
            </div>
            
            <dl class="row">
                <dt class="col-sm-3">Plan ID:</dt>
                <dd class="col-sm-9">{{ $plan['id'] }}</dd>

                <dt class="col-sm-3">Time:</dt>
                <dd class="col-sm-9">{{ $plan['time'] }}</dd>

                <dt class="col-sm-3">Frequency:</dt>
                <dd class="col-sm-9">{{ $plan['frequency'] }}</dd>

                <dt class="col-sm-3">Repeat:</dt>
                <dd class="col-sm-9">{{ $plan['repeat'] }}</dd>
            </dl>
            {{-- action="{{ route('Feeding-plans.destroy', $plan['id']) }}" --}}
            <form  method="POST">
                @csrf
                @method('DELETE')
                <div class="float-right">
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this plan?')">Delete</button>
                <a  class="btn btn-secondary">Cancel</a>
                {{-- href="{{ route('Feeding-plans.index') }}" --}}
            </div>
            </form>
        </div>
    </div>
</div>
@stop
