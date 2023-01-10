<?php

namespace Database\Factories;

use App\Models\Offers;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Offers>
 */
class OffersFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        //get model count
        $count = User::query()->count();

        if($count === 0){
            //if model count is 0
            // we shoeld create a new record and retriefve the record id
            $userId = User::factory()->create();
        }else{
            //generate random number betwen 1 and model count
            $userId = rand(1, $count);
        }

        return [
            'title' => $this->faker->word,
            'description' =>[$this->faker->text(250)],
            'categories_id' => rand(1, 5),
            'approaches_id' => 1,
            'user_id' => $userId,
        ];
    }
}
