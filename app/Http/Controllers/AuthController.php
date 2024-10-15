<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\AdminResetPassword;
use App\Mail\LoginBlocked;
use App\Models\LoginAttempt;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{

    public function showLoginForm()
    {
        $email = 'johndoe@example.com';
        $password = 'password123';

        return view('login', [
            'email' => $email,
            'password' => $password
        ]);
    }


    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Check if there are any failed login attempts for this email
        $loginAttempt = LoginAttempt::firstOrCreate(['email' => $request->email]);

        // Check if the user is blocked
        if ($loginAttempt->isBlocked()) {
            $blockedTime = $loginAttempt->blocked_until->diffForHumans();
            return back()->withErrors(['email' => "Too many login attempts. Please try again in $blockedTime."])->withInput();
        }

        $lastAttemptTime = Carbon::parse($loginAttempt->updated_at);
        $now = Carbon::now();

        if ($now->greaterThan($lastAttemptTime->addMinutes(10))) {
            // Reset attempts if more than 10 minutes have passed since the last attempt
            $loginAttempt->attempts = 0;
            $loginAttempt->save();
        }

        // Credentials for login
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
            'status' => true,  // Add your status condition if necessary
            'roleID' => 1,     // Add your role condition if necessary
        ];

        // Attempt to log in using the default 'web' guard
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Set the session_id for the user
            $authUser = Auth::user();
            $user = User::find($authUser->userID);  // Ensure you are using the correct ID column
            $user->session_id = Session::getId();
            $user->save();

            // Reset login attempts after successful login
            $loginAttempt->delete();

            // Redirect after successful login
            return redirect()->intended(route('/admin'))->with('success', "Welcome Back");
        } else {
            // Increment attempts if login fails
            $loginAttempt->incrementAttempts();

            // Block the user if the attempts exceed 3
            if ($loginAttempt->attempts >= 3) {
                // Block for 5 min for 3 attempts, 10 min for 6 attempts, etc.
                $blockTime = $loginAttempt->block_attempts * 3;
                $loginAttempt->block($blockTime);

                $user = User::where('email', $request->email)->first();
                if ($user) {
                    Mail::to($user->email)->send(new LoginBlocked($blockTime));
                }

                return back()->withErrors(['email' => "Too many login attempts. You are blocked for $blockTime minutes."])->withInput();
            }

            return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
        }
    }


    public function logout(Request $request)
    {
        $userId = Auth::guard('admin')->id();

        // Log the logout activity
        if ($userId) {
            // Log the logout activity
            $this->logUserActivity($userId, 'logout', $request, 'success');
        }

        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('/admin/login');
    }

    public function showForgotPasswordForm()
    {
        return view('admin.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $tokenDetails = DB::table('password_reset_tokens')->where('email', $request->email)->first();

        if ($tokenDetails && Carbon::parse($tokenDetails->created_at)->addDay()->isFuture()) {
            return back()->withErrors(['email' => 'A password reset link has already been sent to this email. Please check your inbox.']);
        }

        $user = User::where('email', $request->email)
            ->where('roleID', 1) // Ensure the role ID is 1
            ->where('status', true) // Ensure the status is active
            ->first();

        if ($user) {
            $token = Str::random(60);

            // Insert or update the password reset token in the database
            DB::table('password_reset_tokens')->updateOrInsert(
                ['email' => $request->email],
                ['token' => $token, 'created_at' => now()]
            );

            $url = "http://127.0.0.1:8001/zara/admin/reset-password/{$token}?email=" . urlencode($request->email);

            Mail::to($request->email)->send(new AdminResetPassword($url));
        }

        return back()->with('status', 'Verification code sent to your email!');
    }

    public function showResetForm($token)
    {
        $tokenDetails = DB::table('password_reset_tokens')->where('token', $token)->first();

        if (!$tokenDetails) {
            abort(403, 'This password reset token is invalid.');
        }

        // Check if the token has expired (1 hour)
        if (Carbon::parse($tokenDetails->created_at)->addHour()->isPast()) {
            abort(403, 'This password reset token has expired.');
        }

        return view('admin.reset-password', compact('token'));
    }

    public function resetPassword(Request $request, $token)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Retrieve the token details
        $tokenDetails = DB::table('password_reset_tokens')->where('token', $token)->first();

        if (!$tokenDetails) {
            abort(403, 'This password reset token is invalid.');
        }

        // Check if the token has expired (1 hour)
        if (Carbon::parse($tokenDetails->created_at)->addHour()->isPast()) {
            abort(403, 'This password reset token has expired.');
        }

        // Update the user's password
        $user = User::where('email', $tokenDetails->email)
            ->where('roleID', 1) // Ensure the role ID is 1
            ->where('status', true)
            ->first();

        if ($user) {

            $user->password = Hash::make($request->password);
            $user->save();

            // Optionally, delete the token from the database
            DB::table('password_reset_tokens')->where('email', $tokenDetails->email)->delete();

            return redirect()->route('admin.login')->with('status', 'Password has been reset successfully!');
        }

        return back()->withErrors(['email' => 'User not found.']);
    }

    // protected function logUserActivity($userId, $action, $request, $loginStatus)
    // {
    //     // Retrieve the user by userID
    //     $user = User::find($userId);
    //     $userName = $user ? $user->name : 'Unknown User';

    //     // Gather additional information
    //     $ipAddress = $request->ip();
    //     $userAgent = $request->header('User-Agent');
    //     $sessionId = $request->session()->getId();

    //     // Prepare log entry
    //     $logEntry = sprintf(
    //         "[%s] User ID: %d, User Name: %s, Action: %s, IP: %s, User Agent: %s, Session ID: %s, Login Status: %s\n",
    //         now(),
    //         $userId,
    //         $userName,
    //         $action,
    //         $ipAddress,
    //         $userAgent,
    //         $sessionId,
    //         $loginStatus
    //     );

    //     // Log to a text file
    //     Storage::append('user_activity.log', $logEntry);
    // }
}
