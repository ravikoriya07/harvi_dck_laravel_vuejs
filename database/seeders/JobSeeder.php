<?php

namespace Database\Seeders;

use App\Models\Job;
use App\Models\JobCategory;
use Database\Seeders\Data\IndianJobMarketSeedData;
use Illuminate\Database\Seeder;

class JobSeeder extends Seeder
{
    /**
     * Seed realistic Indian job listings (no Lorem / Faker).
     * Uses firstOrCreate on title + category to stay idempotent on re-run.
     */
    public function run(): void
    {
        $categoryIdsBySlug = JobCategory::query()
            ->pluck('id', 'slug');

        if ($categoryIdsBySlug->isEmpty()) {
            $this->command?->warn('JobSeeder skipped: no job categories. Run JobCategorySeeder first.');

            return;
        }

        foreach (IndianJobMarketSeedData::jobs() as $job) {
            $categoryId = $categoryIdsBySlug->get($job['category_slug']);

            if ($categoryId === null) {
                $this->command?->warn("JobSeeder: missing category slug [{$job['category_slug']}] for job [{$job['title']}].");

                continue;
            }

            Job::query()->firstOrCreate(
                [
                    'title' => $job['title'],
                    'job_category_id' => $categoryId,
                ],
                [
                    'description' => IndianJobMarketSeedData::formatDescription($job),
                ],
            );
        }
    }
}
