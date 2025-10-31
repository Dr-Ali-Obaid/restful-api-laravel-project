<?php

namespace App\Http\Controllers;

use App\Events\UserLogIn;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(Request $request){
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();
            event(new UserLogIn($user));
            $accessToken = $user->createToken('access token')->plainTextToken;
            return response()->json([
                'User' => new UserResource($user),
                'Token' => $accessToken
            ]);
        }
        return response()->json([
            'message' => "the email or password not correct"
        ], 401);
    }
}
