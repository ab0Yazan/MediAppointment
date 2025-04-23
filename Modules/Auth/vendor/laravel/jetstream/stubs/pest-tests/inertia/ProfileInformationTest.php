<?php

use Modules\Auth\app\Models\Doctor;

test('profile information can be updated', function () {
    $this->actingAs($user = Doctor::factory()->create());

    $this->put('/user/profile-information', [
        'name' => 'Test Name',
        'email' => 'test@example.com',
    ]);

    expect($user->fresh())
        ->name->toEqual('Test Name')
        ->email->toEqual('test@example.com');
});
