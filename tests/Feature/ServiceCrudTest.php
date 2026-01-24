<?php

namespace Tests\Feature;

use App\Models\Business;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServiceCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_services_index(): void
    {
        $response = $this->get('/services');

        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_create_a_service(): void
    {
        $user = User::factory()->create();

        $payload = [
            'name' => 'Corte de Cabelo',
            'duration_minutes' => 30,
            'price_cents' => 2500,
            'is_active' => true,
        ];

        $response = $this->actingAs($user)->post('/services', $payload);

        $response->assertRedirect('/services');

        $this->assertDatabaseHas('services', [
            'name' => 'Corte de Cabelo',
            'business_id' => $user->business_id,
            'duration_minutes' => 30,
            'price_cents' => 2500,
        ]);
    }

    public function test_validation_fails_when_required_fields_are_missing(): void
    {
        $user = User::factory()->create();

        $payload = [
            'name' => '',
            'duration_minutes' => null,
            'price_cents' => null,
        ];

        $response = $this->actingAs($user)->post('/services', $payload);

        $response->assertSessionHasErrors(['name', 'duration_minutes', 'price_cents']);
    }

    public function test_user_cannot_delete_service_from_another_business(): void
    {
        $businessA = Business::factory()->create();
        $businessB = Business::factory()->create();

        $userA = User::factory()->create(['business_id' => $businessA->id]);
        $userB = User::factory()->create(['business_id' => $businessB->id]);

        $serviceFromA = Service::factory()->create([
            'business_id' => $businessA->id,
        ]);

        $response = $this->actingAs($userB)->delete("/services/{$serviceFromA->id}");

        $response->assertForbidden();

        $this->assertDatabaseHas('services', [
            'id' => $serviceFromA->id,
        ]);
    }
}
