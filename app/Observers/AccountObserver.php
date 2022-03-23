<?php

namespace App\Observers;

use App\Models\Account;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AccountObserver
{
    public function saving(Account $account)
    {
        $account->slug = Str::slug($account->name, '-');
    }

    public function updating(Account $account)
    {
        if (auth()->id() !== intval($account->user_id)) {
            $error = ValidationException::withMessages([
                'user_id' => ['Invalid account'],
            ]);

            throw $error;
        }
    }
}
