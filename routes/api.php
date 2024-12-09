<?php

use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;





Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/detail', [AuthController::class, 'detail'])->middleware('auth:api');
Route::get('/error', [AuthController::class, 'tokenerror'])->name('error.route.name');
// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::middleware('auth:api')->group(function(){
 
Route::get('/todos',[TodoController::class,'index']);
Route::get('/todos/{id}',[TodoController::class,'show']);
Route::post('/todos',[TodoController::class,'store']);
Route::put('/todos/{id}',[TodoController::class,'update']);
Route::delete('/todos/{id}',[TodoController::class,'destroy']);

});