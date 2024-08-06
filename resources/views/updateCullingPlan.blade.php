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
            {{-- action="{{ route('culling-plans.update', 1) }}" --}}
            <form method="POST" >
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="eliminateAgeThreshold">Eliminate Age Threshold</label>
                    <input type="text" name="eliminateAgeThreshold" class="form-control" id="eliminateAgeThreshold" value="24 weeks" required>
                </div>
                <div class="form-group">
                    <label for="reasons">Reasons</label>
                    <input type="text" name="reasons" class="form-control" id="reasons" value="Low productivity" required>
                </div>
                <div class="form-group">
                    <label for="healthStatus">Health Status</label>
                    <input type="text" name="healthStatus" class="form-control" id="healthStatus" value="Poor" required>
                </div>
                <div class="form-group">
                    <label for="notes">Notes</label>
                    <input type="text" name="notes" class="form-control" id="notes" value="Monitor regularly" required>
                </div>
                <button type="submit" class="btn btn-success float-right">Update Culling Plan</button>
            </form>
        </div>
    </div>
</div>
@stop
