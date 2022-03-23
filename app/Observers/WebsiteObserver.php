<?php

namespace App\Observers;

use App\Models\Website;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class WebsiteObserver
{
    public function saving(Website $website)
    {
        $website->slug = Str::slug($website->name, '-');
    }

    public function deleting(Website $website)
    {
        $accountWebsites = Website::where('account_id', '=', $website->account_id)->get();

        if ($accountWebsites->count() === 1) {
            $error = ValidationException::withMessages([
                'name' => ['Can not delete the last website in this account.'],
            ]);

            throw $error;
        }
    }
}
