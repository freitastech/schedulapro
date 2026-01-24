<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Services
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

                <form method="POST" action="{{ route('services.store') }}" class="space-y-3">
                    @csrf

                    <div>
                        <input name="name" placeholder="Name" value="{{ old('name') }}" class="border rounded w-full p-2">
                    </div>

                    <div>
                        <input name="duration_minutes" type="number" placeholder="Duration (min)" value="{{ old('duration_minutes') }}" class="border rounded w-full p-2">
                    </div>

                    <div>
                        <input name="price_cents" type="number" placeholder="Price (cents)" value="{{ old('price_cents') }}" class="border rounded w-full p-2">
                    </div>

                    <div>
                        <label class="inline-flex items-center gap-2">
                            <input name="is_active" type="checkbox" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                            <span>Active</span>
                        </label>
                    </div>

                    <button type="submit" class="px-4 py-2 bg-black text-white rounded">
                        Create
                    </button>
                </form>

                <hr class="my-6">

                <ul class="space-y-2">
                    @foreach ($services as $service)
                        <li class="flex items-center justify-between border rounded p-3">
                            <span>{{ $service->name }}</span>

                            <form method="POST" action="{{ route('services.destroy', $service) }}">
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
                    {{ $services->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
