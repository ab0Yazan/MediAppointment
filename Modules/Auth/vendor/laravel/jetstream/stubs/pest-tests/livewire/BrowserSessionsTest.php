<?php

use Laravel\Jetstream\Http\Livewire\LogoutOtherBrowserSessionsForm;
use Livewire\Livewire;
use Modules\Auth\app\Models\Doctor;

test('other browser sessions can be logged out', function () {
    $this->actingAs(Doctor::factory()->create());

    Livewire::test(LogoutOtherBrowserSessionsForm::class)
        ->set('password', 'password')
        ->call('logoutOtherBrowserSessions')
        ->assertSuccessful();
});
