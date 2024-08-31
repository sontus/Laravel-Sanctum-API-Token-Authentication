<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\EmailVerification;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class VerifyEmailController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            'auth:sanctum',
        ];
    }

    public  function sendMail()
    {


        if (Auth::user()->email_verified_at) {
            return response()->json([
                'message' => 'Email already verified.'
            ], 200);
        }
        Mail::to(Auth::user()->email)->send(new EmailVerification(Auth::user()->email));
        return response()->json([
            'message' => 'Email sent.'
        ], 200);
    }

    public function verifyEmail(Request $request)
    {

        if (Auth::user()->email_verified_at) {
            return response()->json([
                'message' => 'Email already verified.'
            ], 200);
        }
        if ($request->hasValidSignature()) {
            $user = Auth::user();
            $user->email_verified_at = now();
            $user->save();
            return response()->json([
                'message' => 'Email verified.'
            ], 200);
        }

    }

}
