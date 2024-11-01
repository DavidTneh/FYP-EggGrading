@extends('/admin')

@section('title', 'Update Culling Plan')

@section('content_header')
<h1>Update Culling Plan</h1>
@stop

@section('content')
<div class="container" style="width: 80%; margin-top: 20px;">
    <div class="row">
        <div class="col-md-12 mt-5">
            <h1 class="mt-5">Update Culling Plan <i class="fas fa-edit"></i></h1>

            <form action="{{ route('cullingplan.update', $cullingPlan->cullingplanID) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="cullingplanID" value="{{ $cullingPlan->cullingplanID }}">

                <div class="form-group">
                    <label for="eliminateAgeThreshold">Eliminate Age Threshold (in months)</label>
                    <input type="number" name="eliminateAgeThreshold" class="form-control" id="eliminateAgeThreshold"
                        value="{{ $cullingPlan->eliminateAgeThreshold }}" required>
                </div>

                <div class="form-group">
                    <label for="reasons">Reasons</label>
                    <textarea name="reasons" class="form-control" id="reasons"
                        required>{{ $cullingPlan->reasons }}</textarea>
                </div>

                <div class="form-group">
                    <label for="healthStatus">Health Status</label>
                    <input type="text" name="healthStatus" class="form-control" id="healthStatus"
                        value="{{ $cullingPlan->healthStatus }}" required>
                </div>

                <div class="form-group">
                    <label for="notes">Notes</label>
                    <textarea name="notes" class="form-control" id="notes" required>{{ $cullingPlan->notes }}</textarea>
                </div>

                <button type="submit" class="btn btn-success float-right">Update Culling Plan</button>
            </form>
        </div>
    </div>
</div>
@stop