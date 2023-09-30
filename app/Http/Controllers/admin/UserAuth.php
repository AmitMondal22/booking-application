<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\assets\ResponceBaseController;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class UserAuth extends ResponceBaseController
{

    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }


    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    function create_account() {
        $result=[
            "userdata"=>[
                "name"=>"amit mondal",
                "email"=>"Test"
            ]
        ];
        $message="user info data";
        return $this->sendResponse($result, $message);
        // return $this->sendError($error, $errorMessages, 400);
    }
    function login() {
        return response()->json("xfbvjfd");
    }



    public function login_web(Request $request): RedirectResponse
    {
        $input = $request->all();

        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if(auth()->attempt(array('email' => $input['email'], 'password' => $input['password'])))
        {
            if (auth()->user()->type == 'admin') {
                return redirect()->route('admin.home');
            }else if (auth()->user()->type == 'manager') {
                return redirect()->route('manager.home');
            }else{
                return redirect()->route('home');
            }
        }else{
            return redirect()->route('login')
                ->with('error','Email-Address And Password Are Wrong.');
        }

    }
}
