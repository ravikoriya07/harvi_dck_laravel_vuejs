<?php

namespace Database\Seeders;

use App\Models\TeamMember;
use App\Services\TeamMemberImageMigrationService;
use Illuminate\Database\Seeder;

class TeamMemberSeeder extends Seeder
{
    public function run(): void
    {
        $migration = app(TeamMemberImageMigrationService::class);

        $members = [
            ['name' => 'Anvarjon Umarov',    'position' => 'Project Manager',            'image' => '/assets/images/1.avif'],
            ['name' => 'Iurii Sama',         'position' => 'Division Manager',           'image' => '/assets/images/21.avif'],
            ['name' => 'Oleksandr Morozov',  'position' => 'Contracts Manager',          'image' => '/assets/images/9-scaled.avif'],
            ['name' => 'Tom Sessions',       'position' => 'Managing Quantity Surveyor', 'image' => '/assets/images/8.avif'],
            ['name' => 'Omar Khalid',        'position' => 'Social Value Manager',        'image' => '/assets/images/22-scaled.avif'],
            ['name' => 'Iurii Torchynovich', 'position' => 'Senior Quantity Surveyor',    'image' => '/assets/images/18.avif'],
            ['name' => 'Ruslan Bizans',      'position' => 'Project Manager',            'image' => '/assets/images/11.avif'],
            ['name' => 'Janis Bizans',       'position' => 'Site Manager',               'image' => '/assets/images/16.avif'],
            ['name' => 'Josh Newman',        'position' => 'Site Manager',               'image' => '/assets/images/10.avif'],
            ['name' => 'Dmytro Biienko',     'position' => 'Quantity Surveyor',          'image' => '/assets/images/6-1.avif'],
            ['name' => 'Andrei Capinus',     'position' => 'RLO',                        'image' => '/assets/images/17.avif'],
        ];

        foreach ($members as $index => $member) {
            $image = $migration->migrateLegacyPath($member['image'], $member['name']) ?? $member['image'];

            TeamMember::query()->updateOrCreate(
                ['name' => $member['name']],
                [
                    'position'    => $member['position'],
                    'image'       => $image,
                    'description' => null,
                    'sort_order'  => $index,
                ],
            );
        }
    }
}
