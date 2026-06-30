<?php

use App\Services\TeamMemberImageMigrationService;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        if (! \Illuminate\Support\Facades\Schema::hasTable('team_members')) {
            return;
        }

        app(TeamMemberImageMigrationService::class)->migrateAllTeamMembers();
    }

    public function down(): void
    {
        // Irreversible: originals remain in public/assets.
    }
};
