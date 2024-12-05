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
        $reportType = $request->get('report_type');

        $summaryData = [
            'totalEggs' => Egg::count(),
            'pendingTasks' => TaskScheduling::where('status', 'pending')->count(),
            'totalChickens' => Chicken::count(),
            'totalCages' => Cage::count(),
            'totalVaccinatedChickens' => VaccinationRecords::distinct('chickenID')->count(),
            'totalEggsByGrade' => EggGrade::join('eggs', 'eggs.eggGradeID', '=', 'egggrade.eggGradeID')
            ->select('egggrade.grade', DB::raw('COUNT(eggs.eggsID) as total'))
            ->groupBy('egggrade.grade')
            ->get()
        ];

        $detailsData = [
            'cageDetails' => Chicken::join('cage', 'chicken.cageID', '=', 'cage.cageID')
            ->join('chickenbreeds', 'chicken.breedID', '=', 'chickenbreeds.breedID')
            ->select('cage.name as cage_name', 'chickenbreeds.name as breed_name', DB::raw('COUNT(chicken.chickenID) as total_chickens'))
            ->groupBy('cage.name', 'chickenbreeds.name')
            ->get(),
            'cageNames' => Cage::pluck('name'),
            'cageChickenCounts' => Cage::withCount('chickens')->pluck('chickens_count')
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
