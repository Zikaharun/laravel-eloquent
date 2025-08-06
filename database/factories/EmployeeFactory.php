<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'id' => '',
            'name' => '',
            'title' => '',
            'salary' => 0
        ];
    }

    public function programmer()
    {
        return $this->state(function (array $attributes) {
            return [
                'title' => 'programmer',
                'salary' => 50000000
            ];
        });
    }
}
