<?php

namespace Database\Seeders\Traits;

use Illuminate\Support\Facades\DB;

Trait TruncateTable
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    protected function truncate($table)
    {
        DB::table($table)->truncate();
    }
}
