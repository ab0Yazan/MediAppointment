<?php

use Laravel\Jetstream\Http\Livewire\TeamMemberManager;
use Livewire\Livewire;
use Modules\Auth\app\Models\Doctor;

test('users can leave teams', function () {
    $user = Doctor::factory()->withPersonalTeam()->create();

    $user->currentTeam->users()->attach(
        $otherUser = Doctor::factory()->create(), ['role' => 'admin']
    );

    $this->actingAs($otherUser);

    Livewire::test(TeamMemberManager::class, ['team' => $user->currentTeam])
        ->call('leaveTeam');

    expect($user->currentTeam->fresh()->users)->toHaveCount(0);
});

test('team owners cant leave their own team', function () {
    $this->actingAs($user = Doctor::factory()->withPersonalTeam()->create());

    Livewire::test(TeamMemberManager::class, ['team' => $user->currentTeam])
        ->call('leaveTeam')
        ->assertHasErrors(['team']);

    expect($user->currentTeam->fresh())->not->toBeNull();
});
