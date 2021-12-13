<?php

namespace App\Strategies\User;

use App\Models\User;
use Illuminate\Support\Collection;

interface TeamInteractionInterface
{
    public function dismissUsers(User | Collection $users): void;
}
