<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordResetRequest;
use App\Http\Requests\SendResetLinkEmailRequest;
use App\Mail\ResetPasswordLink;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class PasswordResetController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            'guest'
        ];
    }

    public function sendResetLinkEmail(SendResetLinkEmailRequest $request)
    {
        $url = URL::temporarySignedRoute(
            'auth.password.reset',
            now()->addMinutes(60),
            ['email' => $request->email]
        );

        $url = str_replace(env('APP_URL'), env('FRONTEND_URL'), $url);


        Mail::to($request->email)->send(new ResetPasswordLink( $url));
        return response()->json([
            'message' => 'Password reset link sent.'
        ], 200);
    }

    public function resetPassword(PasswordResetRequest $request)
    {
        $user = User::whereEmail($request->email)->first();
        if (!$user) {
            return response()->json([
                'message' => 'User not found.'
            ], 404);
        }
        $user->password = bcrypt($request->password);
        $user->save();
        return response()->json([
            'message' => 'Password reset successfully.'
        ], 200);
    }
}
