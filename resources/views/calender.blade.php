@extends('/admin')

@section('title', 'Task Schedule Calendar')

@section('content_header')
    <h1>Task Schedule Calendar</h1>
@stop

@section('content')
<div class="container" style="width: 100%; margin-top: 20px;">
    <div class="row">
        <div class="col-md-12 mt-5">
            <h1 class="mt-5">Weekly Task Calendar Week 1 August</h1>
            <div id="calendar"></div>
        </div>
    </div>

    <h1>Calendar with Tasks</h1>
    <table class="table table-bordered" style="background-color: #fff; width: 100%;">
        <thead class="thead-light">
            <tr>
                <th style="border: 1px solid #dee2e6; padding: 10px; background-color:#007bff; color: white;">Time</th>
                <th style="border: 1px solid #dee2e6; padding: 10px; background-color:#28a745; color: white;">Sunday</th>
                <th style="border: 1px solid #dee2e6; padding: 10px; background-color:#28a745; color: white;">Monday</th>
                <th style="border: 1px solid #dee2e6; padding: 10px; background-color:#28a745; color: white;">Tuesday</th>
                <th style="border: 1px solid #dee2e6; padding: 10px; background-color:#28a745; color: white;">Wednesday</th>
                <th style="border: 1px solid #dee2e6; padding: 10px; background-color:#28a745; color: white;">Thursday</th>
                <th style="border: 1px solid #dee2e6; padding: 10px; background-color:#28a745; color: white;">Friday</th>
                <th style="border: 1px solid #dee2e6; padding: 10px; background-color:#28a745; color: white;">Saturday</th>
            </tr>
        </thead>
        <tbody>
            @for ($hour = 8; $hour <= 17; $hour++)
                <tr style="height: 60px;">
                    <td style="border: 1px solid #dee2e6; padding: 5px; background-color: #f8f9fa;">{{ $hour }}:00 - {{ $hour + 1 }}:00</td>
                    <td style="border: 1px solid #dee2e6; padding: 5px;">
                        @if ($hour == 9)
                            <div class="task" style="background-color: #ffc107; padding: 5px; border-radius: 5px;">Task 1: Eggs Collection</div>
                        @endif
                    </td>
                    <td style="border: 1px solid #dee2e6; padding: 5px;">
                        @if ($hour == 10)
                            <div class="task" style="background-color: #ffc107; padding: 5px; border-radius: 5px;">Task 2: Start Grading</div>
                            <div class="task" style="background-color: #ffc107; padding: 5px; border-radius: 5px;">Task 3: Feeding</div>
                        @endif
                    </td>
                    <td style="border: 1px solid #dee2e6; padding: 5px;">
                        @if ($hour == 11)
                            <div class="task" style="background-color: #ffc107; padding: 5px; border-radius: 5px;">Task 4: Vaccination</div>
                        @endif
                    </td>
                    <td style="border: 1px solid #dee2e6; padding: 5px;">
                        @if ($hour == 12)
                            <div class="task" style="background-color: #ffc107; padding: 5px; border-radius: 5px;">Task 5: Feeding</div>
                        @endif
                    </td>
                    <td style="border: 1px solid #dee2e6; padding: 5px;">
                        @if ($hour == 14)
                            <div class="task" style="background-color: #ffc107; padding: 5px; border-radius: 5px;">Task 6: Egg Packing</div>
                        @endif
                    </td>
                    <td style="border: 1px solid #dee2e6; padding: 5px;">
                        @if ($hour == 15)
                            <div class="task" style="background-color: #ffc107; padding: 5px; border-radius: 5px;">Task 7: Checking on Chicken</div>
                        @endif
                    </td>
                    <td style="border: 1px solid #dee2e6; padding: 5px;">
                        @if ($hour == 16)
                            <div class="task" style="background-color: #ffc107; padding: 5px; border-radius: 5px;">Task 8: Team Training</div>
                        @endif
                    </td>
                </tr>
            @endfor
        </tbody>
    </table>
</div>
@stop
