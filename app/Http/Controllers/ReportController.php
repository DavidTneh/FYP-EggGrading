<?php

namespace App\Http\Controllers;

use App\Models\Egg;
use App\Models\Cage;
use App\Models\Chicken;
use App\Models\EggGrade;
use Illuminate\Http\Request;
use App\Models\TaskScheduling;
use App\Models\TaskStatusLog;
use App\Models\VaccinationRecords;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $reportType = $request->get('report_type', 'summary'); // Default to 'summary'

        // Overall counts
        $totalChickens = Chicken::count();
        $totalVaccinatedChickens = Chicken::whereHas('vaccinationRecords')->count();
        $totalNotVaccinatedChickens = $totalChickens - $totalVaccinatedChickens;

        // Egg trends
        $eggTrends = Egg::selectRaw('DATE(created_at) as date, COUNT(*) as total')
        ->groupBy('date')
        ->orderBy('date', 'DESC')
        ->limit(7)
            ->get()
            ->toArray();       

        // Task breakdown
        $taskStatuses = TaskScheduling::selectRaw('status, COUNT(*) as total')
        ->groupBy('status')
        ->pluck('total', 'status');

        // Cage details
        $cageDetails = Cage::withCount('chickens')
        ->withCount(['chickens as vaccinated_chickens' => function ($query) {
            $query->whereHas('vaccinationRecords');
        }])->get();

        // Summary data
        $summaryData = [
            'totalEggs' => Egg::whereDate('created_at', today())->count(),
            'pendingTasks' => $taskStatuses['pending'] ?? 0,
            'completedTasks' => $taskStatuses['completed'] ?? 0,
            'totalChickens' => $totalChickens,
            'totalCages' => Cage::count(),
            'totalVaccinatedChickens' => $totalVaccinatedChickens,
            'totalNotVaccinatedChickens' => $totalNotVaccinatedChickens,
            'vaccinatedPercentage' => $totalChickens > 0 ? round(($totalVaccinatedChickens / $totalChickens) * 100, 2) : 0,
            'eggTrends' => $eggTrends,
        ];

        $detailsData = [
            'cages' => $cageDetails,
            'taskBreakdown' => $taskStatuses,
        ];


        

        return view('reportManagement', compact('summaryData', 'detailsData', 'reportType'));
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
