<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $user = User::where('username', $request->input('username'))->first();

        if (! $user) {
            return response()->json(['message' => 'User not found'], 400);
        }

        if (! Hash::check($request->input('password'), $user->password)) {
            return response()->json(['message' => 'Password is incorrect'], 400);
        }

        $token = $user->createToken('auth')->plainTextToken;

        return response()->json(compact('token', 'user'));
    }

    public function me()
    {
        return response()->json(['data' => auth()->user()]);
    }
}
