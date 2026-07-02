<?php

use App\Models\TeamDepartment;
use App\Models\TeamMember;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        $departments = [
            ['name' => 'Senior Management Team', 'sort_order' => 0],
            ['name' => 'Support Team', 'sort_order' => 1],
            ['name' => 'Operations Team', 'sort_order' => 2],
        ];

        foreach ($departments as $department) {
            TeamDepartment::query()->firstOrCreate(
                ['name' => $department['name']],
                ['sort_order' => $department['sort_order']],
            );
        }

        $departmentIds = TeamDepartment::query()->pluck('id', 'name');

        $assignments = [
            'Senior Management Team' => [
                'Division Manager',
                'Contracts Manager',
                'Managing Quantity Surveyor',
                'Social Value Manager',
            ],
            'Support Team' => [
                'Senior Quantity Surveyor',
                'Quantity Surveyor',
                'RLO',
            ],
            'Operations Team' => [
                'Project Manager',
                'Site Manager',
            ],
        ];

        foreach ($assignments as $departmentName => $positions) {
            $departmentId = $departmentIds[$departmentName] ?? null;

            if ($departmentId === null) {
                continue;
            }

            TeamMember::query()
                ->whereNull('team_department_id')
                ->whereIn('position', $positions)
                ->update(['team_department_id' => $departmentId]);
        }

        $fallbackDepartmentId = $departmentIds['Operations Team'] ?? null;

        if ($fallbackDepartmentId !== null) {
            TeamMember::query()
                ->whereNull('team_department_id')
                ->update(['team_department_id' => $fallbackDepartmentId]);
        }
    }

    public function down(): void
    {
        TeamMember::query()->update(['team_department_id' => null]);
        TeamDepartment::query()->delete();
    }
};
