<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    protected $model = Task::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'task_title' => $this->faker->sentence(),
            'client_name' => $this->faker->name(),
            'description' => $this->faker->paragraph(),
            'status' => $this->faker->randomElement([0, 1]),
        ];
    }
}
