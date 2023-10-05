<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\DealerCredit;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DealerCreditController extends Controller
{
    // В идеале перенести в Helpers?
    public function validateRequest(Request $request): void
    {
        $request->validate([
            'dealer_name' => 'required|string',
            'contact_person' => 'required|string',
            'loan_amount' => 'required|numeric',
            'loan_term' => 'required|integer',
            'interest_rate' => 'required|numeric',
            'reason' => 'required|string',
            'bank_id' => 'required|integer',
        ]);
    }

    public function create(Request $request): JsonResponse
    {
        $this->validateRequest($request);

        // Создаем заявку
        try {
            $data = $request->all();
            $data['bank_id'] = $request->input('bank_id');
            $data['status'] = 'new';
            $dealerCredit = DealerCredit::create($data);

            // Возвращаем ответ
            return response()->json([
                'message' => 'Заявка создана успешно',
                'data' => $dealerCredit
            ], 201);
        } catch (\Exception $e)
        {
            // Возвращаем ошибку если словили
            return response()->json([
                'message' => 'Произошла ошибка при создании заявки',
                'error' => $e
            ], 500);
        }
    }

    public function index(Request $request): JsonResponse
    {
        $maxDealerCredit = DealerCredit::all()->count();

        // Валидируем
        $request->validate([
            'offset' => 'integer|min:0',
            'limit' => "integer|min:1|max:$maxDealerCredit",
        ]);

        // Получаем offset и limit из запроса для пагинации
        $offset = $request->query('offset', 0);
        $limit = $request->query('limit', $maxDealerCredit);

//        $dealerCredits = DealerCredit::offset($offset)->limit($limit)->get();
        $dealerCredits = DealerCredit::with('bank')->offset($offset)->limit($limit)->get();

        foreach ($dealerCredits as $credit) {
            $credit->bank;
        }
        if ($dealerCredits->isEmpty())
        {
            return response()->json([
                'message' => 'Заявки не найдены'
            ], 404);
        }

        // Возвращаем список заявок с пагинацией (200 - default status, не вписываем явно)
        return response()->json([
            'data' => $dealerCredits,
            'meta' => [
                'offset' => $offset,
                'limit' => $limit,
                'total' => $maxDealerCredit
            ],
        ]);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $this->validateRequest($request);

        // Находим заявку по id
        $dealerCredit = DealerCredit::find($id);

        if (!$dealerCredit)
        {
            return response()->json([
                'message' => 'Заявка не найдена'
            ], 404);
        }

        // Обновляем данные
        $dealerCredit->update($request->all());

        // Возвращаем ответ
        return response()->json([
            'message' => 'Заявка успешно обновлена',
            'data' => $dealerCredit
        ]);
    }

    public function delete($id): JsonResponse
    {
        $dealerCredit = DealerCredit::find($id);

        if (!$dealerCredit) {
            return response()->json([
                'message' => 'Заявка не найдена'
            ], 404);
        }

        $dealerCreditId = $dealerCredit->id;

        // Удаляем заявку
        $dealerCredit->delete();

        return response()->json([
            'message' => 'Заявка ' . $dealerCreditId . ' удалена успешно'
        ]);
    }

}
