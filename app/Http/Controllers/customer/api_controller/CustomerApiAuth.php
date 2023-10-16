<?php

namespace App\Http\Controllers\customer\api_controller;

use App\Http\Controllers\assets\ResponceBaseController;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CustomerApiAuth extends ResponceBaseController
{
    function register(Request $r): JsonResponse
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
                'otp'=>$otp,
                'otp_status'=>'1',
                'active_status'=>'1'
            ]);
            return $this->sendResponse($data, "User registered successfully");
        } catch (\Throwable $th) {
            return $this->sendError("exception handler error", $th, 400);
        }
    }


    function login(Request $r): JsonResponse
    {

        try {
            $rules = [
                'username' => 'required',
                'password' => 'required|string|min:8|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/'
            ];
            $valaditor = Validator::make($r->all(), $rules);
            if ($valaditor->fails()) {
                return $this->sendError("request validation error", $valaditor->errors(), 400);
            }

            $searchTerm = $r->username;
            $data = User::where('active_status','1')->where(function ($query) use ($searchTerm) {
                $query->where('mobile', '=', $searchTerm)
                    ->orWhere('email', '=', $searchTerm);
            })->first();
            if (!empty($data)) {
                if (Hash::check($r->password, $data->password)) {

                    $returndata = [
                        "user_info" => $data,
                        "token" => $data->createToken($data->name, ['1'])->plainTextToken
                    ];
                    return $this->sendResponse($returndata, "login successfully");
                } else {
                    return $this->sendError("invalid password", null, 400);
                }
            } else {
                return $this->sendError("user not found", null, 400);
            }
        } catch (\Throwable $th) {
            return $this->sendError("exception handler error", $th, 400);
        }
    }

    public function test(Request $r):JsonResponse
    {
        return $this->sendResponse($r->name, "login successfully");
    }
}
