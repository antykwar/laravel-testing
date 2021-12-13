<?php

namespace App\Strategies\User;

use App\Models\User;
use Illuminate\Support\Collection;

class TeamLeavingStrategy implements TeamInteractionInterface
{
    public function dismissUsers(User | Collection $users): void
    {
        if ($users instanceof User) {
            $users = collect([$users]);
        }

        User::whereIn('id', $users->pluck('id'))
            ->update(['team_id' => null]);
    }
}
