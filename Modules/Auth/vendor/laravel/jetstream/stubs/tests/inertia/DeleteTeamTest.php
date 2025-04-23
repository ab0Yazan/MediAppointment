<?php

namespace Tests\Feature;

use App\Models\Team;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Auth\app\Models\Doctor;
use Tests\TestCase;

class DeleteTeamTest extends TestCase
{
    use RefreshDatabase;

    public function test_teams_can_be_deleted(): void
    {
        $this->actingAs($user = Doctor::factory()->withPersonalTeam()->create());

        $user->ownedTeams()->save($team = Team::factory()->make([
            'personal_team' => false,
        ]));

        $team->users()->attach(
            $otherUser = Doctor::factory()->create(), ['role' => 'test-role']
        );

        $this->delete('/teams/'.$team->id);

        $this->assertNull($team->fresh());
        $this->assertCount(0, $otherUser->fresh()->teams);
    }

    public function test_personal_teams_cant_be_deleted(): void
    {
        $this->actingAs($user = Doctor::factory()->withPersonalTeam()->create());

        $this->delete('/teams/'.$user->currentTeam->id);

        $this->assertNotNull($user->currentTeam->fresh());
    }
}
