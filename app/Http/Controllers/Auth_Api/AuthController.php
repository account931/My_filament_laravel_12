<?php

// Auth controller for REST API (via access_token, not session). Used in Sanctum

namespace App\Http\Controllers\Auth_Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:55|min:4',
            'email' => 'email|required|unique:users',
            'password' => 'required|min:4|confirmed',
        ]);

        $validatedData['password'] = bcrypt($request->password);

        $user = User::create($validatedData); // dd($user);

        $accessToken = $user->createToken('authSanctumToken')->plainTextToken;
        // $accessToken = $user->createToken('authSanctumToken')->accessToken;

        return response(['user' => $user, 'access_token' => $accessToken]);
    }

    public function login(Request $request)
    {
        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required',
        ]);

        if (! auth()->attempt($loginData)) {
            return response(['message' => 'Invalid Credentials']);
        }

        $accessToken = auth()->user()->createToken('authSanctumToken')->plainTextToken;   // sanctum token
        // $accessToken = auth()->user()->createToken('authToken')->accessToken;

        return response(['user' => auth()->user(), 'access_token' => $accessToken]);

    }
}
