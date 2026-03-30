<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationData;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request) 
    { 
        $request->validate([
            'email' => 'required|string|max:255',
            'password' => 'required|string'
        ]);

        if (!Auth::attempt($request->only('email', 'password')))
            {
                throw ValidationException::withMessages([
                    'email'=> __('auth.failed'),
                ]);
            }

        $user = $request->user();

        return response()->json([
            'success' => 'true',
            'message' => 'Logged in successfully',
            'user' => $user->createToken('api-token')->plainTextToken,
        ]);
    }
}
