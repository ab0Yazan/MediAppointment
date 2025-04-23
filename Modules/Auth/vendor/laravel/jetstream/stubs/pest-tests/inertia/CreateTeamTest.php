<?php

use Modules\Auth\app\Models\Doctor;

test('teams can be created', function () {
    $this->actingAs($user = Doctor::factory()->withPersonalTeam()->create());

    $this->post('/teams', [
        'name' => 'Test Team',
    ]);

    expect($user->fresh()->ownedTeams)->toHaveCount(2);
    expect($user->fresh()->ownedTeams()->latest('id')->first()->name)->toEqual('Test Team');
});
