<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class HomeController extends Controller
{
    public function index()
    {
        // // Fetch data from the subjects table
        // $subjects = DB::table('subjects')->get();

        // Pass the data to the home view
        return view('home');
    }

    public function create()
    {
        return view('create');
    }

    public function store(Request $request)
    { 
        // // Validate and store the data
        // $validated = $request->validate([
        //     'code' => 'required|string|max:255',
        //     'title' => 'required|string|max:255',
        //     'credit' => 'required|numeric|min:0',
        //     'year' => 'required|integer|min:1|max:5', // Assuming years of study are between 1 and 5
        // ]);

        // // Use the query builder to insert the data into the subjects table
        // DB::table('subjects')->insert([
        //     'code' => $validated['code'],
        //     'title' => $validated['title'],
        //     'credit' => $validated['credit'],
        //     'yearOfStudy' => $validated['year'],
        // ]);

        // return redirect('/home')->with('success', 'Data has been saved successfully!');
    }

    public function edit(string $id)
    {
        // // Fetch the data by id
        // $subjects = DB::table('subjects')->where('code', $id)->first();

        // if (!$subjects) {
        //     return redirect('/home')->with('error', 'Subject not found.');
        // }

        // // Pass the data to the edit view
        // return view('edit', ['subject' => $subjects]);
    }

    public function update(Request $request, string $id)
    {
        // // Validate the data
        // $validated = $request->validate([
        //     'code' => 'required|string|max:255',
        //     'title' => 'required|string|max:255',
        //     'credit' => 'required|numeric|min:0',
        //     'year' => 'required|integer|min:1|max:5', // Assuming years of study are between 1 and 5
        // ]);

        // // Update the data in the subjects table
        // DB::table('subjects')
        //     ->where('code', $id)
        //     ->update([
        //         'code' => $validated['code'],
        //         'title' => $validated['title'],
        //         'credit' => $validated['credit'],
        //         'yearOfStudy' => $validated['year'],
        //     ]);

        // return redirect('/home')->with('success', 'Data has been updated successfully!');
    }
}
