<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request): \Illuminate\Http\JsonResponse
    {
        // Input data validation
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users', // Checking email uniqueness
            'password' => 'required|string|min:8'
        ]);

        // Checking validation result
        if($validator->fails()){
            return response()->json($validator->errors(), 422); // Code 422 indicates unprocessable entity
        }

        // Creating user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        // Creating token for the user
        $token = $user->createToken('auth_token')->plainTextToken;

        // Returning JSON response with user data and token
        return response()->json([
            'data' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer'
        ], 201); // Code 201 indicates resource created
    }

    public function login(Request $request): \Illuminate\Http\JsonResponse
    {
        // Attempting login
        if (!Auth::attempt($request->only('email', 'password')))
        {
            return response()->json(['message' => 'Incorrect login or password!'], 401); // Code 401 indicates unauthorized
        }

        // Fetching user
        $user = User::where('email', $request['email'])->firstOrFail();

        // Creating token for the user
        $token = $user->createToken('auth_token')->plainTextToken;

        // Returning JSON response with greeting and token
        return response()->json([
            'message' => 'Hello '.$user->name,
            'access_token' => $token,
            'token_type' => 'Bearer'
        ]);
    }

    public function logout(Request $request): array
    {
        auth()->user()->tokens()->delete();
        return [
            'message' => 'Logged out'
        ];
    }
}
