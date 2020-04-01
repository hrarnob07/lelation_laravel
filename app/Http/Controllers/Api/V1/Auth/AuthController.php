<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\AuthRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class AuthController extends Controller
{
    public function login(AuthRequest $request){
        $form = $request->validated();
        $credential = [
            'password' => $form['password']
        ];

        if(filter_var($form['username'], FILTER_VALIDATE_EMAIL)){
            $credential["email"] = $form["username"];
        }else {
            $credential['phone_no'] = $form['username'];
        }

        try{
            $userCanGoToAction = Auth::once($credential);
            if (!empty($userCanGoToAction)) {
                $token = Auth::user()->createToken('bd-gym-app')->accessToken;
            }
        }catch (\Throwable $exception)
        {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ]);
        }
        if (!$userCanGoToAction) {
             return response()->json([
                'success' => false,
                'message' => "invalid credentials"
            ]);
        }
        return response()->json([
            "success" => true,
            "message" => "Login success",
            "token" => $token
        ]);


    }
}
