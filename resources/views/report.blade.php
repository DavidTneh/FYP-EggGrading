<!DOCTYPE html>
<html>

<head>
    <title>Egg Production Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h1,
        h3 {
            text-align: center;
        }

        .logo {
            text-align: center;
            margin-bottom: 10px;
        }

        .info {
            margin-bottom: 20px;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 8px;
            text-align: center;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 0.9em;
        }
    </style>
</head>

<body>
    <!-- Logo -->
    <div class="logo">
        <img src="{{ $logo }}" alt="EggGrade Pro Logo" height="80">
    </div>

    <!-- Title -->
    <h1>Egg Production Report</h1>

    <!-- Report Information -->
    <div class="info">
        <p><strong>Duration:</strong> {{ $startDate }} to {{ $endDate }}</p>
        <p><strong>Generated Time:</strong> {{ $generatedTime }}</p>
    </div>

    <!-- Summary -->
    <h3>Summary</h3>
    <table>
        <tr>
            <th>Total Eggs Produced</th>
        </tr>
        <tr>
            <td>{{ $summary['totalEggs'] }}</td>
        </tr>
    </table>

    <!-- Egg Production Data -->
    <h3>Egg Production Breakdown</h3>
    <table>
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
                <td>{{ $grades['A'] }}</td>
                <td>{{ $grades['B'] }}</td>
                <td>{{ $grades['C'] }}</td>
                <td>{{ $grades['D'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Footer -->
    <div class="footer">
        <p>EggGrade Pro - Your Trusted Egg Production Management System</p>
    </div>
</body>

</html>