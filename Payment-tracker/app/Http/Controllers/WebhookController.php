<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Payment;

class WebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->all();
        $eventType = $payload['type'] ?? '';
        $data = $payload['data']['object'] ?? [];

        if ($eventType === 'invoice.paid' && !empty($data['customer_email'])) {
            $user = User::where('email', $data['customer_email'])->first();

            if ($user) {
                Payment::updateOrCreate(
                    ['stripe_id' => $data['id']],
                    [
                        'user_id' => $user->id,
                        'amount' => isset($data['amount_paid']) ? $data['amount_paid'] / 100 : 0,
                        'status' => $data['status'] ?? 'paid',
                        'invoice_pdf' => $data['invoice_pdf'] ?? null,
                    ]
                );
            }
        }

        return response()->json(['status' => 'ok']);
    }
}
