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

<div class="container">
    <h2>Week: {{ \Carbon\Carbon::now()->startOfWeek()->format('M d') }} - {{
        \Carbon\Carbon::now()->endOfWeek()->format('M d') }}</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Date</th>
                <th>Time</th>
                <th>Task Name</th>
                <th>Description</th>
                <th>Frequency</th>
                <th>Cage</th>
                <th>Employee(s)</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tasks as $task)
            <tr>
                <td>{{ \Carbon\Carbon::parse($task->scheduleDate)->format('Y-m-d') }}</td>
                <td>{{ $task->taskTime }}</td>
                <td>{{ $task->taskName }}</td>
                <td>{{ $task->taskDescription }}</td>
                <td>{{ $task->taskFrequency }}</td>
                <td>{{ $task->cageName }}</td>
                <td>{{ $task->employeeName ?? 'Unassigned' }}</td>
                <td>{{ ucfirst($task->status) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@stop  



