<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Jetstream\Http\Livewire\TeamMemberManager;
use Livewire\Livewire;
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

        Livewire::test(TeamMemberManager::class, ['team' => $user->currentTeam])
            ->set('teamMemberIdBeingRemoved', $otherUser->id)
            ->call('removeTeamMember');

        $this->assertCount(0, $user->currentTeam->fresh()->users);
    }

    public function test_only_team_owner_can_remove_team_members(): void
    {
        $user = Doctor::factory()->withPersonalTeam()->create();

        $user->currentTeam->users()->attach(
            $otherUser = Doctor::factory()->create(), ['role' => 'admin']
        );

        $this->actingAs($otherUser);

        Livewire::test(TeamMemberManager::class, ['team' => $user->currentTeam])
            ->set('teamMemberIdBeingRemoved', $user->id)
            ->call('removeTeamMember')
            ->assertStatus(403);
    }
}
