<?php

namespace Database\Seeders;

use App\Enums\JobCategoryStatus;
use App\Models\JobCategory;
use Database\Seeders\Data\IndianJobMarketSeedData;
use Illuminate\Database\Seeder;

class JobCategorySeeder extends Seeder
{
    /**
     * Seed Indian job market categories (idempotent by slug).
     */
    public function run(): void
    {
        foreach (IndianJobMarketSeedData::categories() as $category) {
            JobCategory::query()->firstOrCreate(
                ['slug' => $category['slug']],
                [
                    'name' => $category['name'],
                    'status' => JobCategoryStatus::Active,
                ],
            );
        }
    }
}
