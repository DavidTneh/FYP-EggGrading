@extends('/admin')

@section('content')
<div class="container mt-5">
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
                            <h5 class="card-title">Total Eggs Today: {{ $summaryData['totalEggs'] ?? '0' }}</h5>
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
                            <h5 class="card-title">Pending Tasks: {{ $summaryData['pendingTasks'] ?? '0' }}</h5>
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
                            <h5 class="card-title">Total Chickens: {{ $summaryData['totalChickens'] ?? '0' }}</h5>
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
                    <option value="summary" {{ request('report_type')=='summary' ? 'selected' : '' }}>Summary Report
                    </option>
                    <option value="details" {{ request('report_type')=='details' ? 'selected' : '' }}>Details Report
                    </option>
                </select>
                <button type="submit" class="btn btn-success mt-3">View</button>
            </form>
        </div>
    </div>

    <!-- Summary Report Section -->
    @if(request('report_type') === 'summary')
    <h3>Summary Report</h3>
    <canvas id="summaryChart"></canvas>
    <table class="table table-bordered mt-4">
        <thead>
            <tr>
                <th>Metric</th>
                <th>Value</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Total Chickens</td>
                <td>{{ $summaryData['totalChickens'] ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Total Cages</td>
                <td>{{ $summaryData['totalCages'] ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Total Vaccinated Chickens</td>
                <td>{{ $summaryData['totalVaccinatedChickens'] ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Vaccinated Percentage</td>
                <td>{{ $summaryData['vaccinatedPercentage'] ?? '0' }}%</td>
            </tr>
        </tbody>
    </table>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    @if(request('report_type') === 'summary')
    const summaryCtx = document.getElementById('summaryChart').getContext('2d');
    new Chart(summaryCtx, {
        type: 'pie',
        data: {
            labels: ['Vaccinated Chickens', 'Not Vaccinated Chickens'],
            datasets: [{
                label: 'Vaccination Distribution',
                data: [
                    {{ $summaryData['totalVaccinatedChickens'] ?? 0 }},
                    {{ $summaryData['totalNotVaccinatedChickens'] ?? 0 }}
                ],
                backgroundColor: ['rgba(75, 192, 192, 0.5)', 'rgba(255, 99, 132, 0.5)'],
                borderColor: ['rgba(75, 192, 192, 1)', 'rgba(255, 99, 132, 1)'],
                borderWidth: 1
            }]
        }
    });
    @endif
</script>
@endsection