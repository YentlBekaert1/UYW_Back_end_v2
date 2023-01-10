<?php

namespace Database\Seeders\Traits;

use Illuminate\Support\Facades\DB;

Trait DisableForeignKeys
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    protected function disableForeignKeys()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
    }

    protected function enableForeignKeys()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
