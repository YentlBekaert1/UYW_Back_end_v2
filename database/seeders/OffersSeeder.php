<?php

namespace Database\Seeders;

use App\Models\Offers;
use App\Models\User;
use Database\Factories\Helpers\FactoryHelper;
use Database\Seeders\Traits\DisableForeignKeys;
use Database\Seeders\Traits\TruncateTable;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OffersSeeder extends Seeder
{
    use TruncateTable;
    use DisableForeignKeys;

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->disableForeignKeys();

        $this->truncate('offers');

        $offers = Offers::factory(200)->create();


        // $offers->each(function (Offers $offer){
        //     $offer->users_favorites()->sync([FactoryHelper::getRandomModelId(User::class)]);
        // });

        $this->enableForeignKeys();
    }
}
