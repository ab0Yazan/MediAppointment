<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;
use Modules\Auth\app\Models\Doctor;
use Tests\TestCase;

class DeleteApiTokenTest extends TestCase
{
    use RefreshDatabase;

    public function test_api_tokens_can_be_deleted(): void
    {
        if (! Features::hasApiFeatures()) {
            $this->markTestSkipped('API support is not enabled.');
        }

        $this->actingAs($user = Doctor::factory()->withPersonalTeam()->create());

        $token = $user->tokens()->create([
            'name' => 'Test Token',
            'token' => Str::random(40),
            'abilities' => ['create', 'read'],
        ]);

        $this->delete('/user/api-tokens/'.$token->id);

        $this->assertCount(0, $user->fresh()->tokens);
    }
}
