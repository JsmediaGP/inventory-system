<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\SalesController;
use App\Http\Controllers\Api\StockController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;
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


//categories
Route::middleware('auth:api')->get('/categories', 'CategoryController@index');
Route::middleware('auth:api')->post('/categories', 'CategoryController@store');
Route::middleware('auth:api')->get('/categories/{id}', 'CategoryController@show');
Route::middleware('auth:api')->put('/categories/{id}', 'CategoryController@update');
Route::middleware('auth:api')->delete('/categories/{id}', 'CategoryController@destroy');


//products
Route::middleware('auth:api')->get('/products', 'ProductController@index');
Route::middleware('auth:api')->post('/products', 'ProductController@store');
Route::middleware('auth:api')->get('/products/{id}', 'ProductController@show');
Route::middleware('auth:api')->put('/products/{id}', 'ProductController@update');
Route::middleware('auth:api')->delete('/products/{id}', 'ProductController@destroy');

//Sales
Route::middleware('auth:api')->get('/sales', 'SalesController@index');
Route::middleware('auth:api')->get('/sales/best-selling', 'SaleController@bestSelling');
Route::middleware('auth:api')->post('/sales/sell', 'SaleController@sell');



//Stock Management
Route::middleware('auth:api')->get('/stock', 'StockController@index');


//POS




















