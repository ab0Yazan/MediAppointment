<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Jetstream\Http\Livewire\UpdateTeamNameForm;
use Livewire\Livewire;
use Modules\Auth\app\Models\Doctor;
use Tests\TestCase;

class UpdateTeamNameTest extends TestCase
{
    use RefreshDatabase;

    public function test_team_names_can_be_updated(): void
    {
        $this->actingAs($user = Doctor::factory()->withPersonalTeam()->create());

        Livewire::test(UpdateTeamNameForm::class, ['team' => $user->currentTeam])
            ->set(['state' => ['name' => 'Test Team']])
            ->call('updateTeamName');

        $this->assertCount(1, $user->fresh()->ownedTeams);
        $this->assertEquals('Test Team', $user->currentTeam->fresh()->name);
    }
}
