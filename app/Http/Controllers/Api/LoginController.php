<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(LoginRequest $request)
    {

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password]) ){
            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;
            return  response([
                'message' => 'Login Successful',
                'access_token' => $token,
                'token_type' => 'Bearer'

            ], 200);
        }
        else {
            return response([
                'message' => 'The provided credentials are incorrect.'
            ], 401);
        }



    }
}
