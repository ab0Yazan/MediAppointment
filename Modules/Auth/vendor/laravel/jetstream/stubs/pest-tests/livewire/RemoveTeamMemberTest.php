<?php

use Laravel\Jetstream\Http\Livewire\TeamMemberManager;
use Livewire\Livewire;
use Modules\Auth\app\Models\Doctor;

test('team members can be removed from teams', function () {
    $this->actingAs($user = Doctor::factory()->withPersonalTeam()->create());

    $user->currentTeam->users()->attach(
        $otherUser = Doctor::factory()->create(), ['role' => 'admin']
    );

    Livewire::test(TeamMemberManager::class, ['team' => $user->currentTeam])
        ->set('teamMemberIdBeingRemoved', $otherUser->id)
        ->call('removeTeamMember');

    expect($user->currentTeam->fresh()->users)->toHaveCount(0);
});

test('only team owner can remove team members', function () {
    $user = Doctor::factory()->withPersonalTeam()->create();

    $user->currentTeam->users()->attach(
        $otherUser = Doctor::factory()->create(), ['role' => 'admin']
    );

    $this->actingAs($otherUser);

    Livewire::test(TeamMemberManager::class, ['team' => $user->currentTeam])
        ->set('teamMemberIdBeingRemoved', $user->id)
        ->call('removeTeamMember')
        ->assertStatus(403);
});
