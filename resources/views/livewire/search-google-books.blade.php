
{{--<x-app-layout>--}}
{{--    <hi>Hello</hi>--}}
{{--</x-app-layout>--}}
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
{{--        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">--}}
                <div class="join">
                    <div>
                        <div>
                            <input
                                wire:model="search"
                                class="input input-bordered join-item"
                                   placeholder="Search" />
                        </div>
                        <x-input-error for="search"/>
                    </div>
                    <div class="indicator">
{{--                        <span class="indicator-item badge badge-secondary">new</span>--}}
                        <button class="btn join-item" wire:click="searchBooks">Search</button>
                    </div>
                </div>
{{--        </div>--}}
    </div>
</div>
