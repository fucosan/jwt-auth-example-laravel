<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Controller;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group([
    'middleware' => ['direct.to.user.profile'],
], function(){
    Route::get('/login', function (){
        return view('login');
    });
    Route::get('/register', function() {
        return response()->json([
           'Massage' => 'register view',
        ]);
    });
    Route::post('/authen', [AuthController::class, 'authen']);
    Route::post('/register', [AuthController::class, 'register']);
});

Route::group([
    'middleware' => ['jwt.verify'],
], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
    Route::get('/home', function() {
       return view('welcome');
    });
});
