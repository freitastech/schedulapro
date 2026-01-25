<?php

namespace Tests\Feature;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AppointmentConflictsTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_blocks_overlapping_appointments_for_same_staff(): void
    {
        $user = User::factory()->create();

        $appointment = Appointment::factory()
            ->forBusiness($user->business_id)
            ->create(['client_id' => $user->id]);

        $staff = User::factory()->create([
            'business_id' => $user->business_id,
        ]);

        $appointment->update([
            'staff_id' => $staff->id,
        ]);

        $payload = [
            'service_id' => $appointment->service_id,
            'client_id' => $user->id,
            'staff_id' => $staff->id,
            'start_at' => $appointment->start_at->copy()->addMinutes(15)->format('Y-m-d\TH:i'),
            'end_at' => $appointment->end_at->copy()->addMinutes(15)->format('Y-m-d\TH:i'),
            'status' => 'scheduled',
        ];

        $this->actingAs($user)
            ->post(route('appointments.store'), $payload)
            ->assertSessionHasErrors(['start_at']);

        $this->assertDatabaseCount('appointments', 1);
    }

    public function test_it_allows_non_overlapping_appointments_for_same_staff(): void
    {
        $user = User::factory()->create();

        $appointment = Appointment::factory()
            ->forBusiness($user->business_id)
            ->create(['client_id' => $user->id]);

        $staff = User::factory()->create([
            'business_id' => $user->business_id,
        ]);

        $appointment->update([
            'staff_id' => $staff->id,
        ]);

        $payload = [
            'service_id' => $appointment->service_id,
            'client_id' => $user->id,
            'staff_id' => $staff->id,
            'start_at' => $appointment->end_at->copy()->addMinutes(30)->format('Y-m-d\TH:i'),
            'end_at' => $appointment->end_at->copy()->addMinutes(90)->format('Y-m-d\TH:i'),
            'status' => 'scheduled',
        ];

        $this->actingAs($user)
            ->post(route('appointments.store'), $payload)
            ->assertRedirect(route('appointments.index'));

        $this->assertDatabaseCount('appointments', 2);
    }
}
