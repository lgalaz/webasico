<?php

namespace App\Utils;

use Illuminate\Support\Arr;

trait ValidatesEnvironment
{
    /**
     * Throw exception is environment is not valid.
     *
     * @param array|string Valid environments.
     *
     * @return void
     */
    public function validateRunningEnvironment($validEnvironments = ['local']): void
    {
        $validEnvironments = Arr::wrap($validEnvironments);

        if (!app()->environment($validEnvironments)) {
            throw new \Exception('Running environment is incorrect. Can only run this in: ' . implode(',', $validEnvironments));
        }
    }
}
