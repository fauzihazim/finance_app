<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Income;
use App\Models\UserPocket;
use Tymon\JWTAuth\Facades\JWTAuth;

class IncomeController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'pocket_id' => 'required|uuid|exists:user_pockets,id',
                'amount' => 'required|numeric|min:1',
                'notes' => 'nullable|string|max:255',
            ]);
            
            $user = JWTAuth::parseToken()->authenticate();
            
            $pocket = UserPocket::where('id', $request->pocket_id)
                                ->where('user_id', $user->id)
                                ->firstOrFail();

            $income = Income::create([
                'user_id'   => $user->id,       // tambahkan ini
                'pocket_id' => $pocket->id,
                'amount'    => $request->amount,
                'notes'     => $request->notes,
            ]);
            
            $pocket->balance += $request->amount;
            $pocket->save();
            
            return response()->json([
                'status' => 200,
                'error' => false,
                'message' => 'Berhasil menambahkan income.',
                'data' => [
                    'id' => $income->id,
                    'pocket_id' => $pocket->id,
                    'current_balance' => $pocket->balance,
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
                'detail' => $e->getMessage(),
            ], 500);
        }
    }
}