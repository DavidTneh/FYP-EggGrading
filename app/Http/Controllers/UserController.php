<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;


class UserController extends Controller
{
    // List all users
    public function index()
    {
        try {
            // Retrieve all users except the currently logged-in user
            $users = User::with('role')
                ->where('userID', '!=', auth()->id()) // Exclude the logged-in user's record
                ->paginate(10);

            return view('usersManagement', compact('users'));
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to load users. Please try again.']);
        }
    }

    // Show the form for creating a new user
    public function create()
    {
        try {
            $roles = Role::all(); // Get all roles
            return view('addUsers', compact('roles'));
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to load roles. Please try again.']);
        }
    }

    // Store a new user
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:user,email',
            'phoneNo' => [
                'required',
                'regex:/^01\d{1}-?\d{7,8}$/', // Malaysia phone number validation
            ],
            'dob' => [
                'required',
                'date',
                'before:' . now()->subYears(18)->format('Y-m-d'), // Ensure the user is at least 18 years old
            ],
            'address' => 'nullable|string|max:255',
            'password' => 'required|string|min:8|confirmed', // Add confirmation for password
            'roleID' => 'required|exists:role,roleID',
        ], [
            'phoneNo.regex' => 'The phone number must be a valid Malaysia phone number format, e.g., 012-3456789 or 01134567890.',
            'dob.before' => 'The user must be at least 18 years old to register.',
            'password.confirmed' => 'The password confirmation does not match.',
        ]);

        try {
            User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'phoneNo' => $request->input('phoneNo'),
                'dob' => $request->input('dob'),
                'password' => Hash::make($request->input('password')),
                'roleID' => $request->input('roleID'),
                'address' => $request->input('address'),
                'status' => 1,
            ]);

            return redirect()->route('users.index')->with('success', 'User created successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to create user. Please try again.']);
        }
    }




    // Show the form for editing a user
    public function edit(Request $request)
    {
        try {
            $id = $request->input('userID');
            $user = User::findOrFail($id); // Find the user by ID
            $roles = Role::all(); // Get all roles for selection

            return view('updateUsers', compact('user', 'roles'));
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to load user details. Please try again.']);
        }
    }

    public function update(Request $request)
    {
        $id = $request->input('userID');
        $user = User::findOrFail($id);

        // Define validation rules and messages
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:user,email,' . $id . ',userID',
            'phoneNo' => [
                'required',
                'regex:/^01\d{1}-?\d{7,8}$/', // Malaysia phone number validation
            ],
            'address' => 'nullable|string|max:255',
            'roleID' => 'required|exists:role,roleID',
        ];

        $messages = [
            'phoneNo.regex' => 'The phone number must be a valid Malaysia phone number format, e.g., 012-3456789 or 01134567890.',
        ];

        // Perform manual validation
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            // Redirect to the edit route with validation errors and old input
            return redirect()->route('users.index')
                ->withErrors($validator) // Pass validation errors
                ->withInput(); // Retain old input
        }

        // If validation passes, proceed to update the user
        $user->update($validator->validated());

        // Redirect with a success message
        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }



    // Show the confirmation for deleting a user
    public function showDelete(Request $request)
    {
        try {
            $id = $request->input('userID');
            $user = User::findOrFail($id);

            return view('deleteUsers', compact('user'));
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to load user details. Please try again.']);
        }
    }

    // Delete a user
    public function destroy(Request $request)
    {
        try {
            $id = $request->input('userID');
            $user = User::findOrFail($id);
            $user->delete();

            return redirect()->route('users.index')->with('success', 'User deleted successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to delete user. Please try again.']);
        }
    }

    // Disable a user account
    public function disable(Request $request)
    {
        try {
            $id = $request->input('userID');

            // Find the user by ID
            $user = User::findOrFail($id);

            // Update the user's status to false (disabled)
            $user->update(['status' => false]);

            return redirect()->route('users.index')->with('success', 'User account disabled successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to disable user account. Please try again.']);
        }
    }
}
