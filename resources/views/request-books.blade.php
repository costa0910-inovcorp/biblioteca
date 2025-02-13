<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 min-h-full space-y-4">
            <livewire:request-book-stats />
            <div class="grid gap-4 md:grid-cols-2 items-start">
                <div class="bg-white dark:bg-gray-800 shadow-xl sm:rounded-lg col p-4">
                    <livewire:request-book />
                </div>
                <div class="bg-white dark:bg-gray-800 shadow-xl sm:rounded-lg col p-4">
                    <livewire:user-requests />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
