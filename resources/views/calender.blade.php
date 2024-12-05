@extends('/admin')

@section('title', 'Task Schedule Calendar')

@section('content_header')
<h1>Task Schedule Calendar</h1>
@stop

@section('content')
{{--<div class="container" style="width: 100%; margin-top: 20px;">
    <div class="row">
        <div class="col-md-12 mt-5">
            <h1 class="mt-5">Weekly Task Calendar</h1>
            <table class="table table-bordered" style="background-color: #fff; width: 100%;">
                <thead class="thead-light">
                    <tr>
                        <th style="border: 1px solid #dee2e6; padding: 10px; background-color:#007bff; color: white;">
                            Time</th>
                        <th style="border: 1px solid #dee2e6; padding: 10px; background-color:#28a745; color: white;">
                            Sunday</th>
                        <th style="border: 1px solid #dee2e6; padding: 10px; background-color:#28a745; color: white;">
                            Monday</th>
                        <th style="border: 1px solid #dee2e6; padding: 10px; background-color:#28a745; color: white;">
                            Tuesday</th>
                        <th style="border: 1px solid #dee2e6; padding: 10px; background-color:#28a745; color: white;">
                            Wednesday</th>
                        <th style="border: 1px solid #dee2e6; padding: 10px; background-color:#28a745; color: white;">
                            Thursday</th>
                        <th style="border: 1px solid #dee2e6; padding: 10px; background-color:#28a745; color: white;">
                            Friday</th>
                        <th style="border: 1px solid #dee2e6; padding: 10px; background-color:#28a745; color: white;">
                            Saturday</th>
                    </tr>
                </thead>
                <tbody>
                    @for ($hour = 8; $hour <= 17; $hour++)  <tr>
                        <td style="border: 1px solid #dee2e6; padding: 5px; background-color: #f8f9fa;">
                            {{ $hour }}:00 - {{ $hour + 1 }}:00
                        </td>
                        @foreach (range(0, 6) as $day) 
                        <td style="border: 1px solid #dee2e6; padding: 5px;">
                            @foreach ($calendarData as $task)
                            @if ($task['day'] == $day && Carbon\Carbon::parse($task['time'])->hour == $hour)
                            <div class="task"
                                style="background-color: #ffc107; padding: 10px; margin-bottom: 5px; border-radius: 5px;">
                                <strong>{{ $task['taskName'] }}</strong>
                                <p>{{ $task['description'] }}</p>
                                <p><strong>Collection Plan:</strong> {{ $task['collectionPlan'] }}</p>
                                <p><strong>Feeding Plan:</strong> {{ $task['feedingPlan'] }}</p>
                                <p><strong>Culling Plan:</strong> {{ $task['cullingPlan'] }}</p>
                                <p><strong>Status:</strong> {{ $task['status'] }}</p>
                            </div>
                            @endif
                            @endforeach
                        </td>
                        @endforeach
                        </tr>
                        @endfor
                </tbody>
            </table>
        </div>
    </div>
</div>--}}

{{-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Calendar</title>
    <link href="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.5/main.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.5/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.5/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/timegrid@6.1.5/main.min.js"></script>
</head>

<body>
    <div id="calendar"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth', // Default monthly view
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: @json($events), // Pass events from Laravel directly
                eventContent: function(arg) {
                    return {
                        html: `<div style="padding: 5px; background-color: ${arg.event.backgroundColor}; color: ${arg.event.textColor}; border-radius: 5px;">
                                  ${arg.event.title}
                               </div>`
                    };
                },
                eventClick: function(info) {
                    alert('Title: ' + info.event.title + '\nDescription: ' + info.event.extendedProps.description);
                }
            });

            calendar.render();
        });
    </script>
</body>

</html> --}}

{{-- <div class="container">
    <h1>Task Calendar</h1>
    <p>
        Showing tasks for the week of
        <strong>{{ $startOfWeek->format('M d, Y') }}</strong> to
        <strong>{{ $endOfWeek->format('M d, Y') }}</strong>.
    </p>

    <div class="mb-3">
        <!-- Navigation buttons for previous and next weeks -->
        <a href="{{ route('calendar', ['week' => $weekOffset - 1]) }}" class="btn btn-primary">Previous Week</a>
        <a href="{{ route('calendar', ['week' => $weekOffset + 1]) }}" class="btn btn-primary">Next Week</a>
        <a href="{{ route('calendar', ['week' => 0]) }}" class="btn btn-secondary">Current Week</a>
    </div>

    <!-- Task Table -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Task Name</th>
                <th>Description</th>
                <th>Status</th>
                <th>Cage</th>
                <th>Assigned Employee</th>
                <th>Task Time</th>
                <th>Task Frequency</th>
                <th>Start Date</th>
                <th>Culling Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tasks as $task)
            <tr>
                <td>{{ $task->taskName }}</td>
                <td>{{ $task->taskDescription }}</td>
                <td>{{ $task->status }}</td>
                <td>{{ $task->cageName }}</td>
                <td>{{ $task->employeeName ?? 'Unassigned' }}</td>
                <td>{{ $task->taskTime }}</td>
                <td>{{ $task->taskFrequency }}</td>
                <td>{{ $task->start_date }}</td>
                <td>{{ $task->culling_date }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="9" class="text-center">No tasks scheduled for this week.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div> --}}

    <div class="container">
        <h2 class="text-center">Weekly Schedule</h2>
        <div class="d-flex justify-content-between mb-3">
            <a href="{{ route('task-schedulings.calendar', ['week' => $weekOffset - 1]) }}" class="btn btn-primary">Previous Week</a>
            <a href="{{ route('task-schedulings.calendar', ['week' => 0]) }}" class="btn btn-secondary">Current Week</a>
            <a href="{{ route('task-schedulings.calendar', ['week' => $weekOffset + 1]) }}" class="btn btn-primary">Next Week</a>
        </div>

        <div class="d-flex justify-content-between mb-3">
            <span>Week of {{ $startOfWeek->format('M d, Y') }} to {{ $endOfWeek->format('M d, Y') }}</span>
        </div>
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
                                Cage: {{ $task->cageName }}<br>
                                Employee: {{ $task->employeeName ?? 'Unassigned' }}
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
    
    <style>
        .task-item {
        margin-bottom: 5px;
        padding: 10px;
        border-radius: 5px;
        color: #fff;
        font-size: 14px;
        font-weight: bold;
        }
        
        .task-item.collection {
        background-color: #007bff; /* Blue for Collection */
        }
        
        .task-item.feeding {
        background-color: #28a745; /* Green for Feeding */
        }
        
        .task-item.culling {
        background-color: #ffc107; /* Yellow for Culling */
        color: #000; /* Black text for contrast */
        }
        
        .badge {
        display: block;
        font-weight: bold;
        margin-bottom: 5px;
        }
    </style>

@stop  



