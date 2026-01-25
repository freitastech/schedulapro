<?php

namespace App\Http\Requests;

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
}
