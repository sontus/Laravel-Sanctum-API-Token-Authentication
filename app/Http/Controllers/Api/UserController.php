<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;

class UserController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            'auth:sanctum',
        ];
    }
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $user = User::all();
        return response()->json([
            'users' => $user
        ], 200);
    }
}
