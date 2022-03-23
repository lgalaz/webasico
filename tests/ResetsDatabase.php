<?php

namespace Tests;

use File;

trait ResetsDatabase
{
    public function resetDatabaseFile()
    {
        File::copy(database_path('dump.sqlite'), database_path('database.sqlite'));
    }
}
