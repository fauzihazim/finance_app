<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
// use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 422,
                'error' => true,
                'message' => 'Validasi gagal.',
                'data' => $e->errors()
            ], 422);
        }
        try {
            $user = User::where('email', $request->email)->first();
            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'status' => 401,
                    'error' => true,
                    'message' => 'Email atau password salah.',
                ], 401);
            }
            $token = JWTAuth::fromUser($user);
            return response()->json([
                'status' => 200,
                'error' => false,
                'message' => 'Berhasil login.',
                'data' => [
                    'token' => $token
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'error' => true,
                'message' => 'Terjadi kesalahan pada server.',
                'detail' => $e->getMessage(),
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'status' => 200,
            'error' => false,
            'message' => 'Berhasil logout.',
        ], 200);
    }
}
