<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FeedingPlan;


class FeedingPlanController extends Controller
{

    // Display a listing of collection plans
    public function index()
    {
        $feedingPlans = FeedingPlan::paginate(10); // Adjust the number as needed
        return view('feedingPlanManagement', compact('feedingPlans'));
    }

    // Show the form for creating a new collection plan
    public function create()
    {
        return view('addFeedingPlan');
    }

    // Store a newly created feeding plan in the database
    public function store(Request $request)
    {
        $validated = $request->validate([
            'time' => 'required|date_format:H:i:s',
            'frequency' => 'required|string|max:255',
            'repeat' => 'required|int'
        ]);

        FeedingPlan::create($validated);

        return redirect()->route('feedingplan.index')->with('success', 'Feeding plan created successfully.');
    }

    // Display the specified feeding plan
    public function show(FeedingPlan $feedingPlan)
    {
        return view('feedingplan.show', compact('feedingPlan'));
    }

    // Show the form for editing the specified feeding plan
    public function edit($feedingplanID)
    {

        $feedingPlan = FeedingPlan::findOrFail($feedingplanID);

        return view('updateFeedingPlan', compact('feedingPlan'));
    }

    // Update the specified collection plan in the database
    public function update(Request $request)
    {
        $request->validate([
            // 'time' => 'required|date_format:H:i:s',
            'frequency' => 'required|string|max:255',
            'repeat' => 'required|boolean'
        ]);

        $id = $request->input('feedingplanID');

        // Process the time input
        $time = $request->input('time');
        if (strlen($time) === 5) {
            $time .= ':00'; // Add seconds if not present
        }

        // Update the collection plan using the update method
        FeedingPlan::where('feedingplanID', $id)->update([
            'time' => $time,
            'frequency' => $request->input('frequency'),
            'repeat' => $request->input('repeat')
        ]);

        return redirect()->route('feedingplan.index')->with('success', 'Feeding plan updated successfully.');
    }

    public function showDelete($feedingplanID)
    {

        $plan = FeedingPlan::findOrFail($feedingplanID);
        return view('/deleteFeedingPlan', compact('plan'));
    }


    public function destroy(Request $request)
    {
        $id = $request->input('feedingplanID');

        // Direct delete using the where clause
        FeedingPlan::where('feedingplanID', $id)->delete();

        return redirect()->route('feedingplan.index')->with('success', 'Feeding plan deleted successfully.');
    }

}
