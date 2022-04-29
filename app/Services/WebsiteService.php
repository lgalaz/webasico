<?php

namespace App\Services;

use App\Models\Template;
use App\Models\Account;
use App\Models\Website;

class WebsiteService
{
    public function store(Account $account, array $params) : Website
    {
        $params['account_id'] = $account->account_id;
        $params['template_id'] = Template::where('name', '=', 'custom')
            ->firstOrFail()
            ->template_id;

        $website = Website::withTrashed()
            ->firstOrCreate(
                ['account_id' => $params['account_id'], 'name' => $params['name']],
                $params,
            );

        $website->restore();

        return $website;
    }

    public function update(Website $website, array $params) : Website
    {
        if (array_key_exists('name', $params)) {
            $previousWebsiteExists = Website::onlyTrashed()->where([
                'account_id' => $website->account_id,
                'name'       => $params['name']
            ])->first();
        }

        if (isset($previousWebsiteExists) && $previousWebsiteExists) {
            $previousWebsiteExists->restore();
            $website->delete();
        } else {
            $website->update($params);
        }

        return $website;
    }
}
