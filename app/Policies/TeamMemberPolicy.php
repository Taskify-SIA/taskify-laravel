<?php

namespace App\Policies;

use App\Models\TeamMember;
use App\Models\User;

class TeamMemberPolicy
{
    public function update(User $user, TeamMember $teamMember): bool
    {
        return $user->id === $teamMember->user_id;
    }

    public function delete(User $user, TeamMember $teamMember): bool
    {
        return $user->id === $teamMember->user_id;
    }
}