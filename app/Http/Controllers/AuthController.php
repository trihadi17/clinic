<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(UserRequest $request){

        try {
            // Invalid Credentials (Jika data email/password tidak terdaftar)
            if(!$token = JWTAuth::attempt($request->only('email','password'))) {
                return response([
                    'success' => false,
                    'message' => 'Invalid credentials',
                ], 401);
            }

            // Current user
            $user = JWTAuth::user();

            return response([
                'success' => true,
                'message' => 'Login Successfull',
                'data' => [
                    'user' => [
                        'id' => $user->id,
                        'email' => $user->email,
                        'name' => $user->name
                    ],
                    'token_type' => 'bearer',
                    'token' => $token,
                    'expires_in' => JWTAuth::factory()->getTTL() * 60,
                ],
            ], 200);
        } catch (\Throwable $e) {
            return response([
                'status' => false,
                'message' => 'Could not create token'
            ], 500);
        }
    }

    public function getUser(){
        try {
            // Current user
            $user = JWTAuth::user();

            return response([
                'success' => true,
                'message' => 'User retrieved successfully',
                'data' => $user,
            ], 200);

        } catch (\Exception $e) {
            return response([
                'status' => false,
                'message' => 'Could not retrieve user',
            ], 500);
        }
    }

    public function refresh(){
        try {
            // Token refresh
            $newToken = JWTAuth::refresh(JWTAuth::getToken());

            return response([
                'success' => true,
                'message' => 'Token refreshed sucessfully',
                'data' => [
                    'token' => $newToken,
                    'expires_in' => JWTAuth::factory()->getTTL() * 60,
                ]
            ],200);
        } catch (\Throwable $e) {
            return response([
                'status' => false,
                'message' => 'Could not refresh token'
            ], 500);
        }
    }

    public function logout(){
        try {
            // Membatalkan token yang sedang aktif
            JWTAuth::invalidate(JWTAuth::getToken());

            return response([
                'success' => true,
                'message' => 'Logged out sucessfully'
            ],200);
        } catch (\Throwable $e) {
            return response([
                'status' => false,
                'message' => 'Could not log out'
            ], 500);
        }
    }
}
