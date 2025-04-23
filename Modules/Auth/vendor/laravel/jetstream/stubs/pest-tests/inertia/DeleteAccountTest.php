<?php

use Laravel\Jetstream\Features;
use Modules\Auth\app\Models\Doctor;

test('user accounts can be deleted', function () {
    $this->actingAs($user = Doctor::factory()->create());

    $this->delete('/user', [
        'password' => 'password',
    ]);

    expect($user->fresh())->toBeNull();
})->skip(function () {
    return ! Features::hasAccountDeletionFeatures();
}, 'Account deletion is not enabled.');

test('correct password must be provided before account can be deleted', function () {
    $this->actingAs($user = Doctor::factory()->create());

    $this->delete('/user', [
        'password' => 'wrong-password',
    ]);

    expect($user->fresh())->not->toBeNull();
})->skip(function () {
    return ! Features::hasAccountDeletionFeatures();
}, 'Account deletion is not enabled.');
