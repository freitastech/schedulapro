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
        $business = Business::factory()->create();

        $client = User::factory()->create([
            'business_id' => $business->id,
        ]);

        $staff = User::factory()->create([
            'business_id' => $business->id,
        ]);

        $service = Service::factory()->create([
            'business_id' => $business->id,
        ]);

        $startAt = $this->faker->dateTimeBetween('+1 day', '+10 days');
        $endAt = (clone $startAt);
        $endAt->modify('+1 hour');

        return [
            'business_id' => $business->id,
            'service_id' => $service->id,
            'client_id' => $client->id,
            'staff_id' => $this->faker->boolean(80) ? $staff->id : null,
            'start_at' => $startAt,
            'end_at' => $endAt,
            'status' => 'scheduled',
        ];
    }
}
