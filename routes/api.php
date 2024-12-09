<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\SpecialtyController;
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

Route::post('login', [AuthController::class, 'login']);
    
Route::group(['middleware' => 'auth:api'], function () {
     // AUTH
     Route::get('user', [AuthController::class, 'getUser']);
     Route::post('logout', [AuthController::class, 'logout']);
     Route::post('refresh', [AuthController::class, 'refresh']);

     // PATIENT
     Route::group(['prefix' => 'patient'], function (){
          Route::get('',[PatientController::class,'index']);
          Route::post('/store',[PatientController::class,'store']);
          Route::get('/show/{id}',[PatientController::class,'show']);
          Route::patch('/update/{id}',[PatientController::class,'update']);
          Route::delete('/delete/{id}',[PatientController::class,'destroy']);
     });

     // SPECIALTY
     Route::group(['prefix' => 'specialty'], function (){
          Route::get('',[SpecialtyController::class,'index']);
          Route::post('/store',[SpecialtyController::class,'store']);
          Route::get('/show/{id}',[SpecialtyController::class,'show']);
          Route::patch('/update/{id}',[SpecialtyController::class,'update']);
          Route::delete('/delete/{id}',[SpecialtyController::class,'destroy']);
     });
     
     // DOCTOR
     Route::group(['prefix' => 'doctor'], function (){
          Route::get('',[DoctorController::class,'index']);
          Route::post('/store',[DoctorController::class,'store']);
          Route::get('/show/{id}',[DoctorController::class,'show']);
          Route::patch('/update/{id}',[DoctorController::class,'update']);
          Route::delete('/delete/{id}',[DoctorController::class,'destroy']);
     });
});
