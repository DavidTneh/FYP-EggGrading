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

            <div class="alert alert-danger" role="alert">
                <strong>Are you sure you want to delete this culling plan?</strong>
                <p>This will also delete all related tasks, assigned employees, and cage schedules associated with this
                    plan.</p>
            </div>

            <dl class="row">
                <dt class="col-sm-3">Plan ID:</dt>
                <dd class="col-sm-9">{{ $plan->cullingplanID }}</dd>

                <dt class="col-sm-3">Eliminate Age Threshold:</dt>
                <dd class="col-sm-9">{{ $plan->eliminateAgeThreshold }}</dd>

                <dt class="col-sm-3">Health Status:</dt>
                <dd class="col-sm-9">{{ $plan->healthStatus }}</dd>

                <dt class="col-sm-3">Notes:</dt>
                <dd class="col-sm-9">{{ $plan->notes }}</dd>
            </dl>

            <form action="{{ route('cullingplan.destroy', $plan->cullingplanID) }}" method="POST">
                @csrf
                @method('DELETE')

                <input type="hidden" name="cullingplanID" value="{{ $plan->cullingplanID }}">

                <div class="float-right">
                    <button type="submit" class="btn btn-danger"
                        onclick="return confirm('Are you sure you want to delete this plan and all related data?')">Delete</button>
                    <a href="{{ route('cullingplan.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@stop