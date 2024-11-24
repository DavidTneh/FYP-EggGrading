@extends('/admin')

@section('title', 'Create Feeding Plan')

@section('content_header')
<h1>Create Feeding Plan</h1>
@stop

@section('content')
<div class="container" style="width: 80%; margin-top: 20px;">
    <form method="POST" action="{{ route('feedingplan.store') }}" onsubmit="formatTimeInput()">
        @csrf
        <div class="form-group">
            <label for="time">Time (24-hour format)</label>
            <input type="time" name="time" class="form-control" id="time" required>
        </div>
        <div class="form-group">
            <label for="frequency">Frequency</label>
            <select name="frequency" class="form-control" id="frequency" required>
                <option value="Daily">Daily</option>
                <option value="Weekly">Weekly</option>
                <option value="Twice a Week">Twice a Week</option>
                <option value="Monthly">Monthly</option>
            </select>
        </div>
        <div class="form-group">
            <label for="is_repeating">Repeat</label>
            <select name="is_repeating" class="form-control" id="is_repeating" required>
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success float-right">Create Feeding Plan</button>
    </form>
</div>

<script>
    function formatTimeInput() {
        const timeInput = document.getElementById('time');
        if (timeInput.value.length === 5) {
            timeInput.value += ":00";
        }
    }
</script>
@stop