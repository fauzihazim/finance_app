<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expense;
use App\Models\UserPocket;
use Tymon\JWTAuth\Facades\JWTAuth;

class ExpenseController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'pocket_id' => 'required|uuid|exists:user_pockets,id',
                'amount'    => 'required|numeric|min:1',
                'notes'     => 'nullable|string|max:255',
            ]);

            $user = JWTAuth::parseToken()->authenticate();
            
            $pocket = UserPocket::where('id', $request->pocket_id)
                                ->where('user_id', $user->id)
                                ->firstOrFail();
                                
            if ($pocket->balance < $request->amount) {
                return response()->json([
                    'status'  => 400,
                    'error'   => true,
                    'message' => 'Saldo pocket tidak mencukupi.',
                ], 400);
            }
            
            $expense = Expense::create([
                'user_id'   => $user->id,
                'pocket_id' => $pocket->id,
                'amount'    => $request->amount,
                'notes'     => $request->notes,
            ]);
            
            $pocket->balance -= $request->amount;
            $pocket->save();
            
            return response()->json([
                'status'  => 200,
                'error'   => false,
                'message' => 'Berhasil menambahkan expense.',
                'data'    => [
                    'id'              => $expense->id,
                    'pocket_id'       => $pocket->id,
                    'current_balance' => $pocket->balance,
                ]
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status'  => 422,
                'error'   => true,
                'message' => 'Validasi gagal.',
                'data'    => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 500,
                'error'   => true,
                'message' => 'Terjadi kesalahan pada server.',
                'detail'  => $e->getMessage(),
            ], 500);
        }
    }
}