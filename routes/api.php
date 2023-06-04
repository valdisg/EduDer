<?php

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


Route::get('/', function (Request $request) {
    return response()->json(array([
        'rank' => 1,
        'school_name' => '1. skola',
        'confidence_score' => 0.99
    ],[
        'rank' => 2,
        'school_name' => '4. skola',
        'confidence_score' => 0.98
    ],
        ));
});
