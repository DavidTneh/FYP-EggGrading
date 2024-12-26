@extends('admin')

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

    <!-- Report Form -->
    <form method="GET" class="mb-4">
        <div class="d-flex align-items-center">
            <select class="form-select w-25 me-3" name="report_type">
                <option value="egg_production" selected>Egg Production Report</option>
            </select>
            <label for="start_date" class="me-2">Start Date:</label>
            <input type="date" name="start_date" value="{{ $startDate }}" class="form-control w-25 me-3">
            <label for="end_date" class="me-2">End Date:</label>
            <input type="date" name="end_date" value="{{ $endDate }}" class="form-control w-25 me-3">
            <button type="submit" class="btn btn-success">View</button>
        </div>
    </form>

    <!-- Egg Production Report -->
    @if ($reportType === 'egg_production')
    <h3>Egg Production Breakdown</h3>
    <canvas id="eggProductionChart" height="80"></canvas>

    <table class="table mt-4 table-bordered">
        <thead>
            <tr>
                <th>Date</th>
                <th>Grade A</th>
                <th>Grade B</th>
                <th>Grade C</th>
                <th>Grade D</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($eggData as $date => $grades)
            <tr>
                <td>{{ $date }}</td>
                <td>{{ $grades['A'] ?? 0 }}</td>
                <td>{{ $grades['B'] ?? 0 }}</td>
                <td>{{ $grades['C'] ?? 0 }}</td>
                <td>{{ $grades['D'] ?? 0 }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <button onclick="printReport()" class="btn btn-primary mt-3">Download Report</button>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const chartData = {!! $eggChartData !!};
    const labels = Object.keys(chartData);
    const grades = ['A', 'B', 'C', 'D'];

    const datasets = grades.map((grade, index) => ({
        label: `Grade ${grade}`,
        data: labels.map(date => chartData[date][grade] || 0),
        backgroundColor: `rgba(75, 192, ${index * 64}, 0.5)`,
        borderColor: `rgba(75, 192, ${index * 64}, 1)`,
        borderWidth: 1
    }));

    const ctx = document.getElementById('eggProductionChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: { labels, datasets },
        options: {
            responsive: true,
            plugins: { legend: { position: 'top' } },
            scales: { y: { beginAtZero: true } }
        }
    });

    function printReport() {
        const content = document.body.innerHTML;
        document.body.innerHTML = `
            <style>
                body { font-family: Arial, sans-serif; margin: 0; padding: 20px; }
                table { width: 100%; border-collapse: collapse; }
                th, td { border: 1px solid black; padding: 8px; text-align: center; }
                canvas { margin-bottom: 20px; }
            </style>
            <h1>Egg Production Report</h1>
            ${document.querySelector('canvas').outerHTML}
            ${document.querySelector('table').outerHTML}
        `;
        window.print();
        document.body.innerHTML = content;
    }
</script>
@endsection