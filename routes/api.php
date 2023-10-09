<?php

use App\Http\Controllers\customer\API\CustomerApiAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('customer')->group(function () {
    Route::post('/register',[CustomerApiAuth::class,'register']);
    Route::post('/login',[CustomerApiAuth::class,'login']);
});


Route::prefix("test")->group(function(){
    Route::post('/test',[CustomerApiAuth::class,'test']);
});

