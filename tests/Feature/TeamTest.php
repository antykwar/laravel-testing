<?php

namespace Tests\Feature;

use App\Models\Team;
use App\Models\User;
use Exception;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TeamTest extends TestCase
{
    use DatabaseTransactions;

    public function test_a_team_has_a_name()
    {
        $team = new Team(['name' => 'JediTemple']);
        $this->assertEquals('JediTemple', $team->name);
    }

    public function test_a_team_can_add_members()
    {
        $team = Team::factory()->create();
        $user = User::factory()->create();
        $user2 = User::factory()->create();

        $team->add($user);
        $team->add($user2);

        $this->assertEquals(2, $team->count());
    }

    public function test_a_team_has_maximum_size()
    {
        $team = Team::factory()->create(['size' => 2]);

        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $team->add($user1);
        $team->add($user2);

        $this->assertEquals(2, $team->count());

        $this->expectException(Exception::class);
        $user3 = User::factory()->create();
        $team->add($user3);
    }

    public function test_team_can_add_multiple_members()
    {
        $team = Team::factory()->create();
        $users = User::factory(3)->create();
        $team->add($users);

        $this->assertEquals(3, $team->count());
    }

    public function test_team_can_remove_a_member()
    {
        $team = Team::factory()->create();
        $users = User::factory(3)->create();
        $team->add($users);

        $team->removeUser($users->first());

        $this->assertEquals(2, $team->count());
    }

    public function test_team_can_remove_all_members()
    {
        $team = Team::factory()->create();
        $users = User::factory(3)->create();
        $team->add($users);

        $team->exterminateUsers();

        $this->assertEquals(0, $team->count());
    }
}
