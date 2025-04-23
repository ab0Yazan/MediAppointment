<?php

use Laravel\Jetstream\Features;
use Modules\Auth\app\Models\Doctor;

test('confirm password screen can be rendered', function () {
    $user = Features::hasTeamFeatures()
                    ? Doctor::factory()->withPersonalTeam()->create()
                    : Doctor::factory()->create();

    $response = $this->actingAs($user)->get('/user/confirm-password');

    $response->assertStatus(200);
});

test('password can be confirmed', function () {
    $user = Doctor::factory()->create();

    $response = $this->actingAs($user)->post('/user/confirm-password', [
        'password' => 'password',
    ]);

    $response->assertRedirect();
    $response->assertSessionHasNoErrors();
});

test('password is not confirmed with invalid password', function () {
    $user = Doctor::factory()->create();

    $response = $this->actingAs($user)->post('/user/confirm-password', [
        'password' => 'wrong-password',
    ]);

    $response->assertSessionHasErrors();
});
