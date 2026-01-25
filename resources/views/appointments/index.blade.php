<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Appointments
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                @if (session('success'))
                <div class="mb-4 text-green-600">
                    {{ session('success') }}
                </div>
                @endif

                @if ($errors->any())
                <div class="mb-4 text-red-600">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form method="POST" action="{{ route('appointments.store') }}" class="space-y-3">
                    @csrf

                    <div>
                        <select name="service_id" class="border rounded w-full p-2">
                            <option value="">Select service</option>
                            @foreach ($services as $service)
                            <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>
                                {{ $service->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <select name="client_id" class="border rounded w-full p-2">
                            <option value="">Select client</option>
                            @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ old('client_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <select name="staff_id" class="border rounded w-full p-2">
                            <option value="">Select staff (optional)</option>
                            @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ old('staff_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <input name="start_at" type="datetime-local" value="{{ old('start_at') }}" class="border rounded w-full p-2">
                    </div>

                    <div>
                        <input name="end_at" type="datetime-local" value="{{ old('end_at') }}" class="border rounded w-full p-2">
                    </div>

                    <div>
                        <select name="status" class="border rounded w-full p-2">
                            <option value="scheduled" {{ old('status', 'scheduled') === 'scheduled' ? 'selected' : '' }}>scheduled</option>
                            <option value="cancelled" {{ old('status') === 'cancelled' ? 'selected' : '' }}>cancelled</option>
                            <option value="completed" {{ old('status') === 'completed' ? 'selected' : '' }}>completed</option>
                        </select>
                    </div>

                    <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded">
                        Create
                    </button>

                </form>

                <hr class="my-6">

                <ul class="space-y-2">
                    @foreach ($appointments as $appointment)
                    <li class="flex items-center justify-between border rounded p-3">
                        <div class="space-y-1">
                            <div class="font-semibold">
                                {{ $appointment->service?->name ?? '—' }}
                            </div>
                            <div class="text-sm text-gray-700">
                                Client: {{ $appointment->client?->name ?? '—' }}
                                @if ($appointment->staff)
                                | Staff: {{ $appointment->staff->name }}
                                @endif
                            </div>
                            <div class="text-sm text-gray-600">
                                {{ $appointment->start_at }} → {{ $appointment->end_at }} | {{ $appointment->status }}
                            </div>
                        </div>

                        <form method="POST" action="{{ route('appointments.destroy', $appointment) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded">
                                Delete
                            </button>
                        </form>
                    </li>
                    @endforeach
                </ul>

                <div class="mt-6">
                    {{ $appointments->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>