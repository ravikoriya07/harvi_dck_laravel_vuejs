<?php

namespace App\Filament\Admin\Resources\TeamMembers\Pages;

use App\Filament\Admin\Resources\TeamMembers\TeamMemberResource;
use Filament\Resources\Pages\EditRecord;

class EditTeamMember extends EditRecord
{
    protected static string $resource = TeamMemberResource::class;
}
