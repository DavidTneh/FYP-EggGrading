@extends('/admin')

@section('content')
<div class="container mt-5">
    <!-- Dashboard Cards -->
    <div class="row g-4">
        <!-- Card 1 -->
        <div class="col-md-4">
            <div class="card mb-3" style="height: 150px;">
                <div class="row g-0 h-100">
                    <div class="col-md-4 d-flex align-items-center justify-content-center"
                        style="background-color:#34eb61;">
                        <i class="fas fa-5x fa-egg"></i>
                    </div>
                    <div class="col-md-8 d-flex flex-column">
                        <div class="card-body flex-fill">
                            <h5 class="card-title">Total Egg Today: {{ $summaryData['totalEggs'] ?? '0' }}</h5>
                            <p class="card-text"><small class="text-body-secondary">Last updated 3 mins ago</small></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 2 -->
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
                            <p class="card-text"><small class="text-body-secondary">Last updated 3 mins ago</small></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 3 -->
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
                            <p class="card-text"><small class="text-body-secondary">Last updated 3 mins ago</small></p>
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

    <!-- Report Section -->
    <div id="report-section" class="container mt-5">
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
            </tbody>
        </table>
        @elseif(request('report_type') === 'details')
        <h3>Details Report</h3>
        <canvas id="detailsChart"></canvas>
        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>Cage Name</th>
                    <th>Breed Name</th>
                    <th>Total Chickens</th>
                </tr>
            </thead>
            <tbody>
                @foreach($detailsData['cageDetails'] ?? [] as $detail)
                <tr>
                    <td>{{ $detail->name ?? 'N/A' }}</td>
                    <td>{{ $detail->breed_name ?? 'N/A' }}</td>
                    <td>{{ $detail->total_chickens }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    @if(request('report_type') === 'summary')
    const summaryCtx = document.getElementById('summaryChart').getContext('2d');
    const summaryChart = new Chart(summaryCtx, {
        type: 'bar',
        data: {
            labels: ['Total Chickens', 'Total Cages', 'Vaccinated Chickens'],
            datasets: [{
                label: 'Summary Data',
                data: [
                    {{ $summaryData['totalChickens'] ?? 0 }},
                    {{ $summaryData['totalCages'] ?? 0 }},
                    {{ $summaryData['totalVaccinatedChickens'] ?? 0 }}
                ],
                backgroundColor: ['rgba(75, 192, 192, 0.2)', 'rgba(54, 162, 235, 0.2)', 'rgba(255, 206, 86, 0.2)'],
                borderColor: ['rgba(75, 192, 192, 1)', 'rgba(54, 162, 235, 1)', 'rgba(255, 206, 86, 1)'],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    @elseif(request('report_type') === 'details')
    const detailsCtx = document.getElementById('detailsChart').getContext('2d');
    const detailsChart = new Chart(detailsCtx, {
        type: 'pie',
        data: {
            labels: @json($detailsData['cageNames'] ?? []),
            datasets: [{
                label: 'Chickens per Cage',
                data: @json($detailsData['cageChickenCounts'] ?? []),
                backgroundColor: [
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(255, 99, 132, 0.2)'
                ],
                borderColor: [
                    'rgba(75, 192, 192, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(255, 99, 132, 1)'
                ],
                borderWidth: 1
            }]
        }
    });
    @endif
</script>
@endsection