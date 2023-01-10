<?php

namespace Database\Factories;

use App\Models\Offers;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Locations>
 */
class LocationsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
         //get model count
         $count = Offers::query()->count();

         if($count === 0){
             //if model count is 0
             // we shoeld create a new record and retriefve the record id
             $offerId = Offers::factory()->create();
         }else{
             //generate random number betwen 1 and model count
             $offerId = rand(1, $count);
         }

         return [
            'lat' => $this->faker->latitude(),
            'lon' => $this->faker->longitude(),
            'street' => $this->faker->streetName(),
            'number' => $this->faker->buildingNumber(),
            'postal' => $this->faker->postcode(),
            'city' => $this->faker->city(),
            'country' => $this->faker->country(),
            'offers_id' => $this->faker->unique()->numberBetween(1, 200),
         ];
    }
}
