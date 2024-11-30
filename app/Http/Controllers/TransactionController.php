<?php
namespace App\Http\Controllers;


use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class TransactionController extends Controller
{
    public function create(Request $request)
    {
        // Validate request
        $validator = Validator::make($request->all(), [
            'card_number' => 'required|string',
            'amount' => 'required|numeric|gt:0',
            'currency' => 'required|string|size:3',
            'customer_email' => 'required|email',
            'metadata' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Apply card validation logic here
        $status = $this->validateCard($request->card_number, $request->amount, $request->currency, $request->metadata);

        // Create transaction
        $transaction = Transaction::create([
            'masked_card_number' => substr($request->card_number, 0, 6) . '******' . substr($request->card_number, -4),
            'amount' => $request->amount,
            'currency' => $request->currency,
            'customer_email' => $request->customer_email,
            'metadata' => $request->metadata,
            'status' => $status,
        ]);

        return response()->json([
            'transaction_id' => $transaction->id,
            'card_number' => $request->card_number,
            'amount' => $request->amount,
            'currency' => $request->currency,
            'customer_email' => $request->customer_email,
            'status' => $status,
            'metadata' => $request->metadata,
            'created_at' => $transaction->created_at,
            'updated_at' => $transaction->updated_at,
        ], 201);
    }

    private function validateCard($cardNumber, $amount, $currency, $metadata)
    {
        // Implement card validation rules here
        // Example for card number validation
        if ($cardNumber == '1234567890123456') {
            return 'approved';
        }
        return 'declined'; // Default status for invalid cards
    }

    public function show($id)
    {
        $transaction = Transaction::find($id);
        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found.'], 404);
        }

        return response()->json($transaction);
    }
}
