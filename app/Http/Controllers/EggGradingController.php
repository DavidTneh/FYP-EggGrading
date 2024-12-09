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

        // Build the query to group by date only (ignoring the time part), along with other fields
        $query = Egg::with('eggGrade')
        ->selectRaw('DATE(created_at) as date, MAX(updated_at) as updated_at, type, description, eggGradeID, COUNT(*) as quantity')
        ->groupBy(DB::raw('DATE(created_at)'), 'type', 'description', 'eggGradeID');

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
                        'created_at' => $receivedDate,  //Ensure the same received date is used
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
        Log::info("At gradeEggs: Line235");

        try {
            Log::info("At gradeEggs: Line244");

            $frames = $request->only(['frame1', 'frame2']);

            // Decode base64 images
            $frame1 = $this->decodeImage($frames['frame1']);
            Log::info("Frames checking: " . $frame1);

            $frame2 = $this->decodeImage($frames['frame2']);

            // Process frames with the model
            $grade1 = $this->classifyEgg($frame1);
            $grade2 = $this->classifyEgg($frame2);

            Log::info("Grade Checking 1: " . $grade1);
            Log::info("Grade Checking 2: " . $grade2);

            // Determine final grade
            $finalGrade = $this->determineFinalGrade($grade1, $grade2);

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


    private function determineFinalGrade($grade1, $grade2)
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

        // Define the grade mapping based on the IDs
        $idToWeight = [
            1 => 47.14,
            2 => 47.17,
            3 => 50.96,
            4 => 50.96,
            5 => 51.29,
            6 => 51.34,
            7 => 51.38,
            8 => 51.53,
            9 => 51.90,
            10 => 52.01,
            11 => 52.08,
            12 => 52.41,
            13 => 52.48,
            14 => 52.65,
            15 => 52.77,
            16 => 52.93,
            17 => 56.31,
            18 => 58.39,
            19 => 59.23,
            20 => 60.00,
            21 => 60.02,
            22 => 60.04,
            23 => 60.49,
            24 => 60.56,
            25 => 61.55,
            26 => 62.70,
            27 => 63.51,
            28 => 63.83,
            29 => 64.00,
            30 => 64.13,
            31 => 65.26,
            32 => 66.05,
            33 => 66.09,
            34 => 66.41,
            35 => 66.80,
            36 => 67.08,
            37 => 67.10,
            38 => 67.75,
            39 => 67.83,
            40 => 70.52,
            41 => 71.57,
            42 => 73.23,
            43 => 73.35,
            44 => 73.41,
            45 => 74.07,
            46 => 74.19,
            47 => 74.32,
            48 => 74.67,
            49 => 74.89,
            50 => 74.98,
            51 => 77.27,
            52 => 80.64,
            53 => 82.90,
            54 => 89.50,
            55 => 92.62,
            56 => 'A', // Special case for Legg
            57 => 'B', // Special case for Megg
            58 => 'C', // Special case for Segg
            59 => 'A' // Special case for XLegg
        ];

        // If either grade is a special case (Legg, Megg, Segg, XLegg), return it directly
        if (in_array($grade1, [56, 57, 58, 59])) {
            Log::info("Special egg category detected from camera 1: " . $idToWeight[$grade1]);
            $this->storeEggGrade('Egg', $idToWeight[$grade1]);
            return $idToWeight[$grade1]; // Return the special category name
        }

        if (in_array($grade2, [56, 57, 58, 59])) {
            Log::info("Special egg category detected from camera 2: " . $idToWeight[$grade2]);
            $this->storeEggGrade('Egg', $idToWeight[$grade2]);
            return $idToWeight[$grade2]; // Return the special category name
        }

        // Validate input IDs
        if (!isset($idToWeight[$grade1]) || !isset($idToWeight[$grade2])) {
            Log::error("Invalid grade IDs provided: $grade1, $grade2");
            return "Unknown Grade";
        }

        // Get the weights for the provided IDs
        $weight1 = $idToWeight[$grade1];
        $weight2 = $idToWeight[$grade2];

        // Determine the better weight (higher weight is better)
        $betterWeight = min($weight1, $weight2);

        // Map the better weight to the grade
        $finalGrade = "D"; // Default to Grade D
        foreach ($weightToGradeMapping as $grade => $threshold) {
            if ($betterWeight >= $threshold) {
                $finalGrade = $grade;
                break;
            }
        }

        // Log and return the final grade
        Log::info("Final Egg Grade (Malaysia): " . $finalGrade);
        $this->storeEggGrade('Egg', $finalGrade);
        return $finalGrade;
    }




    private function storeEggGrade($eggType, $eggGrade)
    {
        Log::info("Grade1: " . $eggGrade);
        // Find the egg grade ID based on the grade name
        $eggGrade = EggGrade::where('grade', $eggGrade)->first();
        $eggGradeID = $eggGrade->eggGradeID;
        Log::info("Grade2: " . $eggGradeID);

        // Store egg information
        Egg::create([
            'type' => $eggType,
            'eggGradeID' => $eggGradeID,
            'description' => 'Egg', // Or any other description you want to add
            'cageID' => 1, // Example: Use the appropriate cage ID
        ]);
    }

    public function gradeLiveEgg(Request $request)
    {
        Log::info("Processing live frames for grading.");

        try {
            // Log the incoming request for debugging
            Log::info("Request payload: ", $request->all());

            // Decode the base64 images
            $frame1 = $this->decodeImage($request->input('frame1'));
            $frame2 = $this->decodeImage($request->input('frame2'));
            

            // Classify each frame
            $grade1 = $this->classifyEggDirect($frame1);
            $grade2 = $this->classifyEggDirect($frame2);
            Log::info("Checking Grade 1." .$grade1);
            Log::info("Checking Grade 2." .$grade2);

            // Determine the final grade
            $finalGrade = $this->determineFinalGrade($grade1, $grade2);
            Log::info("Checking Final Grade." . $finalGrade);

            return response()->json([
                'grade1' => $grade1,
                'grade2' => $grade2,
                'grade' => $finalGrade,
            ]);
        } catch (\Exception $e) {
            Log::error("Error during live grading: " . $e->getMessage());
            return response()->json(['error' => 'An error occurred during grading.'], 500);
        }
    }

    private function classifyEggDirect($imageData)
    {
        // Convert image data into a format that TensorFlow can process
        $command = escapeshellcmd("python ..\\CoreTech\\liveclassify.py");
        $process = proc_open(
            $command,
            [
                0 => ['pipe', 'r'], // stdin
                1 => ['pipe', 'w'], // stdout
                2 => ['pipe', 'w'], // stderr
            ],
            $pipes
        );

        if (is_resource($process)) {
            fwrite($pipes[0], $imageData); // Send the image data
            fclose($pipes[0]);

            $output = stream_get_contents($pipes[1]);
            fclose($pipes[1]);

            $error = stream_get_contents($pipes[2]);
            fclose($pipes[2]);

            $returnCode = proc_close($process);

            if ($returnCode !== 0) {
                Log::error("Python script error: " . $error);
                throw new \Exception("Python script execution failed.");
            }

            return intval(trim($output)); // Return the classification result
        } else {
            throw new \Exception("Failed to execute Python script.");
        }
    }



} 
