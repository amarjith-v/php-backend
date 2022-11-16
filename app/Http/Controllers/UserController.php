<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\RootController;

class UserController extends RootController
{
    public function profile(Request $request) {
        $response['user'] =  $request->user();
        return $this->apiResponse( $response, 'user data fetched successfully', 200);
    }

    public function login(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8|max:16'
        ]);

        if ($validator->fails()) {
            return $this->apiResponse([], $validator->errors(), 400);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $success['token'] =  $user->createToken('LARAVELKEY', ['user'])->plainTextToken;
            $success['user'] =  $user;
            return $this->apiResponse($success, "success.", 200);
        }else{
            return $this->apiResponse([], "failed", 403);
        }
    }
}
