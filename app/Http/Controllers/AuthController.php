<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    // Get All Users

    public function getAllUser(){
        return User::all();
    }

    // Register
    public function register(Request $request)
    {
        $field = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed'
        ]);

        $user = User::create([
            'name' =>  $field['name'],
            'email' =>  $field['email'],
            'password' => bcrypt($field['password']),
        ]);

        $token = $user->createToken('myappToken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }


    // login 

    public function login(Request $request)
    {
        $field = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);


        // Check Email
        $user = User::where('email', $field['email'])->first();

        if (!$user || !Hash::check($field['password'], $user->password)) {
            return response([
                'message' => 'Bad Credentials'
            ], 401);
        }

        $token = $user->createToken('myappToken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }


    // Logout
    public function logout(Request $request)
    {
        // to get the current user token
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Logged Out'
        ];
    }
}
