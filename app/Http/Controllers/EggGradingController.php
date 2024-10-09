<?php

namespace App\Http\Controllers;

use App\Models\Egg;
use App\Models\Cage;
use App\Models\EggGrade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EggGradingController extends Controller
{
    public function index(Request $request)
    {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        // Build the query to group by type, description, eggGradeID, and full created_at (not just the date part)
        $query = Egg::with('eggGrade')
            ->selectRaw('created_at, updated_at, type, description, eggGradeID, COUNT(*) as quantity')
            ->groupBy('created_at', 'updated_at', 'type', 'description', 'eggGradeID');

        // If start date and end date are provided, filter the results based on the date part of the created_at field
        if ($start_date && $end_date) {
            $query->whereBetween(DB::raw('DATE(created_at)'), [$start_date, $end_date]);
        }

        // Paginate the results
        $eggs = $query->paginate(10);  // Paginate 10 items per page

        return view('/eggResults', compact('eggs'));
    }




    // Show the form for grading a new egg
    public function create()
    {
        // Get all cages and grades
        $cages = Cage::all();
        $grades = EggGrade::all();  // Fetch all available grades from the grades table

        // Pass cages and grades to the view
        return view('addResults', compact('cages', 'grades'));
    }

    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'gradeID' => 'required|exists:egggrade,eggGradeID',  // Ensure the selected grade exists
            'type' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'cageID' => 'required|exists:cage,cageID',  // Ensure the selected cage exists
            'quantity' => 'required|integer|min:1',  // Ensure quantity is at least 1
        ]);



        // Retrieve the number of records to insert based on quantity
        $quantity = $request->input('quantity');

        // Store multiple egg grading records based on the quantity
        for ($i = 0; $i < $quantity; $i++) {
            Egg::create([
                'eggGradeID' => $request->input('gradeID'),  // Save the selected grade
                'type' => $request->input('type'),
                'description' => $request->input('description'),
                'cageID' => $request->input('cageID'),
            ]);
        }

        return redirect()->route('/eggResults')->with('success', 'Egg grading added successfully.');
    }



    // Show the form for editing the grade of an existing egg
    public function edit($id)
    {
        $egg = Egg::findOrFail($id);
        $eggGrades = EggGrade::all(); // Get all egg grades for the dropdown
        $cage = Cage::all();
        return view('egg_grading.batchEdit', compact('egg', 'eggGrades', 'cage'));
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

    public function batchDelete(Request $request)
    {
        // Get the group criteria from the request
        $receivedDate = $request->input('created_at');
        $type = $request->input('type');
        $description = $request->input('description');
        $eggGradeID = $request->input('eggGradeID');

        // Delete all eggs in the group
        Egg::where('created_at', $receivedDate)
            ->where('type', $type)
            ->where('description', $description)
            ->where('eggGradeID', $eggGradeID)
            ->delete();

        return redirect()->back()->with('success', 'Egg group deleted successfully.');
    }

    public function batchEdit(Request $request)
    {
        // Get the original group criteria from the URL parameters (query string)
        $createdAt = trim($request->query('created_at'));  // Trim any extra whitespace
        $type = trim($request->query('type'));  // Trim any extra whitespace
        $description = trim($request->query('description'));  // Trim any extra whitespace
        $eggGradeID = (int) $request->query('eggGradeID');  // Cast eggGradeID to integer

        // Retrieve the current values for the group (take the first item for display)
        $egg = Egg::where('created_at', $createdAt)  // Match full created_at including time
            ->where('type', $type)
            ->where('description', $description)
            ->where('eggGradeID', $eggGradeID)
            ->first();

        // Get the count of eggs in this group (quantity)
        $quantity = Egg::where('created_at', $createdAt)
            ->where('type', $type)
            ->where('description', $description)
            ->where('eggGradeID', $eggGradeID)
            ->count();

        // Get available grades and cages from the database
        $grades = EggGrade::all();
        $cages = Cage::all();

        // Debugging to see if the query is correct
        // dd($egg, $quantity);

        return view('/updateResults', compact('egg', 'grades', 'cages', 'quantity'));
    }



    public function batchUpdate(Request $request)
    {
        DB::transaction(function () use ($request) {
            // Get the original group criteria from the request
            $receivedDate = $request->input('receivedDate');  // Full timestamp, use this to match the group
            $type = $request->input('type');
            $description = $request->input('description');
            $eggGradeID = $request->input('eggGradeID');

            // Get the new values for the update
            $new_grade = $request->input('new_grade');
            $new_type = $request->input('new_type');
            $new_description = $request->input('new_description');
            $new_cage = $request->input('new_cage');
            $form_quantity = $request->input('quantity');  // Desired quantity entered in the form

            // Fetch the existing records based on the original criteria (match exact timestamp and other fields)
            $eggs = Egg::where('created_at', $receivedDate)  // Full timestamp matching
                ->where('type', $type)
                ->where('description', $description)
                ->where('eggGradeID', $eggGradeID)
                ->get();

            $current_quantity = $eggs->count();  // Get current count of matching records

            // 1. Update all existing records with the new values (up to the form quantity)
            foreach ($eggs as $egg) {
                $egg->type = $new_type;
                $egg->description = $new_description;
                $egg->eggGradeID = $new_grade;
                $egg->cageID = $new_cage;
                // Do NOT update created_at
                $egg->save();  // Save changes for each egg (Laravel will automatically update the updated_at timestamp)
            }

            // 2. If the form quantity is greater than the current quantity, add missing eggs
            if ($form_quantity > $current_quantity) {
                $add_quantity = $form_quantity - $current_quantity;

                // Instead of creating new records, update the quantity field on an existing record
                $first_egg = $eggs->first();  // Select the first egg to update its quantity
                if ($first_egg) {
                    // Add the additional quantity to the first egg
                    for ($i = 0; $i < $add_quantity; $i++) {
                        Egg::create([
                            'type' => $new_type,
                            'description' => $new_description,
                            'eggGradeID' => $new_grade,
                            'cageID' => $new_cage,
                            'created_at' => $receivedDate,  // Set the same created_at as the original records
                            'updated_at' => now(),  // Laravel will automatically set updated_at
                        ]);
                    }
                }
            }

            // 3. If the form quantity is less than the current quantity, delete the extra records
            elseif ($form_quantity < $current_quantity) {
                $remove_quantity = $current_quantity - $form_quantity;

                // Fetch the excess records that need to be deleted
                $eggs_to_remove = Egg::where('created_at', $receivedDate)  // Full timestamp matching
                    ->where('type', $type)
                    ->where('description', $description)
                    ->where('eggGradeID', $eggGradeID)
                    ->skip($form_quantity)  // Skip the records that are meant to be updated
                    ->take($remove_quantity)  // Only target the records that need to be removed
                    ->get();

                foreach ($eggs_to_remove as $egg) {
                    $egg->delete();  // Delete each excess egg
                }
            }
        });

        // Redirect after success
        return redirect()->route('/eggResults')->with('success', 'Egg group updated successfully.');
    }



}
