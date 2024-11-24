@extends('/admin')

@section('title', 'Delete Collection Plan')

@section('content_header')
<h1>Delete Collection Plan</h1>
@stop

@section('content')
<div class="container" style="width: 80%; margin-top: 20px;">
    <div class="row">
        <div class="col-md-12 mt-5">
            <h1 class="mt-5">Delete Collection Plan <i class="fas fa-trash-alt"></i></h1>

            <div class="alert alert-danger" role="alert">
                <strong>Are you sure you want to delete this collection plan?</strong>
                <p>This will also delete all related tasks, assigned employees, and cage schedules associated with this
                    plan.</p>
            </div>

            <dl class="row">
                <dt class="col-sm-3">Plan ID:</dt>
                <dd class="col-sm-9">{{ $plan->collectionplanID }}</dd>

                <dt class="col-sm-3">Time:</dt>
                <dd class="col-sm-9">{{ $plan->time }}</dd>

                <dt class="col-sm-3">Frequency:</dt>
                <dd class="col-sm-9">{{ $plan->frequency }}</dd>

                <dt class="col-sm-3">Repeat:</dt>
                <dd class="col-sm-9">{{ $plan->is_repeating ? 'Yes' : 'No' }}</dd>

            </dl>

            <form action="{{ route('collectionplan.destroy') }}" method="POST">
                @csrf
                @method('DELETE')
                <input type="hidden" name="collectionplanID" value="{{ $plan->collectionplanID }}">
                <button type="submit" class="btn btn-danger float-right"
                    onclick="return confirm('Are you sure you want to delete this plan and all related data?')">Delete</button>
                <a href="{{ route('collectionplan.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@stop