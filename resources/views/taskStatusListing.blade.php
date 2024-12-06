@extends('admin')

@section('title', 'Assigned Tasks')

@section('content_header')
<h1>Assigned Tasks</h1>
@stop

@section('content')
<div class="container mt-5">
    <h1>Your Assigned Tasks</h1>

    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <!-- Assigned Tasks Table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Task Name</th>
                <th>Description</th>
                <th>Assigned Cage</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($assignedTasks as $index => $task)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $task->taskName }}</td>
                <td>{{ $task->taskDescription }}</td>
                <td>{{ $task->cageName }}</td>
                <td>{{ $task->start_date }}</td>
                <td>{{ $task->end_date }}</td>
                <td>{{ ucfirst($task->status) }}</td>
                <td>
                    <form action="{{ route('employee.showUpdateTaskStatusForm') }}" method="POST"
                        style="display: inline-block;">
                        @csrf
                        <input type="hidden" name="scheduleID" value="{{ $task->scheduleID }}">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Update Status
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center">No tasks assigned to you.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <hr>

    <!-- Vaccination Records Table -->
    <h2>Your Assigned Vaccination Records</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Cage</th>
                <th>Breed</th>
                <th>Vaccination Plan</th>
                <th>Date Administered</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($assignedVaccinationRecords as $index => $record)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $record->chicken->cage->name ?? 'N/A' }}</td>
                <td>{{ $record->chicken->breed->name ?? 'N/A' }}</td>
                <td>{{ $record->vaccinationplan->vaccinationType->vaccineName ?? 'N/A' }}</td>
                <td>{{ $record->date_administered }}</td>
                <td>{{ ucfirst($record->status) }}</td>
                <td>
                    <form method="POST" action="{{ route('employee.showUpdateVaccinationStatusForm') }}">
                        @csrf
                        <input type="hidden" name="cageID" value="{{ $record->chicken->cageID }}">
                        <input type="hidden" name="breedID" value="{{ $record->chicken->breedID }}">
                        <input type="hidden" name="vaccinationplanID" value="{{ $record->vaccinationplanID }}">
                        <input type="hidden" name="date_administered" value="{{ $record->date_administered }}">
                        <button type="submit" class="btn btn-primary">Update Status</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@stop