<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Auth\app\Models\Doctor;
use Tests\TestCase;

class LeaveTeamTest extends TestCase
{
    use RefreshDatabase;

    public function test_users_can_leave_teams(): void
    {
        $user = Doctor::factory()->withPersonalTeam()->create();

        $user->currentTeam->users()->attach(
            $otherUser = Doctor::factory()->create(), ['role' => 'admin']
        );

        $this->actingAs($otherUser);

        $this->delete('/teams/'.$user->currentTeam->id.'/members/'.$otherUser->id);

        $this->assertCount(0, $user->currentTeam->fresh()->users);
    }

    public function test_team_owners_cant_leave_their_own_team(): void
    {
        $this->actingAs($user = Doctor::factory()->withPersonalTeam()->create());

        $response = $this->delete('/teams/'.$user->currentTeam->id.'/members/'.$user->id);

        $response->assertSessionHasErrorsIn('removeTeamMember', ['team']);

        $this->assertNotNull($user->currentTeam->fresh());
    }
}
