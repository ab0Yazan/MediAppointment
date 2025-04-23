<?php

use Modules\Auth\app\Models\Doctor;

test('other browser sessions can be logged out', function () {
    $this->actingAs(Doctor::factory()->create());

    $response = $this->delete('/user/other-browser-sessions', [
        'password' => 'password',
    ]);

    $response->assertSessionHasNoErrors();
});
