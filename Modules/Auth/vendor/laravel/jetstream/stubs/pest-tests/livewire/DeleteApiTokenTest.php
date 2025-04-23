<?php

use Illuminate\Support\Str;
use Laravel\Jetstream\Features;
use Laravel\Jetstream\Http\Livewire\ApiTokenManager;
use Livewire\Livewire;
use Modules\Auth\app\Models\Doctor;

test('api tokens can be deleted', function () {
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
        ->set(['apiTokenIdBeingDeleted' => $token->id])
        ->call('deleteApiToken');

    expect($user->fresh()->tokens)->toHaveCount(0);
})->skip(function () {
    return ! Features::hasApiFeatures();
}, 'API support is not enabled.');
