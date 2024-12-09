<?php

namespace App\Http\Controllers;

use App\Models\Egg;
use App\Models\Cage;
use App\Models\Chicken;
use App\Models\EggGrade;
use Illuminate\Http\Request;
use App\Models\TaskScheduling;
use App\Models\VaccinationRecords;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $reportType = $request->get('report_type', 'summary'); // Default to 'summary'

        $totalChickens = Chicken::count();
        $totalVaccinatedChickens = Chicken::whereHas('vaccinationRecords')->count();
        $totalNotVaccinatedChickens = $totalChickens - $totalVaccinatedChickens;

        $summaryData = [
            'totalEggs' => Egg::whereDate('created_at', today())->count(),
            'pendingTasks' => TaskScheduling::where('status', 'pending')->count(),
            'totalChickens' => $totalChickens,
            'totalCages' => Cage::count(),
            'totalVaccinatedChickens' => $totalVaccinatedChickens,
            'totalNotVaccinatedChickens' => $totalNotVaccinatedChickens,
            'vaccinatedPercentage' => $totalChickens > 0 ? round(($totalVaccinatedChickens / $totalChickens) * 100, 2) : 0,
        ];

        $detailsData = [
            'cageNames' => Cage::pluck('name')->toArray(),
            'cageChickenCounts' => Cage::withCount('chickens')->pluck('chickens_count')->toArray(),
            'cages' => Cage::withCount(['chickens', 'chickens as vaccinated_chickens' => function ($query) {
                $query->whereHas('vaccinationRecords');
            }])->get(),
        ];

        return view('reportManagement', compact('summaryData', 'detailsData', 'reportType'));
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
