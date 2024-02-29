<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\AuthRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class AuthController extends Controller
{
    public function authenticate(AuthRequest $request) 

    {
        $email = $request->email;
        $password = $request->password;
        $user = User::where('email',$email)->first();

        if (!$user || !Hash::check($password,$user->password))
        {
            throw ValidationException::withMessages([
                'email' => ['Invalid Login credentials']
            ]);
        }
        return[
            'users' => $user,
            'token' => $user->createToken('auth')->plainTextToken
        ];
    }
    
}
