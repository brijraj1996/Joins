<?php

namespace Database\Factories;

use App\Models\task;
use Illuminate\Database\Eloquent\Factories\Factory;
use SebastianBergmann\CodeCoverage\Report\Xml\Project;

class TaskFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = task::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'project_id' => Project::factory(),
            'duration' => $this->faker->numberBetween(1,100)        
        ];
    }
}
