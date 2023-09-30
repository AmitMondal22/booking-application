<?php

namespace App\Http\Controllers\customer\API;

use App\Http\Controllers\assets\ResponceBaseController;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CustomerApiAuth extends ResponceBaseController
{
    public function register(Request $r): JsonResponse
    {
        try {
            $rules = [
                'name' => 'required',
                'email' => 'required|email',
                'mobile' => 'required|numeric',
                'password' => 'required|string|min:8|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/',
            ];
            $valaditor = Validator::make($r->all(), $rules);
            if ($valaditor->fails()) {
                return $this->sendError("request validation error", $valaditor->errors(), 400);
            }
            $otp = sprintf("%06d", mt_rand(000001, 999999));
            $data = User::create([
                'name' => $r->name,
                'email' => $r->email,
                'mobile' => $r->mobile,
                'password' => Hash::make($r->password),
                'type' => '1',
            ]);
            return $this->sendResponse($data, "User registered successfully");
        } catch (\Throwable $th) {
            return $this->sendError("exception handler error", $th, 400);
        }
    }


    public function login(Request $request): JsonResponse
    {

        $this->validate($request, [
            'username' => 'required|unique:users',
            'password' => 'required|min:6',

        ]);



        // Return a success response
        return response()->json(['message' => 'User registered successfully'], 201);
    }
}
