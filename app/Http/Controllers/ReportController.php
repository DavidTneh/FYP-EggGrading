<?php

namespace App\Http\Controllers;

use App\Models\Egg;
use App\Models\Cage;
use App\Models\Chicken;
use App\Models\EggGrade;
use Illuminate\Http\Request;
use App\Models\TaskStatusLog;
use App\Models\TaskScheduling;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\VaccinationRecords;
use Illuminate\Support\Facades\DB;


class ReportController extends Controller
{
    public function index(Request $request)
    {
        $reportType = $request->get('report_type', 'summary');
        $startDate = $request->get('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->get('end_date', now()->endOfMonth()->toDateString());

        // Egg grades mapping
        $eggGrades = ['A', 'B', 'C', 'D'];

        // Egg production data grouped by date and grade
        $eggProductionData = Egg::selectRaw('DATE(created_at) as date, eggGradeID, COUNT(*) as total_eggs')
        ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date', 'eggGradeID')
            ->orderBy('date', 'ASC')
            ->get();

        $eggChartData = [];
        $formattedEggData = [];

        foreach ($eggProductionData as $data) {
            $date = $data->date;
            $grade = $eggGrades[$data->eggGradeID - 1] ?? 'Unknown';

            // For table
            $formattedEggData[$date][$grade] = $data->total_eggs;

            // For chart
            $eggChartData[$date][$grade] = $data->total_eggs;
        }

        foreach ($formattedEggData as $date => &$grades) {
            foreach ($eggGrades as $grade) {
                $grades[$grade] = $grades[$grade] ?? 0;
            }
        }

        return view('reportManagement', [
            'reportType' => $reportType,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'eggData' => $formattedEggData,
            'eggChartData' => json_encode($eggChartData), // Pass as JSON for chart
            'summaryData' => [
                'totalEggs' => Egg::whereDate('created_at', today())->count(),
                'pendingTasks' => 10,
                'totalChickens' => Chicken::count(),
            ]
        ]);
    }

    public function downloadPDF(Request $request)
    {
        $startDate = $request->get('start_date', now()->startOfMonth());
        $endDate = $request->get('end_date', now()->endOfMonth());

        $eggData = Egg::selectRaw('DATE(created_at) as date, COUNT(*) as total_eggs')
        ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $pdf = Pdf::loadView('pdf.report', ['eggData' => $eggData, 'startDate' => $startDate, 'endDate' => $endDate]);

        return $pdf->download('egg_production_report.pdf');
    }

    public function eggProductionReport()
    {
        // Same as before: Fetch egg production data
        $eggProductionByType = Egg::select('type', DB::raw('COUNT(*) as total'))
        ->groupBy('type')
        ->get();

        $eggGrades = Egg::select('eggGradeID', DB::raw('COUNT(*) as total'))
        ->join('egggrade', 'eggs.eggGradeID', '=', 'egggrade.eggGradeID')
        ->groupBy('eggGradeID')
        ->get();

        $revenueByGrade = Egg::select('eggGradeID', DB::raw('COUNT(*) as total_eggs, SUM(egggrade.price) as total_revenue'))
        ->join('egggrade', 'eggs.eggGradeID', '=', 'egggrade.eggGradeID')
        ->groupBy('eggGradeID')
        ->get();

        return view('reports.eggProduction', compact('eggProductionByType', 'eggGrades', 'revenueByGrade'));
    }

    public function operationalEfficiencyReport()
    {
        // Same as before: Fetch operational efficiency data
        $cageUtilization = Cage::select('name', 'capacity', DB::raw('COUNT(chickens.cageID) as current_occupancy'))
        ->leftJoin('chickens', 'cages.cageID', '=', 'chickens.cageID')
        ->groupBy('cages.cageID')
        ->get();

        $taskCompletion = TaskStatusLog::select('status', DB::raw('COUNT(*) as total_tasks'))
        ->groupBy('status')
        ->get();

        $vaccinationCompliance = Chicken::select(DB::raw('IF(COUNT(vaccination_records.chickenID) > 0, "Compliant", "Non-Compliant") as compliance'), DB::raw('COUNT(*) as total'))
        ->leftJoin('vaccination_records', 'chickens.chickenID', '=', 'vaccination_records.chickenID')
        ->groupBy('compliance')
        ->get();

        return view('reports.operationalEfficiency', compact('cageUtilization', 'taskCompletion', 'vaccinationCompliance'));
    }



    /**
     * Display the Summary Report.
     *
     * @return \Illuminate\View\View
     */
    public function summaryReport()
    {
        $data = [
            'labels' => ['Total Eggs Produced', 'Total Revenue', 'Total Feed Consumed', 'Total Costs', 'Net Profit'],
            'values' => [15000, 7500, 5000, 3000, 4500],
        ];
        return view('summaryReport', compact('data'));
    }

    /** 
     * Display the Details Report.
     *
     * @return \Illuminate\View\View
     */
    public function detailsReport()
    {
        $data = [
            'dates' => ['2024-08-01', '2024-08-02'],
            'total_eggs' => [1000, 950],
            'grade_a' => [600, 550],
            'grade_b' => [300, 280],
        ];
        return view('detailsReport', compact('data'));
    }

    // Controller (for demonstration purposes only)
    public function showReport()
    {
        $cages = [
            (object)[
                'id' => 1,
                'name' => 'Cage 1',
                'size' => 'Large',
                'capacity' => 50,
                'type' => 'Type A',
                'chickens' => [
                    (object)[
                        'id' => 1,
                        'date_of_birth' => now()->subWeeks(5),
                        'breed' => (object)[
                            'name' => 'Breed 1',
                            'gender' => 'Female',
                            'origin' => 'Country A',
                        ]
                    ],
                    (object)[
                        'id' => 2,
                        'date_of_birth' => now()->subWeeks(8),
                        'breed' => (object)[
                            'name' => 'Breed 2',
                            'gender' => 'Male',
                            'origin' => 'Country B',
                        ]
                    ]
                ]
            ],
            (object)[
                'id' => 2,
                'name' => 'Cage 2',
                'size' => 'Medium',
                'capacity' => 30,
                'type' => 'Type B',
                'chickens' => [
                    (object)[
                        'id' => 3,
                        'date_of_birth' => now()->subWeeks(10),
                        'breed' => (object)[
                            'name' => 'Breed 3',
                            'gender' => 'Female',
                            'origin' => 'Country C',
                        ]
                    ]
                ]
            ]
        ];

        return view('detailsReport', compact('cages'));
    }
}
