<x-app-layout>
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 min-h-full space-y-4">
            <div class="sm:rounded-lg col flex justify-center">
{{--                <p>Stats here, only admins gonna see this!</p>--}}
                <div class="stats shadow">
                    <div class="stat place-items-center">
                        <div class="stat-title">Downloads</div>
                        <div class="stat-value">31K</div>
                        <div class="stat-desc">From January 1st to February 1st</div>
                    </div>

                    <div class="stat place-items-center">
                        <div class="stat-title">Users</div>
                        <div class="stat-value text-primary">4,200</div>
                        <div class="stat-desc text-primary">↗︎ 40 (2%)</div>
                    </div>

                    <div class="stat place-items-center">
                        <div class="stat-title">New Registers</div>
                        <div class="stat-value">1,200</div>
                        <div class="stat-desc">↘︎ 90 (14%)</div>
                    </div>
                </div>
            </div>
            <div class="grid gap-4 md:grid-cols-2 items-start">
                <div class="bg-white dark:bg-gray-800 shadow-xl sm:rounded-lg col p-4">
                    <livewire:request-book />
                </div>
                <div class="bg-white dark:bg-gray-800 shadow-xl sm:rounded-lg col p-4">
                    <livewire:user-requests />
                </div>
            </div>
        </div>
{{--        class="p-4 md:w-1/2 space-y-4 mx-auto min-h-full"--}}
    </div>
</x-app-layout>
