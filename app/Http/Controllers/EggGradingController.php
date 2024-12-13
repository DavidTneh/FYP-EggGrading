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
        try {
            // Validate the input dates
            $validatedData = $request->validate([
                'start_date' => 'nullable|date', // Optional, must be a valid date
                'end_date' => 'nullable|date|after_or_equal:start_date', // Optional, must be after or equal to start_date
            ], [
                'start_date.date' => 'The start date must be a valid date.',
                'end_date.date' => 'The end date must be a valid date.',
                'end_date.after_or_equal' => 'The end date must be after or equal to the start date.',
            ]);

            // Get validated input
            $start_date = $validatedData['start_date'] ?? null;
            $end_date = $validatedData['end_date'] ?? null;

            // Build the query
            $query = Egg::with('eggGrade')
            ->selectRaw('DATE(created_at) as date, MAX(updated_at) as updated_at, type, description, eggGradeID, COUNT(*) as quantity')
            ->groupBy(DB::raw('DATE(created_at)'), 'type', 'description', 'eggGradeID');

            // Filter results based on dates if provided
            if ($start_date && $end_date) {
                $query->whereBetween(DB::raw('DATE(created_at)'), [$start_date, $end_date]);
            }

            // Paginate results
            $eggs = $query->paginate(10);

            // Return the view with paginated results
            return view('/eggResults', compact('eggs'));
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors
            return back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            // Log the exception and show a generic error message
            Log::error("Error in EggGradingController@index: " . $e->getMessage());
            return back()->withErrors('An unexpected error occurred while fetching egg records. Please try again later.');
        }
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

        // Delete all eggs in the group based on the date (ignoring time)
        Egg::whereDate('created_at', $receivedDate)  // Only compares the date part
            ->where('type', $type)
            ->where('description', $description)
            ->where('eggGradeID', $eggGradeID)
            ->delete();

        return redirect()->back()->with('success', 'Egg group deleted successfully.');
    }


    public function batchEdit(Request $request)
    {
        // Get the original group criteria from the request
        $createdAt = $request->input('created_at');  // Date part of created_at
        $type = $request->input('type');
        $description = $request->input('description');
        $eggGradeID = $request->input('eggGradeID');

        // Retrieve the current values for the group (take the first item for display)
        $egg = Egg::whereDate('created_at', $createdAt)  // Only compares the date part
            ->where('type', $type)
            ->where('description', $description)
            ->where('eggGradeID', $eggGradeID)
            ->first();

        // Get the count of eggs in this group (quantity)
        $quantity = Egg::whereDate('created_at', $createdAt)  // Only compares the date part
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

            if ($form_quantity == $current_quantity){
                // dd("Im here");
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
            }
 
            // 2. Adjust the quantity if necessary
            if ($form_quantity > $current_quantity) {
                // Add eggs if the form quantity is greater than the current quantity
                $add_quantity = $form_quantity - $current_quantity;
                // dd($add_quantity);
                for ($i = 0; $i < $add_quantity; $i++) {
                    Egg::create([
                        'type' => $new_type,
                        'description' => $new_description,
                        'eggGradeID' => $new_grade,
                        'cageID' => $new_cage,
                        'created_at' => $receivedDate,  //Ensure the same received date is used
                    ]);
                }

            } elseif ($form_quantity < $current_quantity) {
                // Remove the extra eggs if the form quantity is less than the current quantity
                $remove_quantity = $current_quantity - $form_quantity;
                // dd($remove_quantity);

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

    public function eggGrading(Request $request)
    {
        $cages = Cage::all();
        return view('eggGrading', compact('cages'));
    }


    public function gradeEggs(Request $request)
    {
        Log::info("At gradeEggs: Line235");

        try {
            $frames = $request->only(['frame1', 'frame2']);
            $cageID = $request->input('cageID');

            if (!$cageID) {
                throw new \Exception("Cage ID is required for grading.");
            }

            // Decode base64 images
            $frame1Path = $this->decodeImage($frames['frame1']);
            $frame2Path = $this->decodeImage($frames['frame2']);

            // Process frames with the model
            $grade1 = $this->classifyEgg($frame1Path);
            $grade2 = $this->classifyEgg($frame2Path);

            Log::info("Grade Checking 1: " . $grade1);
            Log::info("Grade Checking 2: " . $grade2);

            // Determine final grade
            $finalGrade = $this->determineFinalGrade($grade1, $grade2, $cageID);

            // Delete temporary images
            $this->deleteImage($frame1Path);
            $this->deleteImage($frame2Path);

            return response()->json([
                'grade1' => $grade1,
                'grade2' => $grade2,
                'finalGrade' => $finalGrade
            ]);
        } catch (\Exception $e) {
            Log::error("Error in grading: " . $e->getMessage());
            return response()->json(['error' => 'An error occurred during grading.'], 500);
        }
    }


    private function deleteImage($imagePath)
    {
        if (file_exists($imagePath)) {
            unlink($imagePath);
            Log::info("Image deleted: " . $imagePath);
        } else {
            Log::warning("Image not found for deletion: " . $imagePath);
        }
    }

 

    private function decodeImage($base64)
    {
        // Remove the data URL part
        $base64 = preg_replace('#^data:image/\w+;base64,#i', '', $base64);

        $imageData = base64_decode($base64);
        if ($imageData === false) {
            throw new \Exception("Failed to decode base64 image.");
        }

        // Define the save path for the decoded image
        $directory = storage_path('temp_image');
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }
        
        $imagePath = $directory . '/temp_image.jpg';

        // Save the decoded image
        if (file_put_contents($imagePath, $imageData) === false) {
            throw new \Exception("Failed to save the image to $imagePath.");
        }

        Log::info("Image successfully saved at: $imagePath");

        return $imagePath; // Return the path to the saved image
    }


    private function cleanPythonOutput($output)
    {
        // Remove any unwanted characters (like TensorFlow progress info)
        $cleanedOutput = preg_replace('/\x1b\[[0-9;]*[mK]/', '', $output);
        $cleanedOutput = trim($cleanedOutput);  // Trim unwanted spaces and newlines

        // Extract the numeric part (the predicted class)
        preg_match('/\d+/', $cleanedOutput, $matches);

        if (isset($matches[0])) {
            return $matches[0]; // Return the numeric class (prediction)
        }

        return ''; // Return empty string if no valid output
    }

    private function classifyEgg($image)
    {
        Log::info("in classify");

        $scriptPath = base_path('CoreTech\\classifyV1DecEggWeightDetect.py');
        $imagePath = storage_path('temp_image/temp_image.jpg');
        Log::info("Model path: " . $scriptPath);

        // Ensure the Python script is being called with the correct image path
        Log::info("Calling Python script: " . $scriptPath . " with image path: " . $imagePath);

        $command = escapeshellcmd("python " . $scriptPath . " " . escapeshellarg($imagePath));

        // Open the process to execute the Python script
        $process = proc_open(
            $command,
            [
                1 => ['pipe', 'w'], // stdout
                2 => ['pipe', 'w'], // stderr
            ],
            $pipes
        );

        if (!is_resource($process)) {
            Log::error("Failed to execute Python script.");
            throw new \Exception("Failed to execute Python script");
        }

        // Set a timeout for the process (e.g., 30 seconds)
        $timeout = 30;
        $startTime = time();
        $output = '';
        $error = '';

        while (!feof($pipes[1]) || !feof($pipes[2])) {
            if ((time() - $startTime) > $timeout) {
                // Kill the process if it exceeds the timeout
                proc_terminate($process);
                Log::error("Timeout reached for Python script.");
                throw new \Exception("Python script execution timed out.");
            }

            $output .= stream_get_contents($pipes[1]);
            $error .= stream_get_contents($pipes[2]);
        }

        fclose($pipes[1]);
        fclose($pipes[2]);

        $returnCode = proc_close($process);

        if ($returnCode !== 0) {
            Log::error("Error executing Python script: " . $error);
            throw new \Exception("Python script execution failed: " . $error);
        }

        // Clean and extract the output
        $cleanOutput = $this->cleanPythonOutput($output);
        Log::info("Cleaned Output: " . $cleanOutput);

        if (!is_numeric($cleanOutput)) {
            Log::error("Unexpected output from Python script: " . $cleanOutput);
            throw new \Exception("Unexpected output from Python script");
        }

        return (int)$cleanOutput; // Return the numeric prediction
    }


    private function determineFinalGrade($grade1, $grade2, $cageID)
    {
        Log::info("Grade from camera 1: " . $grade1);
        Log::info("Grade from camera 2: " . $grade2);

        // Define the weight thresholds for Malaysia's egg grades
        $weightToGradeMapping = [
            'A' => 65, // Grade A: 65g and above
            'B' => 60, // Grade B: 60g to 64g
            'C' => 55, // Grade C: 55g to 59g
            'D' => 0,  // Grade D: Below 55g
        ];

        $idToWeight = [
            1 => 50,
            2 => 51,
            3 => 52,
            4 => 53,
            5 => 54,
            6 => 50.5,
            7 => 51.5,
            8 => 52.5,
            9 => 53.5,
            10 => 54.5,
            11 => 55,
            12 => 55.1,
            13 => 55.2,
            14 => 55.3,
            15 => 55.4,
            16 => 55.5,
            17 => 55.6,
            18 => 55.7,
            19 => 55.8,
            20 => 55.9,
            21 => 60,
            22 => 61,
            23 => 62,
            24 => 63,
            25 => 64,
            26 => 60.5,
            27 => 61.5,
            28 => 62.5,
            29 => 63.5,
            30 => 64.5,
            31 => 65,
            32 => 65,
            33 => 65,
            34 => 65,
            35 => 65,
            36 => 65,
            37 => 65,
            38 => 65,
            39 => 65,
            40 => 65,
            41 => 65,
            42 => 65,
            43 => 65,
            44 => 65,
            45 => 65,
            46 => 65,
            47 => 65,
            48 => 65,
            49 => 65,
            50 => 65,
            51 => 65,
            52 => 65,
            53 => 65,
            54 => 65,
            55 => 65,
            56 => 'A', // Special case for Legg
            57 => 'B', // Special case for Megg
            58 => 'C', // Special case for Segg
            59 => 'A'  // Special case for XLegg
        ];

        // Handle special cases for grades (e.g., Legg, Megg, Segg, XLegg)
        if (in_array($grade1, [56, 57, 58, 59])) {
            Log::info("Special egg category detected from camera 1: " . $idToWeight[$grade1]);
            $this->storeEggGrade('Egg', $idToWeight[$grade1], $cageID);
            return $idToWeight[$grade1]; // Return the special category name
        }

        if (in_array($grade2, [56, 57, 58, 59])) {
            Log::info("Special egg category detected from camera 2: " . $idToWeight[$grade2]);
            $this->storeEggGrade('Egg', $idToWeight[$grade2], $cageID);
            return $idToWeight[$grade2]; // Return the special category name
        }

        // Validate input IDs
        if (!isset($idToWeight[$grade1]) || !isset($idToWeight[$grade2])) {
            Log::error("Invalid grade IDs provided: $grade1, $grade2");
            return "Unknown Grade";
        }

        // Retrieve the weights for the provided IDs
        $weight1 = $idToWeight[$grade1];
        $weight2 = $idToWeight[$grade2];

        // Determine the better weight (lower weight is better in this context)
        $betterWeight = min($weight1, $weight2);

        // Map the better weight to a grade
        $finalGrade = "D"; // Default to Grade D
        foreach ($weightToGradeMapping as $grade => $threshold) {
            if ($betterWeight >= $threshold) {
                $finalGrade = $grade;
                break;
            }
        }

        // Store the final grade with cage information
        Log::info("Final Egg Grade (Malaysia): " . $finalGrade);
        $this->storeEggGrade('Egg', $finalGrade, $cageID);
        
        return $finalGrade;
    }

    private function storeEggGrade($eggType, $eggGrade, $cageID)
    {
        Log::info("Storing egg grade: " . $eggGrade . " for cage ID: " . $cageID);

        $eggGrade = EggGrade::where('grade', $eggGrade)->first();
        if (!$eggGrade) {
            Log::error("Invalid egg grade: " . $eggGrade);
            return;
        }

        Egg::create([
            'type' => $eggType,
            'eggGradeID' => $eggGrade->eggGradeID,
            'description' => 'Egg grading result',
            'cageID' => $cageID,
        ]);
    }



} 
