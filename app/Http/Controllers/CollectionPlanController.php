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

        return redirect()->route('/collectionplan')->with('success', 'Collection plan created successfully.');
    }

    // Display the specified collection plan
    public function show(CollectionPlan $collectionPlan)
    {
        return view('collectionplan.show', compact('collectionPlan'));
    }

    // Show the form for editing the specified collection plan
    public function edit(CollectionPlan $collectionPlan)
    {
        return view('updateCollectionPlan', compact('collectionPlan'));
    }

    // Update the specified collection plan in the database
    public function update(Request $request, CollectionPlan $collectionPlan)
    {
        $validated = $request->validate([
            'time' => 'required|date_format:H:i:s',
            'frequency' => 'required|string|max:255',
            'repeat' => 'required|boolean'
        ]);

        $collectionPlan->update($validated);

        return redirect()->route('collectionplan.index')->with('success', 'Collection plan updated successfully.');
    }

    // Remove the specified collection plan from the database
    public function destroy(CollectionPlan $collectionPlan)
    {
        $collectionPlan->delete();

        return redirect()->route('collectionplan.index')->with('success', 'Collection plan deleted successfully.');
    }
}
