<x-app-layout>
    <x-slot name="header">
    <h1>Dashboard for {{ $role }} - Branch: {{ $branch->nama_cabang }}</h1>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-2xl font-semibold">
                        {{ __("You're logged in as a " . ucfirst($role)) }}
                    </h3>
                    <p class="mt-4">
                        Anda sedang melihat informasi untuk cabang <strong>{{ $branch->alias }}</strong>.
                    </p>
                    <div class="mt-6">
                        <p><strong>Peran:</strong> {{ ucfirst($role) }}</p>
                        <p><strong>Cabang:</strong> {{ $branch->alias }} (ID: {{ $branch->id_cabang }})</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
