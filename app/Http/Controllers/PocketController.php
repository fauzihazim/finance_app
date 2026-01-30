<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserPocket;

use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
// use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class PocketController extends Controller
{
    public function store(Request $request)
    {
        try {
            // Validasi input
            $request->validate([
                'name' => 'required|string|max:255',
                'initial_balance' => 'required|numeric|min:0',
            ]);

            // Simpan ke database
            // $pocket = UserPocket::create([
            //     'name' => $request->name,
            //     'initial_balance' => $request->initial_balance,
            // ]);
            $user = JWTAuth::parseToken()->authenticate();

            $pocket = UserPocket::create([
                'user_id' => $user->id,
                'name' => $request->name,
                'balance' => $request->initial_balance, // mapping ke kolom balance
            ]);

            // Response JSON
            return response()->json([
                'status' => 200,
                'error' => false,
                'message' => "Berhasil membuat pocket baru.",
                'data' => [
                    'id' => $pocket->id
                ]
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 422,
                'error' => true,
                'message' => 'Validasi gagal.',
                'data' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'error' => true,
                'message' => 'Terjadi kesalahan pada server.',
                'detail' => $e->getMessage(), // opsional
            ], 500);
        }
    }
}
