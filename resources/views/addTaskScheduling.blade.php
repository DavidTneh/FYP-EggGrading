@extends('admin')

@section('title', 'Add Task Scheduling')

@section('content_header')
    <h1>Add Task Scheduling</h1>
@stop

@section('content')
    <div class="container mt-5">
        <h1>Add New Task Scheduling</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('status'))
            <div class="alert alert-success alert-dismissible">
                <h5><i class="icon fas fa-check"></i> Success!</h5>
                {{ session('status') }}
            </div>
        @endif

        <form action="{{ route('task-schedulings.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="taskName">Task Name</label>
                <input type="text" class="form-control" id="taskName" name="taskName" required>
            </div>

            <div class="form-group">
                <label for="taskDescription">Task Description</label>
                <textarea class="form-control" id="taskDescription" name="taskDescription" required></textarea>
            </div>

            <div class="form-group">
                <label for="collectionPlanID">Egg Collection Plan</label>
                <select class="form-control" id="collectionPlanID" name="collectionPlanID" required>
                    @foreach ($collectionPlans as $plan)
                        <option value="{{ $plan->collectionplanID }}">
                            {{ $plan->time }} - {{ $plan->frequency }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="feedingPlanID">Feeding Plan</label>
                <select class="form-control" id="feedingPlanID" name="feedingPlanID" required>
                    @foreach ($feedingPlans as $plan)
                        <option value="{{ $plan->feedingplanID }}">
                            {{ $plan->time }} - {{ $plan->frequency }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="cullingPlanID">Culling Plan</label>
                <select class="form-control" id="cullingPlanID" name="cullingPlanID" required>
                    @foreach ($cullingPlans as $plan)
                        <option value="{{ $plan->cullingplanID }}">
                            {{ $plan->eliminateAgeThreshold }} weeks - {{ $plan->reasons }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="start_date">Start Date</label>
                <input type="date" class="form-control" id="start_date" name="start_date" min="{{ date('Y-m-d') }}"
                    required>
            </div>

            <div class="form-group">
                <label for="end_date">End Date</label>
                <input type="date" class="form-control" id="end_date" name="end_date" min="{{ date('Y-m-d') }}"
                    required>
            </div>

            <div class="form-group">
                <label for="assignedEmployees">Assigned Employees</label>
                <select class="form-control" id="assignedEmployees" name="assignedEmployees[]" multiple required>
                    @foreach($employees as $employee)
                    <option value="{{ $employee->userID }}">{{ $employee->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-group">
                <label for="cageSchedules">Cages</label>
                <select class="form-control" id="cageSchedules" name="cageSchedules[]" multiple required>
                    @foreach ($cages as $cage)
                        <option value="{{ $cage->cageID }}">{{ $cage->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="Pending">Pending</option>
                    <option value="In Progress">In Progress</option>
                    <option value="Completed">Completed</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success">Create Task Scheduling</button>
        </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const startDateInput = document.getElementById("start_date");
            const endDateInput = document.getElementById("end_date");

            // Set minimum start date to today
            const today = new Date().toISOString().split("T")[0];
            startDateInput.setAttribute("min", today);

            // Update the minimum end date when start date changes
            startDateInput.addEventListener("change", function() {
                const startDate = startDateInput.value;
                endDateInput.setAttribute("min", startDate);
            });

            // Ensure end date is valid after editing
            endDateInput.addEventListener("change", function() {
                const endDate = endDateInput.value;
                const startDate = startDateInput.value;
                if (new Date(endDate) < new Date(startDate)) {
                    endDateInput.value = startDate;
                }
            });
        });

        document.addEventListener("DOMContentLoaded", function () {
    const startDateInput = document.getElementById("start_date");
    const endDateInput = document.getElementById("end_date");
    const feedingPlanSelect = document.getElementById("feedingPlanID");
    const assignedEmployeesSelect = document.getElementById("assignedEmployees");

    function fetchBusyEmployees() {
        const startDate = startDateInput.value;
        const endDate = endDateInput.value;
        const planTime = feedingPlanSelect.options[feedingPlanSelect.selectedIndex]?.text.split(' - ')[0];

        if (startDate && endDate && planTime) {
            fetch(`/fetch-busy-employees?start_date=${startDate}&end_date=${endDate}&plan_time=${planTime}`)
                .then(response => response.json())
                .then(busyEmployees => {
                    updateEmployeeDropdown(busyEmployees);
                })
                .catch(error => console.error("Error fetching busy employees:", error));
        }
    }

    function updateEmployeeDropdown(busyEmployees) {
        for (let option of assignedEmployeesSelect.options) {
            const userID = parseInt(option.value);
            if (busyEmployees.includes(userID)) {
                option.style.color = "red";
                option.disabled = true;
                option.textContent = option.textContent.replace(' (Busy)', '') + ' (Busy)';
            } else {
                option.style.color = "";
                option.disabled = false;
                option.textContent = option.textContent.replace(' (Busy)', '');
            }
        }
    }

    // Event listeners for dynamic updates
    startDateInput.addEventListener("change", fetchBusyEmployees);
    endDateInput.addEventListener("change", fetchBusyEmployees);
    feedingPlanSelect.addEventListener("change", fetchBusyEmployees);
});
    </script>
@stop
