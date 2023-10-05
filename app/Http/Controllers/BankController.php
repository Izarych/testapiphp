<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BankController extends Controller
{
    public function create(Request $request): JsonResponse
    {
        $request->validate([
            'bank_name' => 'required|string'
        ]);

        $bank = Bank::create($request->all());

        return response()->json([
            'message' => 'Банк был создан',
            'data' => $bank
        ], 201);
    }
}
