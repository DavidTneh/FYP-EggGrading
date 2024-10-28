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
            ->selectRaw('created_at,MAX(updated_at) as updated_at, type, description, eggGradeID, COUNT(*) as quantity')
            ->groupBy('created_at', 'type', 'description', 'eggGradeID');

        // If start date and end date are provided, filter the results based on the date part of created_at
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
        $eggGrades = EggGrade::all(); // Get all egg grades for the dropdown
        $cages = Cage::all();
        return view('addResults', compact('eggGrades', 'cages'));
    }

    // Store the grading of the egg
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
        // Get the original group criteria from the request
        $createdAt = $request->input('created_at');
        $type = $request->input('type');
        $description = $request->input('description');
        $eggGradeID = $request->input('eggGradeID');

        // Retrieve the current values for the group (take the first item for display)
        $egg = Egg::where('created_at', $createdAt)
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

        return view('/updateResults', compact('egg', 'grades', 'cages', 'quantity'));
    }


    public function batchUpdate(Request $request)
    {
        // Start a transaction to ensure data consistency
        DB::transaction(function () use ($request) {
            // Get the original group criteria from the request
            $receivedDate = $request->input('receivedDate');
            $type = $request->input('type');
            $description = $request->input('description');
            $eggGradeID = $request->input('eggGradeID');

            // Get the new values for the update
            $new_grade = $request->input('new_grade');
            $new_type = $request->input('new_type');
            $new_description = $request->input('new_description'); // fixed to use new_description
            $new_cage = $request->input('new_cage');
            $form_quantity = (int)$request->input('quantity');  // Desired quantity entered in the form
            // dd($receivedDate, $type, $description, $eggGradeID);

            // dd($new_grade, $new_type, $new_description, $new_cage, $form_quantity);
            // Fetch the existing records based on the original criteria using whereDate for created_at


            $eggs = Egg::where('created_at', $receivedDate)
                ->where('type', $type)
                ->where('description', $description)
                ->where('eggGradeID', $eggGradeID)
                ->get();

            $current_quantity = $eggs->count();  // Get current count of matching records

            // 1. Update all existing records with the new values (without changing the quantity)
            Egg::where('created_at', $receivedDate)
                ->where('type', $type)
                ->where('description', $description)
                ->where('eggGradeID', $eggGradeID)
                ->update([
                    'type' => $new_type,
                    'description' => $new_description,
                    'eggGradeID' => $new_grade,
                    'cageID' => $new_cage,
                ]);

            // 2. Adjust the quantity if necessary
            if ($form_quantity > $current_quantity) {
                // Add eggs if the form quantity is greater than the current quantity
                $add_quantity = $form_quantity - $current_quantity;

                for ($i = 0; $i < $add_quantity; $i++) {
                    Egg::create([
                        'type' => $new_type,
                        'description' => $new_description,
                        'eggGradeID' => $new_grade,
                        'cageID' => $new_cage,
                        'created_at' => $receivedDate,  // Ensure the same received date is used
                    ]);
                }
            } elseif ($form_quantity < $current_quantity) {
                // Remove the extra eggs if the form quantity is less than the current quantity
                $remove_quantity = $current_quantity - $form_quantity;

                // Remove the excess eggs from the existing records
                Egg::where('created_at', $receivedDate)
                    ->where('type', $type)
                    ->where('description', $description)
                    ->where('eggGradeID', $eggGradeID)
                    ->orderBy('created_at', 'desc')  // Order by created_at to remove the latest ones
                    ->take($remove_quantity)  // Only remove the excess records
                    ->delete();
            }
        });

        // Redirect after success
        return redirect()->route('/eggResults')->with('success', 'Egg group updated successfully.');
    }

    public function gradeEggs(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'frame1' => 'required|string',
            'frame2' => 'required|string',
        ]);

        try {
            // Get frames from the request
            $frames = $request->only(['frame1', 'frame2']);

            // Decode base64 images
            $frame1 = $this->decodeImage($frames['frame1']);
            $frame2 = $this->decodeImage($frames['frame2']);

            // Process frames with your model
            $grade1 = $this->classifyEgg($frame1);
            $grade2 = $this->classifyEgg($frame2);

            // Determine final grade
            $finalGrade = $this->determineFinalGrade($grade1, $grade2);

            // Optionally, encode processed frames to send back
            $processedFrame1 = base64_encode($frame1); // If you want to return the processed frame
            $processedFrame2 = base64_encode($frame2); // If you want to return the processed frame

            return response()->json([
                'finalGrade' => $finalGrade,
                'processedFrame1' => $processedFrame1,
                'processedFrame2' => $processedFrame2,
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['error' => 'Invalid input: ' . $e->getMessage()], 422);
        } catch (\Exception $e) {
            Log::error("Classification error: " . $e->getMessage());
            return response()->json(['error' => 'An error occurred during grading: ' . $e->getMessage()], 500);
        }
    }

    private function decodeImage($base64)
    {
        // Remove the data URL part
        $base64 = preg_replace('#^data:image/\w+;base64,#i', '', $base64);
        return base64_decode($base64);
    }


    private function classifyEgg($image)
    {
        // Decode and save the image
        $imagePath = storage_path('app/temp_image.jpg');
        $image = request()->input('frame1'); // Assuming you get base64 encoded data
        if (preg_match('/^data:image\/(\w+);base64,/',
            $image,
            $type
        )) {
            $image = substr($image, strpos($image, ',') + 1);
            $image = base64_decode($image);

            // Log the length of the decoded image to see if it's valid
            Log::info("Decoded image data length: " . strlen($image));

            if (file_put_contents($imagePath, $image) === false) {
                Log::error("Failed to save image to $imagePath");
                return -1; // Return an error code
            }
        } else {
            Log::error("Invalid image data.");
            return -1; // Handle the error
        }


        // Prepare the command to run the Python script
        $command = "python public/storage/GradingModel/classify_egg.py " . escapeshellarg($imagePath);

        // Execute the command and get the output
        $output = shell_exec($command . " 2>&1");

        // Check for errors in output
        if ($output === null || trim($output) === '') {
            Log::error("No output received from Python script.");
            return -1; // Return an error code or message
        }

        // Return the grade from the output
        return intval(trim($output)); // Ensure it's returned as an integer
    }




    private function determineFinalGrade($grade1, $grade2)
    {
        return ($grade1 + $grade2) / 2; // Simple averaging; adjust as needed
    }
}
