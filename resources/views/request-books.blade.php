<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 min-h-full space-y-4">
            @can('manage books')
                <livewire:request-book-stats />
            @endcan
            <div class="grid gap-4 md:grid-cols-2 items-start">
                <div class="bg-white dark:bg-gray-800  sm:rounded-lg col p-4">
                    <livewire:request-book />
                </div>
                <div class="bg-white dark:bg-gray-800 sm:rounded-lg col p-4">
                    <livewire:user-tabs />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
