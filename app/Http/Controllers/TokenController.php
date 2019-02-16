<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;


class TokenController extends Controller
{
    public function token(Request $request, \Tymon\JWTAuth\JWTAuth $auth)
    {
    	$user = Auth::guard('member')->user();
		if (!$user) {
            return response()->json(['error' => 'not logged in'], 401);
        }
		
        $claims = ['userid' => $user->id, 'username' => $user->username, 'phone' => $user->phone];
        $token = $auth->fromUser($user, $claims);
        return response()->json(['token' => $token,'userid' => $user->id, 'username' => $user->username]);
    }
}