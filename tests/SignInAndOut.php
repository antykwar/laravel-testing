<?php

namespace Tests;

use App\Models\User;

trait SignInAndOut
{
    protected User $user;

    public function signIn(User $user = null)
    {
        $this->user = $user ?? User::factory()->create();
        $this->actingAs($this->user);

        return $this;
    }
}
