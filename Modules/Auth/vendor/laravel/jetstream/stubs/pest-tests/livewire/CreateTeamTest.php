<?php

use Laravel\Jetstream\Http\Livewire\CreateTeamForm;
use Livewire\Livewire;
use Modules\Auth\app\Models\Doctor;

test('teams can be created', function () {
    $this->actingAs($user = Doctor::factory()->withPersonalTeam()->create());

    Livewire::test(CreateTeamForm::class)
        ->set(['state' => ['name' => 'Test Team']])
        ->call('createTeam');

    expect($user->fresh()->ownedTeams)->toHaveCount(2);
    expect($user->fresh()->ownedTeams()->latest('id')->first()->name)->toEqual('Test Team');
});
