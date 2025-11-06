<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\Payment;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Stripe\StripeClient;

class ProcessPaymentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, SerializesModels;

    protected $payload;

    /**
     * Create a new job instance.
     */
    public function __construct($payload)
    {
        $this->payload = $payload;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $eventType = $this->payload['type'] ?? '';
        $data = $this->payload['data']['object'] ?? [];

        if ($eventType === 'invoice.paid' && !empty($data['customer_email'])) {
            $user = User::where('email', $data['customer_email'])->first();

            if ($user) {
                $stripe = new StripeClient(env('STRIPE_SECRET'));

                // Haal de factuur op van Stripe
                $invoice = $stripe->invoices->retrieve($data['id'], []);

                // Update of maak betaling aan
                Payment::updateOrCreate(
                    ['stripe_id' => $data['id']],
                    [
                        'user_id' => $user->id,
                        'amount' => isset($data['amount_paid']) ? $data['amount_paid'] / 100 : 0,
                        'status' => $data['status'] ?? 'paid',
                        'invoice_pdf' => $invoice->invoice_pdf ?? null,
                    ]
                );
            }
        }
    }
}
