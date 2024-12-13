@extends('/admin')

@section('content')
    <div class="container mt-5">
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible">
                <h5><i class="icon fas fa-ban"></i> Error!</h5>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Dashboard Cards -->
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card mb-3" style="height: 150px;">
                    <div class="row g-0 h-100">
                        <div class="col-md-4 d-flex align-items-center justify-content-center"
                            style="background-color:#34eb61;">
                            <i class="fas fa-5x fa-egg"></i>
                        </div>
                        <div class="col-md-8 d-flex flex-column">
                            <div class="card-body flex-fill">
                                <h5 class="card-title">Total Eggs Today: {{ $summaryData['totalEggs'] }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-3" style="height: 150px;">
                    <div class="row g-0 h-100">
                        <div class="col-md-4 d-flex align-items-center justify-content-center"
                            style="background-color:#34d5eb;">
                            <i class="fas fa-5x fa-list-ul"></i>
                        </div>
                        <div class="col-md-8 d-flex flex-column">
                            <div class="card-body flex-fill">
                                <h5 class="card-title">Pending Tasks: {{ $summaryData['pendingTasks'] }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-3" style="height: 150px;">
                    <div class="row g-0 h-100">
                        <div class="col-md-4 d-flex align-items-center justify-content-center"
                            style="background-color:#eb346b;">
                            <i class="fas fa-5x fa-drumstick-bite"></i>
                        </div>
                        <div class="col-md-8 d-flex flex-column">
                            <div class="card-body flex-fill">
                                <h5 class="card-title">Total Chickens: {{ $summaryData['totalChickens'] }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Report Dropdown -->
        <div class="container mt-5">
            <div class="mb-4">
                <h4>Select Report</h4>
                <form id="report-form" method="GET" action="{{ route('dashboard.index') }}">
                    <select id="report-select" class="form-select" name="report_type" required>
                        <option value="" disabled selected>Select a report</option>
                        <option value="summary" {{ request('report_type') == 'summary' ? 'selected' : '' }}>Summary Report
                        </option>
                        <option value="details" {{ request('report_type') == 'details' ? 'selected' : '' }}>Details Report
                        </option>
                        <option value="tasks" {{ request('report_type') == 'tasks' ? 'selected' : '' }}>Task Status Report
                        </option>
                    </select>
                    <button type="submit" class="btn btn-success mt-3">View</button>
                </form>
            </div>
        </div>

        <!-- Summary Report Section -->
        @if (request('report_type') === 'summary')
            <h3>Summary Report</h3>
            <canvas id="eggTrendChart"></canvas>
            <canvas id="vaccinationChart"></canvas>
        @endif

        <!-- Details Report Section -->
        @if (request('report_type') === 'details')
            <h3>Details Report</h3>
            <table class="table table-bordered mt-4">
                <thead>
                    <tr>
                        <th>Cage</th>
                        <th>Total Chickens</th>
                        <th>Vaccinated Chickens</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($detailsData['cages'] as $cage)
                        <tr>
                            <td>{{ $cage->name }}</td>
                            <td>{{ $cage->chickens_count }}</td>
                            <td>{{ $cage->vaccinated_chickens }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <!-- Task Status Report Section -->
        @if (request('report_type') === 'tasks')
            <h3>Task Status Report</h3>
            <canvas id="taskStatusChart"></canvas>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        @if (request('report_type') === 'summary')
            // Egg Trends Chart
            const eggTrendCtx = document.getElementById('eggTrendChart').getContext('2d');
            new Chart(eggTrendCtx, {
                type: 'line',
                data: {
                    labels: {!! json_encode(array_column($summaryData['eggTrends'], 'date')) !!},
                    datasets: [{
                        label: 'Eggs Produced',
                        data: {!! json_encode(array_column($summaryData['eggTrends'], 'total')) !!},
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 2,
                        fill: false,
                    }]
                }
            });

            // Vaccination Distribution Chart
            const vaccinationCtx = document.getElementById('vaccinationChart').getContext('2d');
            new Chart(vaccinationCtx, {
                type: 'pie',
                data: {
                    labels: ['Vaccinated Chickens', 'Not Vaccinated Chickens'],
                    datasets: [{
                        data: [
                            {{ $summaryData['totalVaccinatedChickens'] }},
                            {{ $summaryData['totalNotVaccinatedChickens'] }}
                        ],
                        backgroundColor: ['rgba(75, 192, 192, 0.5)', 'rgba(255, 99, 132, 0.5)'],
                        borderColor: ['rgba(75, 192, 192, 1)', 'rgba(255, 99, 132, 1)'],
                        borderWidth: 1
                    }]
                }
            });
        @endif

        @if (request('report_type') === 'tasks')
            // Task Status Chart
            const taskStatusCtx = document.getElementById('taskStatusChart').getContext('2d');
            new Chart(taskStatusCtx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode(array_keys($detailsData['taskBreakdown']->toArray())) !!},
                    datasets: [{
                        label: 'Task Status',
                        data: {!! json_encode(array_values($detailsData['taskBreakdown']->toArray())) !!},
                        backgroundColor: ['rgba(75, 192, 192, 0.5)', 'rgba(255, 159, 64, 0.5)',
                            'rgba(153, 102, 255, 0.5)'
                        ],
                        borderColor: ['rgba(75, 192, 192, 1)', 'rgba(255, 159, 64, 1)',
                            'rgba(153, 102, 255, 1)'
                        ],
                        borderWidth: 1,
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                        }
                    }
                }
            });
        @endif
    </script>
@endsection
