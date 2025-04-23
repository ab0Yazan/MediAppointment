<?php

namespace Tests\Feature;

use App\Models\Team;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Jetstream\Http\Livewire\DeleteTeamForm;
use Livewire\Livewire;
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

        Livewire::test(DeleteTeamForm::class, ['team' => $team->fresh()])
            ->call('deleteTeam');

        $this->assertNull($team->fresh());
        $this->assertCount(0, $otherUser->fresh()->teams);
    }

    public function test_personal_teams_cant_be_deleted(): void
    {
        $this->actingAs($user = Doctor::factory()->withPersonalTeam()->create());

        Livewire::test(DeleteTeamForm::class, ['team' => $user->currentTeam])
            ->call('deleteTeam')
            ->assertHasErrors(['team']);

        $this->assertNotNull($user->currentTeam->fresh());
    }
}
