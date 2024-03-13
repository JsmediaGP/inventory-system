<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;



class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Validate incoming request
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Attempt to authenticate user
        if (!Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        // Get the authenticated user
        $user = Auth::user();

        // Check if the user's role is allowed to log in
        if (!$this->isRoleAllowedToLogin($user->role)) {
            // If the user's role is not allowed, logout and return unauthorized
            Auth::logout();
            throw ValidationException::withMessages([
                'role' => ['The user role is not allowed to log in.'],
            ]);
        }

        // Generate user token
        $tokenResult = $user->createToken('authToken');

        // Return token and user role
        return response()->json(['access_token' => $tokenResult->accessToken, 'role' => $user->role], 200);
    }

    private function isRoleAllowedToLogin($role)
    {
        // Define which roles are allowed to log in
        $allowedRoles = ['admin', 'employee'];

        // Check if the user's role is in the allowed roles list
        return in_array($role, $allowedRoles);
    }

    public function register(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string',
            'role' => 'required|string|in:admin,employee',
        ]);

        // Create new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]);

        return response()->json(['message' => 'User created successfully', 'user' => $user], 201);
    }

    public function logout(Request $request)
    {
        // Revoke current user token
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully'], 200);
    }
}