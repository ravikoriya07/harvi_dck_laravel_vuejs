<?php

namespace Database\Seeders;

use App\Models\TeamDepartment;
use App\Models\TeamMember;
use App\Services\TeamMemberImageMigrationService;
use Illuminate\Database\Seeder;

class TeamMemberSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(TeamDepartmentSeeder::class);

        $migration = app(TeamMemberImageMigrationService::class);

        $departments = TeamDepartment::query()
            ->pluck('id', 'name');

        $members = [
            ['name' => 'Iurii Sama',         'position' => 'Division Manager',           'image' => '/assets/images/21.avif',           'department' => 'Senior Management Team'],
            ['name' => 'Oleksandr Morozov',  'position' => 'Contracts Manager',          'image' => '/assets/images/9-scaled.avif',     'department' => 'Senior Management Team'],
            ['name' => 'Tom Sessions',       'position' => 'Managing Quantity Surveyor', 'image' => '/assets/images/8.avif',            'department' => 'Senior Management Team'],
            ['name' => 'Omar Khalid',        'position' => 'Social Value Manager',        'image' => '/assets/images/22-scaled.avif',    'department' => 'Senior Management Team'],
            ['name' => 'Iurii Torchynovich', 'position' => 'Senior Quantity Surveyor',    'image' => '/assets/images/18.avif',           'department' => 'Support Team'],
            ['name' => 'Dmytro Biienko',     'position' => 'Quantity Surveyor',          'image' => '/assets/images/6-1.avif',          'department' => 'Support Team'],
            ['name' => 'Andrei Capinus',     'position' => 'RLO',                        'image' => '/assets/images/17.avif',           'department' => 'Support Team'],
            ['name' => 'Anvarjon Umarov',    'position' => 'Project Manager',            'image' => '/assets/images/1.avif',            'department' => 'Operations Team'],
            ['name' => 'Ruslan Bizans',      'position' => 'Project Manager',            'image' => '/assets/images/11.avif',           'department' => 'Operations Team'],
            ['name' => 'Janis Bizans',       'position' => 'Site Manager',               'image' => '/assets/images/16.avif',           'department' => 'Operations Team'],
            ['name' => 'Josh Newman',        'position' => 'Site Manager',               'image' => '/assets/images/10.avif',           'department' => 'Operations Team'],
        ];

        foreach ($members as $index => $member) {
            $image = $migration->migrateLegacyPath($member['image'], $member['name']) ?? $member['image'];

            TeamMember::query()->updateOrCreate(
                ['name' => $member['name']],
                [
                    'position'            => $member['position'],
                    'team_department_id'  => $departments[$member['department']] ?? null,
                    'image'               => $image,
                    'description'         => null,
                    'sort_order'          => $index,
                ],
            );
        }
    }
}
