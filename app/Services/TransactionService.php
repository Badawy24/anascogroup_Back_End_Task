<?php

namespace App\Services;

use App\Models\Transaction;

class TransactionService
{
    public function log(array $data): Transaction
    {
        return Transaction::create($data);
    }

    public function forUser($user)
    {
        return $user->transactions()->latest()->get();
    }

    public function storeFromStripeSession($session)
    {
        $transaction = Transaction::where([
            ['user_id', $session->metadata->user_id ?? null],
            ['plan_id', $session->metadata->plan_id ?? null],
            ['status', 'pending'],
        ])->latest()->first();

        if (!$transaction) {
            return;
        }

        $transaction->update([
            'status' => 'success',
            'payment_id' => $session->id,
            'amount' => $session->amount_total / 100,
        ]);
    }
}
