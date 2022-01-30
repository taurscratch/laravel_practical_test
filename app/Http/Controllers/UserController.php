<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function issueToken(Request $request){
        $user = User::where('email',$request->email)->first();
        if(!$user or !Hash::check($request->password,$user->password)){
            return response()->json([
                'status'  => 401,
                'message' => 'Invalid Credentials.'
            ]);
        }
        else{
            $token = $user->createToken('user-token');

            return ['token' => $token->plainTextToken];
        }

    }
}
