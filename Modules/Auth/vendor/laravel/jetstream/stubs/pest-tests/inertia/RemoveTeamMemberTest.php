<?php

use Modules\Auth\app\Models\Doctor;

test('team members can be removed from teams', function () {
    $this->actingAs($user = Doctor::factory()->withPersonalTeam()->create());

    $user->currentTeam->users()->attach(
        $otherUser = Doctor::factory()->create(), ['role' => 'admin']
    );

    $this->delete('/teams/'.$user->currentTeam->id.'/members/'.$otherUser->id);

    expect($user->currentTeam->fresh()->users)->toHaveCount(0);
});

test('only team owner can remove team members', function () {
    $user = Doctor::factory()->withPersonalTeam()->create();

    $user->currentTeam->users()->attach(
        $otherUser = Doctor::factory()->create(), ['role' => 'admin']
    );

    $this->actingAs($otherUser);

    $response = $this->delete('/teams/'.$user->currentTeam->id.'/members/'.$user->id);

    $response->assertStatus(403);
});
