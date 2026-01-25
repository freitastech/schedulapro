<?php

namespace Database\Factories;

use App\Models\Appointment;
use App\Models\Business;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AppointmentFactory extends Factory
{
    protected $model = Appointment::class;

    public function definition(): array
    {
        $startAt = $this->faker->dateTimeBetween('+1 day', '+10 days');
        $endAt = (clone $startAt);
        $endAt->modify('+1 hour');

        return [
            'business_id' => Business::factory(),
            'service_id' => Service::factory(),
            'client_id' => User::factory(),
            'staff_id' => $this->faker->boolean(80) ? User::factory() : null,
            'start_at' => $startAt,
            'end_at' => $endAt,
            'status' => 'scheduled',
        ];
    }

    public function forBusiness(int $businessId): static
    {
        return $this->state(function () use ($businessId) {
            $client = User::factory()->create(['business_id' => $businessId]);
            $staff = User::factory()->create(['business_id' => $businessId]);
            $service = Service::factory()->create(['business_id' => $businessId]);

            return [
                'business_id' => $businessId,
                'client_id' => $client->id,
                'staff_id' => $staff->id,
                'service_id' => $service->id,
            ];
        });
    }

    public function withoutStaff(): static
    {
        return $this->state(fn () => ['staff_id' => null]);
    }
}
