<?php

namespace App\Http\Requests;

use App\Models\Appointment;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAppointmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $businessId = $this->user()->business_id;

        return [
            'service_id' => [
                'required',
                Rule::exists('services', 'id')->where('business_id', $businessId),
            ],
            'client_id' => [
                'required',
                Rule::exists('users', 'id')->where('business_id', $businessId),
            ],
            'staff_id' => [
                'nullable',
                Rule::exists('users', 'id')->where('business_id', $businessId),
            ],
            'start_at' => ['required', 'date'],
            'end_at' => ['required', 'date', 'after:start_at'],
            'status' => ['nullable', 'string', Rule::in(['scheduled', 'cancelled', 'completed'])],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $businessId = $this->user()->business_id;
            $staffId = $this->input('staff_id');

            if (empty($staffId)) {
                return;
            }

            $startAt = $this->input('start_at');
            $endAt = $this->input('end_at');

            if (empty($startAt) || empty($endAt)) {
                return;
            }

            $appointmentId = $this->route('appointment')?->id;

            if (Appointment::hasStaffConflict($businessId, (int) $staffId, $startAt, $endAt, $appointmentId)) {
                $validator->errors()->add('start_at', 'Conflito de horário: já existe um agendamento para este profissional nesse intervalo.');
            }
        });
    }
}
