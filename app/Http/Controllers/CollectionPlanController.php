<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CollectionPlan;

class CollectionPlanController extends Controller
{
    // Display a listing of collection plans
    public function index()
    {
        $collectionPlans = CollectionPlan::paginate(10); // Adjust the number as needed
        return view('collectionPlanManagement', compact('collectionPlans'));
    }

    // Show the form for creating a new collection plan
    public function create()
    {
        return view('addCollectionPlan');
    } 

    // Store a newly created collection plan in the database
    public function store(Request $request)
    {
        $validated = $request->validate([
            'time' => 'required|date_format:H:i:s',
            'frequency' => 'required|string|max:255',
            'repeat' => 'required|int'
        ]);

        CollectionPlan::create($validated);

        return redirect()->route('collectionplan.index')->with('success', 'Collection plan created successfully.');
    }

    // Display the specified collection plan
    public function show(CollectionPlan $collectionPlan)
    {
        return view('collectionplan.show', compact('collectionPlan'));
    }

    // Show the form for editing the specified collection plan
    public function edit($collectionplanID)
    {

        $collectionPlan = CollectionPlan::findOrFail($collectionplanID);

        return view('updateCollectionPlan', compact('collectionPlan'));
    }

    // Update the specified collection plan in the database
    public function update(Request $request)
    {
        $request->validate([
            // 'time' => 'required|date_format:H:i:s',
            'frequency' => 'required|string|max:255',
            'repeat' => 'required|boolean'
        ]);

        $id = $request->input('collectionplanID');

        // Process the time input
        $time = $request->input('time');
        if (strlen($time) === 5) {
            $time .= ':00'; // Add seconds if not present
        }

        // Update the collection plan using the update method
        CollectionPlan::where('collectionplanID', $id)->update([
            'time' => $time,
            'frequency' => $request->input('frequency'),
            'repeat' => $request->input('repeat')
        ]);

        return redirect()->route('collectionplan.index')->with('success', 'Collection plan updated successfully.');
    }

    public function showDelete($collectionplanID)
    {

        $plan = CollectionPlan::findOrFail($collectionplanID);
        return view('/deleteCollectionPlan', compact('plan'));
    }


    public function destroy(Request $request)
    {
        $id = $request->input('collectionplanID');

        // Direct delete using the where clause
        CollectionPlan::where('collectionplanID', $id)->delete();

        return redirect()->route('collectionplan.index')->with('success', 'Collection plan deleted successfully.');
    }


}
