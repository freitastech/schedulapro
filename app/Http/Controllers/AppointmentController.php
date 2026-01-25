<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Models\Appointment;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Appointment::class, 'appointment');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $businessId = $request->user()->business_id;

        $appointments = Appointment::query()
            ->where('business_id', $businessId)
            ->with(['service', 'client', 'staff'])
            ->orderBy('start_at')
            ->paginate(10);

        $services = Service::query()
            ->where('business_id', $businessId)
            ->orderBy('name')
            ->get(['id', 'name']);

        $users = User::query()
            ->where('business_id', $businessId)
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('appointments.index', compact('appointments', 'services', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAppointmentRequest $request)
    {
        Appointment::create([
            'business_id' => $request->user()->business_id,
            'service_id' => $request->service_id,
            'client_id' => $request->client_id,
            'staff_id' => $request->staff_id,
            'start_at' => $request->start_at,
            'end_at' => $request->end_at,
            'status' => $request->status ?? 'scheduled',
        ]);

        return redirect()
            ->route('appointments.index')
            ->with('success', 'Agendamento criado com sucesso.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAppointmentRequest $request, Appointment $appointment)
    {
        $data = $request->validated();

        $appointment->update($data);

        return redirect()
            ->route('appointments.index')
            ->with('success', 'Agendamento atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return redirect()
            ->route('appointments.index')
            ->with('success', 'Agendamento removido com sucesso.');
    }
}
