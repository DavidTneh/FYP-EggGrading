@extends('/admin')

@section('title', 'Update Feeding Plan')

@section('content_header')
<h1>Update Feeding Plan</h1>
@stop

@section('content')
<div class="container" style="width: 80%; margin-top: 20px;">
    <div class="row">
        <div class="col-md-12 mt-5">
            <h1 class="mt-5">Update Feeding Plan <i class="fas fa-edit"></i></h1>

            <form action="{{ route('feedingplan.update') }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="feedingplanID" value="{{ $feedingPlan->feedingplanID }}">
                <div class="form-group">
                    <label for="time">Time</label>
                    <input type="time" name="time" class="form-control" id="time"
                        value="{{ \Carbon\Carbon::parse($feedingPlan->time)->format('H:i') }}" required>
                </div>
                <div class="form-group">
                    <label for="frequency">Frequency</label>
                    <select name="frequency" class="form-control" id="frequency" required>
                        <option value="Daily" {{ $feedingPlan->frequency == 'Daily' ? 'selected' : '' }}>Daily</option>
                        <option value="Weekly" {{ $feedingPlan->frequency == 'Weekly' ? 'selected' : '' }}>Weekly
                        </option>
                        <option value="Twice a Week" {{ $feedingPlan->frequency == 'Twice a Week' ? 'selected' : ''
                            }}>Twice a Week</option>
                        <option value="Monthly" {{ $feedingPlan->frequency == 'Monthly' ? 'selected' : '' }}>Monthly
                        </option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="repeat">Repeat</label>
                    <select name="repeat" class="form-control" id="repeat" required>
                        <option value="1" {{ $feedingPlan->repeat ? 'selected' : '' }}>Yes</option>
                        <option value="0" {{ !$feedingPlan->repeat ? 'selected' : '' }}>No</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success float-right">Update Feeding Plan</button>
            </form>
        </div>
    </div>
</div>
@stop