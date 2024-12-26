@extends('/admin')

@section('title', 'Update Collection Plan')

@section('content_header')
<h1>Update Egg Collection Plan</h1>
@stop

@section('content')
<div class="container" style="width: 80%; margin-top: 20px;">
    <div class="row">
        <div class="col-md-12 mt-5">
            <h1 class="mt-5">Update Egg Collection Plan <i class="fas fa-edit"></i></h1>
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

@if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
            @endif
            <form action="{{ route('collectionplan.update') }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="collectionplanID" value="{{ $collectionPlan->collectionplanID }}">
                <div class="form-group">
                    <label for="time">Time</label>
                    <input type="time" name="time" class="form-control" id="time"
                        value="{{ \Carbon\Carbon::parse($collectionPlan->time)->format('H:i') }}" required>
                </div>
                <div class="form-group">
                    <label for="frequency">Frequency</label>
                    <select name="frequency" class="form-control" id="frequency" required>
                        <option value="Daily" {{ $collectionPlan->frequency == 'Daily' ? 'selected' : '' }}>Daily
                        </option>
                        <option value="Weekly" {{ $collectionPlan->frequency == 'Weekly' ? 'selected' : '' }}>Weekly
                        </option>
                        <option value="Twice a Week" {{ $collectionPlan->frequency == 'Twice a Week' ? 'selected' : ''
                            }}>Twice a Week</option>
                        <option value="Monthly" {{ $collectionPlan->frequency == 'Monthly' ? 'selected' : '' }}>Monthly
                        </option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="is_repeating">Repeat</label>
                    <select name="is_repeating" class="form-control" id="is_repeating" required>
                        <option value="1" {{ $collectionPlan->is_repeating ? 'selected' : '' }}>Yes</option>
                        <option value="0" {{ !$collectionPlan->is_repeating ? 'selected' : '' }}>No</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success float-right">Update Egg Collection Plan</button>
            </form>
        </div>
    </div>
</div>
@stop