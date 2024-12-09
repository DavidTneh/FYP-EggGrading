@extends('/admin')

@section('title', 'Create Culling Plan')

@section('content_header')
<h1>Create Culling Plan</h1>
@stop

@section('content')
<div class="container" style="width: 80%; margin-top: 20px;">
    <div class="row">
        <div class="col-md-12 mt-5">
            <h1 class="mt-5">Create Culling Plan <i class="fas fa-plus"></i></h1>

            @if ($errors->any())
            <div class="alert alert-danger alert-dismissible">
                <h5><i class="icon fas fa-ban"></i> Error!</h5>
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            @if (session('status'))
            <div class="alert alert-success alert-dismissible">
                <h5><i class="icon fas fa-check"></i> Success!</h5>
                {{ session('status') }}
            </div>
            @endif

            <form method="POST" action="{{ route('cullingplan.store') }}">
                @csrf
                <div class="form-group">
                    <label for="eliminateAgeThreshold">Eliminate Age Threshold (in weeks)</label>
                    <input type="number" name="eliminateAgeThreshold" class="form-control" id="eliminateAgeThreshold"
                        required>
                </div>
                <div class="form-group">
                    <label for="reasons">Reasons</label>
                    <textarea name="reasons" class="form-control" id="reasons" required></textarea>
                </div>
                <div class="form-group">
                    <label for="healthStatus">Health Status</label>
                    <input type="text" name="healthStatus" class="form-control" id="healthStatus" required>
                </div>
                <div class="form-group">
                    <label for="notes">Notes</label>
                    <textarea name="notes" class="form-control" id="notes" required></textarea>
                </div>
                <button type="submit" class="btn btn-success float-right">Create Culling Plan</button>
            </form>
        </div>
    </div>
</div>
@stop