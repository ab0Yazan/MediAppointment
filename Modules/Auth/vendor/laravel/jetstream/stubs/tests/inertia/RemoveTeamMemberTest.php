<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Auth\app\Models\Doctor;
use Tests\TestCase;

class RemoveTeamMemberTest extends TestCase
{
    use RefreshDatabase;

    public function test_team_members_can_be_removed_from_teams(): void
    {
        $this->actingAs($user = Doctor::factory()->withPersonalTeam()->create());

        $user->currentTeam->users()->attach(
            $otherUser = Doctor::factory()->create(), ['role' => 'admin']
        );

        $this->delete('/teams/'.$user->currentTeam->id.'/members/'.$otherUser->id);

        $this->assertCount(0, $user->currentTeam->fresh()->users);
    }

    public function test_only_team_owner_can_remove_team_members(): void
    {
        $user = Doctor::factory()->withPersonalTeam()->create();

        $user->currentTeam->users()->attach(
            $otherUser = Doctor::factory()->create(), ['role' => 'admin']
        );

        $this->actingAs($otherUser);

        $response = $this->delete('/teams/'.$user->currentTeam->id.'/members/'.$user->id);

        $response->assertStatus(403);
    }
}
