<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Auth\app\Models\Doctor;
use Tests\TestCase;

class UpdateTeamNameTest extends TestCase
{
    use RefreshDatabase;

    public function test_team_names_can_be_updated(): void
    {
        $this->actingAs($user = Doctor::factory()->withPersonalTeam()->create());

        $this->put('/teams/'.$user->currentTeam->id, [
            'name' => 'Test Team',
        ]);

        $this->assertCount(1, $user->fresh()->ownedTeams);
        $this->assertEquals('Test Team', $user->currentTeam->fresh()->name);
    }
}
