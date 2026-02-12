<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class PolicyAuthTest extends TestCase
{
    use RefreshDatabase;

    // verifica che senza token si riceva 401
    public function test_policies_index_requires_authentication(): void
    {
        $response = $this->getJson('/api/policies');

        $response->assertStatus(401);
    }

    // verifica che con un utente autenticato via Sanctum l’endpoint risponda 200
    public function test_policies_index_works_with_authenticated_user(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'sanctum')
            ->getJson('/api/policies');

        $response->assertStatus(200);
    }
}
