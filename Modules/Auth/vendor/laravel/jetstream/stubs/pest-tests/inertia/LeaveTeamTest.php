<?php

use Modules\Auth\app\Models\Doctor;

test('users can leave teams', function () {
    $user = Doctor::factory()->withPersonalTeam()->create();

    $user->currentTeam->users()->attach(
        $otherUser = Doctor::factory()->create(), ['role' => 'admin']
    );

    $this->actingAs($otherUser);

    $this->delete('/teams/'.$user->currentTeam->id.'/members/'.$otherUser->id);

    expect($user->currentTeam->fresh()->users)->toHaveCount(0);
});

test('team owners cant leave their own team', function () {
    $this->actingAs($user = Doctor::factory()->withPersonalTeam()->create());

    $response = $this->delete('/teams/'.$user->currentTeam->id.'/members/'.$user->id);

    $response->assertSessionHasErrorsIn('removeTeamMember', ['team']);

    expect($user->currentTeam->fresh())->not->toBeNull();
});
