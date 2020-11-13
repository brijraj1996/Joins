<?php

namespace Database\Factories;

use App\Models\Firm;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker;

class FirmFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Firm::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'address' => $this->faker->sentence(),
            'f_name' => $this->faker->sentence()
        ];
    }
}
