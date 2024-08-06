<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
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

    /**
     * Display the Exception Report.
     *
     * @return \Illuminate\View\View
     */
    public function exceptionReport()
    {
        $data = [
            'dates' => ['2024-08-01', '2024-08-02'],
            'exceptions' => [5, 2], // Example data for exceptions
        ];
        return view('reports.exception-report', compact('data'));
    }

    // Controller (for demonstration purposes only)
public function showReport() {
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
