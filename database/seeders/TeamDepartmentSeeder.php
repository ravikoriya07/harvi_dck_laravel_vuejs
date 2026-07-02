<?php

namespace Database\Seeders;

use App\Models\TeamDepartment;
use Illuminate\Database\Seeder;

class TeamDepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            ['name' => 'Senior Management Team', 'sort_order' => 0],
            ['name' => 'Support Team', 'sort_order' => 1],
            ['name' => 'Operations Team', 'sort_order' => 2],
        ];

        foreach ($departments as $department) {
            TeamDepartment::query()->updateOrCreate(
                ['name' => $department['name']],
                ['sort_order' => $department['sort_order']],
            );
        }
    }
}
