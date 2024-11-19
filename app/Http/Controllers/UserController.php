<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;

class UserController extends Controller
{
    // List all users
    public function index()
    {
        $users = User::with('role')->paginate(10); // Include role relationship for display
        return view('usersManagement', compact('users'));
    }

    // Show the form for creating a new user
    public function create()
    {
        $roles = Role::all(); // Get all roles
        return view('addUsers', compact('roles'));
    }

    // Store a new user
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:user,email',
            'phoneNo' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'password' => 'required|string|min:8', // Add confirmation for password
            'roleID' => 'required|exists:role,roleID',
        ]);

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
    }

    // Show the form for editing a user
    public function edit(Request $request)
    {   
        $id = $request->input('userID');
        $user = User::findOrFail($id); // Find the user by ID
        $roles = Role::all(); // Get all roles for selection
        return view('updateUsers', compact('user', 'roles'));
    }

    // Update a user
    public function update(Request $request)
    {
        $id = $request->input('userID');
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:user,email,' . $user->userID . ',userID',
            'phoneNo' => 'nullable|string|max:20',
            'dob' => 'nullable|date',
            'address' => 'nullable|string|max:255',
            'roleID' => 'required|exists:role,roleID',
        ]);

        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phoneNo' => $request->input('phoneNo'),
            'dob' => $request->input('dob'),
            'address' => $request->input('address'),
            'roleID' => $request->input('roleID'),
        ]);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    // Show the confirmation for deleting a user
    public function showDelete(Request $request)
    {
        $id = $request->input('userID');

        $user = User::findOrFail($id); // Find the user by ID
        return view('deleteUsers', compact('user'));
    }

    // Delete a user
    public function destroy(Request $request)
    {
        $id = $request->input('userID');

        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
