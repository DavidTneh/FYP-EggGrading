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
                    @if(strtolower($task->status) !== 'completed')
                    <form action="{{ route('employee.showUpdateTaskStatusForm') }}" method="POST"
                        style="display: inline-block;">
                        @csrf
                        <input type="hidden" name="scheduleID" value="{{ $task->scheduleID }}">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Update Status
                        </button>
                    </form>
                    @endif
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

    <!-- Vaccination Records -->
    <h2>Your Assigned Vaccination Records</h2>
    
    @foreach($assignedVaccinationRecords as $cageID => $breeds)
    @php
    $firstChickenInCage = $breeds->first()->first()->first(); // Get the first record in the cage
    @endphp
    
    <h3>Cage: {{ $firstChickenInCage->chicken->cage->name ?? 'Unknown Cage' }}</h3>
    
    @foreach($breeds as $breedID => $plans)
    @php
    $firstChickenInBreed = $plans->first()->first(); // Get the first record in the breed
    @endphp
    
    <h4>Breed: {{ $firstChickenInBreed->chicken->breed->name ?? 'Unknown Breed' }}</h4>
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Vaccination Plan</th>
                <th>Date Administered</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($plans as $planGroup)
            @php
            $firstRecord = $planGroup->first(); // Get the first record in the group
            @endphp
            <tr>
                <td>{{ $firstRecord->vaccinationplan->vaccinationType->vaccineName ?? 'N/A' }}</td>
                <td>{{ $firstRecord->date_administered }}</td>
                <td>{{ ucfirst($firstRecord->status) }}</td>
                <td>
                    @if(strtolower($firstRecord->status) !== 'completed')
                    <form method="POST" action="{{ route('employee.showUpdateVaccinationStatusForm') }}">
                        @csrf
                        <input type="hidden" name="cageID" value="{{ $firstRecord->chicken->cageID }}">
                        <input type="hidden" name="breedID" value="{{ $firstRecord->chicken->breedID }}">
                        <input type="hidden" name="vaccinationplanID" value="{{ $firstRecord->vaccinationplanID }}">
                        <input type="hidden" name="date_administered" value="{{ $firstRecord->date_administered }}">
                        <button type="submit" class="btn btn-primary">Update Status</button>
                    </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endforeach
    @endforeach
</div>
@stop