<?php

use App\Http\Controllers\PatientController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// PATIENT
Route::group(['prefix' => '/patient'], function (){
     Route::get('',[PatientController::class,'index']);
     Route::post('/store',[PatientController::class,'store']);
     Route::get('/show/{id}',[PatientController::class,'show']);
     Route::patch('/update/{id}',[PatientController::class,'update']);
     Route::delete('/delete/{id}',[PatientController::class,'destroy']);
});
