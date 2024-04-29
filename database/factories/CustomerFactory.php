<?php

namespace Database\Factories;

use App\Enums\User\UserGender;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'address' => $this->faker->address(),
            'country' =>$this->faker->country(),
            'gender' => UserGender::Female,
            'citizen_id' => $this->faker->uuid(),
            'birth_day' => $this->faker->dateTimeBetween(null,'-18 years'),
        ];
    }
}
