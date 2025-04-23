<?php

use Modules\Auth\app\Models\Doctor;

test('team names can be updated', function () {
    $this->actingAs($user = Doctor::factory()->withPersonalTeam()->create());

    $this->put('/teams/'.$user->currentTeam->id, [
        'name' => 'Test Team',
    ]);

    expect($user->fresh()->ownedTeams)->toHaveCount(1);
    expect($user->currentTeam->fresh()->name)->toEqual('Test Team');
});
