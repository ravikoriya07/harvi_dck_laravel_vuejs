<?php

namespace Database\Factories;

use App\Models\Job;
use App\Models\JobCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Job>
 */
class JobFactory extends Factory
{
    protected $model = Job::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(rand(3, 6)),
            'job_category_id' => JobCategory::factory(),
            'description' => fake()->paragraphs(rand(2, 4), true),
        ];
    }
}
