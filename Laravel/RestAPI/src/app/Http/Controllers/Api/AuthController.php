<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request) 
    {
        $request->validate(
            [
                'email' => 'required|email',
                'password' => 'required',
            ]
        );

        $user = \App\Models\User::where('email', $request->email)->first();

        if ($user) {
          throw ValidationException::withMessages(
            [
                'email' => ['email incorrect']
            ]
            );
        }
    }

    public function logout(Request $request) 
    {

    }
}
