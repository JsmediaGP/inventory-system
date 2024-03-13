<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EmployeeController;

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


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);



// Employee
Route::middleware('auth:api')->get('/employees', 'EmployeeController@index');
Route::middleware('auth:api')->get('/employees/{id}', 'EmployeeController@show');
Route::middleware('auth:api')->put('/employees/{id}', 'EmployeeController@update');
Route::middleware('auth:api')->delete('/employees/{id}', 'EmployeeController@destroy');




