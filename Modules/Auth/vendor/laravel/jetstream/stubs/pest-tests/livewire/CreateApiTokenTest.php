<?php

use Laravel\Jetstream\Features;
use Laravel\Jetstream\Http\Livewire\ApiTokenManager;
use Livewire\Livewire;
use Modules\Auth\app\Models\Doctor;

test('api tokens can be created', function () {
    if (Features::hasTeamFeatures()) {
        $this->actingAs($user = Doctor::factory()->withPersonalTeam()->create());
    } else {
        $this->actingAs($user = Doctor::factory()->create());
    }

    Livewire::test(ApiTokenManager::class)
        ->set(['createApiTokenForm' => [
            'name' => 'Test Token',
            'permissions' => [
                'read',
                'update',
            ],
        ]])
        ->call('createApiToken');

    expect($user->fresh()->tokens)->toHaveCount(1);
    expect($user->fresh()->tokens->first())
        ->name->toEqual('Test Token')
        ->can('read')->toBeTrue()
        ->can('delete')->toBeFalse();
})->skip(function () {
    return ! Features::hasApiFeatures();
}, 'API support is not enabled.');
