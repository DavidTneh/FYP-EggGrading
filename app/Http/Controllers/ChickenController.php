<?php

namespace App\Http\Controllers;

use App\Models\Cage;
use App\Models\Chicken;
use BaconQrCode\Writer;
use Illuminate\Http\Request;
use App\Models\ChickenBreeds;
use Illuminate\Support\Facades\Log;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;


class ChickenController extends Controller
{
    // Display the list of chickens grouped by cage and breed
    public function index()
    {
        $chickensGrouped = Chicken::with(['breed', 'cage'])
        ->selectRaw('cageID, breedID, COUNT(*) as quantity')
        ->groupBy('cageID', 'breedID')
        ->get();

        return view('chickenManagement', compact('chickensGrouped'));
    }

    public function printQR(Request $request)
    {
        $chickenID = $request->input('chickenID');
        $chicken = Chicken::findOrFail($chickenID);

        $qrCodeData = json_encode([
            'chickenID' => $chicken->chickenID,
            'dob' => $chicken->dob,
            'cageID' => $chicken->cageID,
            'breedID' => $chicken->breedID,
        ]);

        // Generate QR code using BaconQrCode with SVG backend
        $renderer = new ImageRenderer(
            new RendererStyle(300), // 300x300 px QR code
            new SvgImageBackEnd()   // SVG backend
        );
        $writer = new Writer($renderer);

        $qrCodeSvg = $writer->writeString($qrCodeData);

        // Return the SVG QR code to the browser
        return response($qrCodeSvg)
            ->header('Content-Type', 'image/svg+xml')
            ->header('Content-Disposition', 'inline; filename="chicken_qr_code.svg"');
    }

    // Show the form to create a new chicken
    public function create()
    {
        $breeds = ChickenBreeds::all();
        $cages = Cage::all();
        return view('addChicken', compact('breeds', 'cages'));
    }

    // Store new chicken(s)
    public function store(Request $request)
    {
        $request->validate([
            'breedid' => 'required|exists:chickenbreeds,breedID',
            'dob' => 'required|date',
            'cageid' => 'required|exists:cage,cageID',
            'quantity' => 'required|integer|min:1',
        ]);

        // Store each chicken individually based on quantity
        for ($i = 0; $i < $request->quantity; $i++) {
            Chicken::create([
                'breedID' => $request->input('breedid'),
                'dob' => $request->input('dob'),
                'cageID' => $request->input('cageid'),
            ]);
        }

        return redirect()->route('chickens.index')->with('success', 'Chicken(s) added successfully.');
    }

    // Show details of all chickens in a specific group (by cage and breed)
    public function showGrouped($cageID, $breedID)
    {
        $chickens = Chicken::with([
                'breed',
                'cage',
                'vaccinationRecords.vaccinationplan.vaccinationType',
            ])
            ->where('cageID', $cageID)
            ->where('breedID', $breedID)
            ->get();

        $cage = Cage::findOrFail($cageID);
        $breed = ChickenBreeds::findOrFail($breedID);

        return view('viewChicken', compact('chickens', 'cage', 'breed'));
    }


    public function editGroup(Request $request)
    {

        $cageID = $request->input('cageID');
        $breedID = $request->input('breedID');

        // Retrieve all chickens within the specified cage and breed group
        $chickens = Chicken::where('cageID', $cageID)->where('breedID', $breedID)->get();
        $breeds = ChickenBreeds::all();
        $cages = Cage::all();
        $cage = Cage::findOrFail($cageID);
        $breed = ChickenBreeds::findOrFail($breedID);

        return view('updateChickenGroup', compact('chickens', 'cage','breed','breeds','cages'));
    }

    public function updateGroup(Request $request)
    {
        $request->validate([
            'new_breedid' => 'required|exists:chickenbreeds,breedID',
            'new_dob' => 'required|date',
            'new_cageid' => 'required|exists:cage,cageID',
        ]);

        $cageID = $request->input('cageID');
        $breedID = $request->input('breedID');

        // Update all chickens in the specified group
        Chicken::where('cageID', $cageID)->where('breedID', $breedID)->update([
            'breedID' => $request->input('new_breedid'),
            'dob' => $request->input('new_dob'),
            'cageID' => $request->input('new_cageid'),
        ]);

        return redirect()->route('chickens.index', ['cageID' => $cageID, 'breedID' => $breedID])
        ->with('success', 'Chicken group updated successfully.');
    }


    // Show the form to edit a chicken
    public function edit(Request $request)
    {
        $chickenID = $request->input('chickenID');
        $chicken = Chicken::findOrFail($chickenID);
        $breeds = ChickenBreeds::all();
        $cages = Cage::all();

        return view('updateChicken', compact('chicken', 'breeds', 'cages'));
    }

    // Update a specific chicken
    public function update(Request $request)
    {
        $request->validate([
            'chickenID' => 'required|exists:chicken,chickenID',
            'breedid' => 'required|exists:chickenbreeds,breedID',
            'dob' => 'required|date',
            'cageid' => 'required|exists:cage,cageID',
        ]);

        $chicken = Chicken::findOrFail($request->input('chickenID'));
        $chicken->update([
            'breedID' => $request->input('breedid'),
            'dob' => $request->input('dob'),
            'cageID' => $request->input('cageid'),
        ]);

        return redirect()->route('chickens.index')->with('success', 'Chicken updated successfully.');
    }

    // Delete chickens by group (based on cage and breed)
    public function destroyGrouped(Request $request)
    {
        $request->validate([
            'cageID' => 'required|exists:cage,cageID',
            'breedID' => 'required|exists:chickenbreeds,breedID',
        ]);

        Chicken::where('cageID', $request->input('cageID'))
            ->where('breedID', $request->input('breedID'))
            ->delete();

        return redirect()->route('chickens.index')->with('success', 'Chickens deleted successfully.');
    }

    public function destroy(Request $request)
    {
        // Find the chicken by ID
        $chicken = Chicken::findOrFail($request->input('chickenID'));

        // Delete the chicken
        $chicken->delete();

        // Redirect back to the previous page with a success message
        return redirect()->back()->with('success', 'Chicken deleted successfully.');
    }


}
