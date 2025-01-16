<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Job>
 */
class JobFactory extends Factory
{
    protected $model = \App\Models\Module\Job::class;

    public function definition()
    {
        return [
            'job_title' => $this->faker->jobTitle(),
            'code_job' => strtoupper($this->faker->unique()->lexify('JP????')),
            'category' => $this->faker->randomElement(['Engineer', 'Marketing', 'Design', 'Finance']),
            'contract_status' => $this->faker->randomElement(['full-time', 'contract']),
            'location' => $this->faker->randomElement(['Kalimantan Timur', 'Kalimantan Barat', 'Kalimantan Utara']),
            'experience_years' => $this->faker->numberBetween(0, 20),
            'job_description' => $this->faker->paragraph,
            'skills_required' => $this->faker->randomElements(['PHP', 'JavaScript', 'Python', 'SQL', 'Linux', 'Cloud Computing'], $this->faker->numberBetween(1, 5))
        ];
    }
}