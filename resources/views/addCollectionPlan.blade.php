@extends('/admin')

@section('title', 'Create Collection Plan')

@section('content_header')
    <h1>Create Collection Plan</h1>
@stop

@section('content')
<div class="container" style="width: 80%; margin-top: 20px;">
    <div class="row">
        <div class="col-md-12 mt-5">
            <h1 class="mt-5">Create Collection Plan <i class="fas fa-plus"></i></h1>
            {{-- action="{{ route('collection-plans.store') }}" --}}
            <form method="POST" >
                @csrf
                <div class="form-group">
                    <label for="time">Time</label>
                    <input type="text" name="time" class="form-control" id="time" value="09:00 AM" required>
                </div>
                <div class="form-group">
                    <label for="frequency">Frequency</label>
                    <input type="text" name="frequency" class="form-control" id="frequency" value="Daily" required>
                </div>
                <div class="form-group">
                    <label for="repeat">Repeat</label>
                    <input type="text" name="repeat" class="form-control" id="repeat" value="Yes" required>
                </div>
                <button type="submit" class="btn btn-success float-right">Create Collection Plan</button>
            </form>
        </div>
    </div>
</div>
@stop
