<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Egg;
use App\Models\EggGrade;

class EggGradingController extends Controller
{
    public function index(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        // Build the query to include type, description, and egg_grade_id with a count of quantity
        $query = Egg::with('eggGrade')
            ->selectRaw('type, description, eggGradeID, COUNT(*) as quantity')
            ->groupBy('type', 'description', 'eggGradeID');

        // If start date and end date are provided, filter the results
        if ($start_date && $end_date) {
            $query->whereBetween('received_date', [$start_date, $end_date]);
        }

        // Paginate the results
        $eggs = $query->paginate(10);  // Paginate 10 items per page

        return view('/eggResults', compact('eggs'));
    }




    // Show the form for grading a new egg
    public function create()
    {
        $eggGrades = EggGrade::all(); // Get all egg grades for the dropdown
        return view('egg_grading.create', compact('eggGrades'));
    }

    // Store the grading of the egg
    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'egg_weight' => 'required|numeric',
            'egg_color' => 'required|string|max:255',
            'egg_grade' => 'required|exists:egg_grades,id',
            'received_date' => 'required|date', // Ensure the received date is provided
        ]);

        // Create a new egg record
        $egg = new Egg();
        $egg->weight = $request->input('egg_weight');
        $egg->color = $request->input('egg_color');
        $egg->received_date = $request->input('received_date'); // Store received date
        $egg->eggGrade()->associate($request->input('egg_grade'));
        $egg->save();

        return redirect()->route('/eggResults')->with('success', 'Egg graded successfully');
    }

    // Show the form for editing the grade of an existing egg
    public function edit($id)
    {
        $egg = Egg::findOrFail($id);
        $eggGrades = EggGrade::all(); // Get all egg grades for the dropdown
        return view('egg_grading.edit', compact('egg', 'eggGrades'));
    }

    // Update the grading of the egg
    public function update(Request $request, $id)
    {
        // Validate the incoming request
        $request->validate([
            'egg_weight' => 'required|numeric',
            'egg_color' => 'required|string|max:255',
            'egg_grade' => 'required|exists:egg_grades,id',
            'received_date' => 'required|date', // Ensure the received date is provided
        ]);

        // Find the egg and update its details
        $egg = Egg::findOrFail($id);
        $egg->weight = $request->input('egg_weight');
        $egg->color = $request->input('egg_color');
        $egg->received_date = $request->input('received_date'); // Update received date
        $egg->eggGrade()->associate($request->input('egg_grade'));
        $egg->save();

        return redirect()->route('/eggResults')->with('success', 'Egg grading updated successfully');
    }

    // Delete a graded egg record
    public function destroy($id)
    {
        $egg = Egg::findOrFail($id);
        $egg->delete();

        return redirect()->route('/eggResults')->with('success', 'Egg record deleted successfully');
    }
}
