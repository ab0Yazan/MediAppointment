<?php

use Illuminate\Support\Str;
use Laravel\Jetstream\Features;
use Laravel\Jetstream\Http\Livewire\ApiTokenManager;
use Livewire\Livewire;
use Modules\Auth\app\Models\Doctor;

test('api token permissions can be updated', function () {
    if (Features::hasTeamFeatures()) {
        $this->actingAs($user = Doctor::factory()->withPersonalTeam()->create());
    } else {
        $this->actingAs($user = Doctor::factory()->create());
    }

    $token = $user->tokens()->create([
        'name' => 'Test Token',
        'token' => Str::random(40),
        'abilities' => ['create', 'read'],
    ]);

    Livewire::test(ApiTokenManager::class)
        ->set(['managingPermissionsFor' => $token])
        ->set(['updateApiTokenForm' => [
            'permissions' => [
                'delete',
                'missing-permission',
            ],
        ]])
        ->call('updateApiToken');

    expect($user->fresh()->tokens->first())
        ->can('delete')->toBeTrue()
        ->can('read')->toBeFalse()
        ->can('missing-permission')->toBeFalse();
})->skip(function () {
    return ! Features::hasApiFeatures();
}, 'API support is not enabled.');
