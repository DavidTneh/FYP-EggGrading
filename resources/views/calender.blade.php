@extends('admin')

@section('title', 'Task Schedule Calendar')

@section('content')
<div class="container mt-5">
    <h1 class="text-center">Task Schedule Calendar</h1>
    <p class="text-center">
        Showing tasks for the week of
        <strong>{{ $startOfWeek->format('M d, Y') }}</strong> to
        <strong>{{ $endOfWeek->format('M d, Y') }}</strong>.
    </p>

    <!-- Navigation buttons for previous and next weeks -->
    <div class="d-flex justify-content-between mb-4">
        <a href="{{ route('task-schedulings.calendar', ['week' => $weekOffset - 1]) }}" class="btn btn-primary">Previous
            Week</a>
        <a href="{{ route('task-schedulings.calendar', ['week' => 0]) }}" class="btn btn-secondary">Current Week</a>
        <a href="{{ route('task-schedulings.calendar', ['week' => $weekOffset + 1]) }}" class="btn btn-primary">Next
            Week</a>
    </div>

    <!-- Task Schedule Table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Time</th>
                @foreach (range(0, 6) as $day)
                <th>{{ $startOfWeek->copy()->addDays($day)->format('l, d M Y') }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach (range(0, 23) as $hour)
            <tr>
                <td>{{ str_pad($hour, 2, '0', STR_PAD_LEFT) }}:00</td>
                @foreach (range(0, 6) as $day)
                @php
                $currentDay = $startOfWeek->copy()->addDays($day);
                $timeSlot = $currentDay->format('Y-m-d') . ' ' . str_pad($hour, 2, '0', STR_PAD_LEFT) . ':00:00';
                @endphp
                <td>
                    @if (isset($normalizedTasks[$timeSlot]))
                    @foreach ($normalizedTasks[$timeSlot] as $task)
                    <div class="task-item {{ strtolower($task->taskType) }}">
                        <span class="badge">{{ ucfirst($task->taskType) }}</span>
                        <strong>{{ $task->taskName }}</strong><br>
                        <small>
                            {{ $task->taskDescription }}<br>
                            @if ($task->taskType === 'Culling')
                            Cage: {{ $task->cageName }}
                            @elseif ($task->taskType === 'Feeding' || $task->taskType === 'Collection')
                            Frequency: {{ $task->taskFrequency }}<br>
                            Cage: {{ $task->cageName }}
                            @elseif ($task->taskType === 'Vaccination')
                            Breed: {{ $task->breedName }}<br>
                            Cage: {{ $task->cageName }}<br>
                            Method: {{ $task->methodConsume }}
                            @endif
                        </small>
                    </div>
                    @endforeach
                    @endif
                </td>
                @endforeach
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Styles -->
<style>
    .task-item {
        margin-bottom: 10px;
        padding: 10px;
        border-radius: 5px;
        color: #fff;
        font-size: 14px;
        font-weight: bold;
    }

    .task-item.vaccination {
        background-color: #17a2b8;
        /* Vaccination: Teal */
    }

    .task-item.collection {
        background-color: #007bff;
        /* Collection: Blue */
    }

    .task-item.feeding {
        background-color: #28a745;
        /* Feeding: Green */
    }

    .task-item.culling {
        background-color: #ffc107;
        /* Culling: Yellow */
        color: #000;
        /* Contrast for Yellow */
    }

    .badge {
        display: block;
        font-weight: bold;
        margin-bottom: 5px;
    }
</style>
@endsection