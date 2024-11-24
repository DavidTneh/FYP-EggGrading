@extends('/admin')

@section('title', 'Update Feeding Plan')

@section('content_header')
<h1>Update Feeding Plan</h1>
@stop

@section('content')
<div class="container" style="width: 80%; margin-top: 20px;">
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
                <option value="Weekly" {{ $feedingPlan->frequency == 'Weekly' ? 'selected' : '' }}>Weekly</option>
                <option value="Twice a Week" {{ $feedingPlan->frequency == 'Twice a Week' ? 'selected' : '' }}>Twice a
                    Week</option>
                <option value="Monthly" {{ $feedingPlan->frequency == 'Monthly' ? 'selected' : '' }}>Monthly</option>
            </select>
        </div>
        <div class="form-group">
            <label for="is_repeating">Repeat</label>
            <select name="is_repeating" class="form-control" id="is_repeating" required>
                <option value="1" {{ $feedingPlan->is_repeating ? 'selected' : '' }}>Yes</option>
                <option value="0" {{ !$feedingPlan->is_repeating ? 'selected' : '' }}>No</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success float-right">Update Feeding Plan</button>
    </form>
</div>
@stop