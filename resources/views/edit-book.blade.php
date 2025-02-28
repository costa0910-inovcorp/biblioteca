<x-app-layout>
{{--    <x-slot name="header">--}}
{{--        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">--}}
{{--            {{ __('Edit') }}--}}
{{--        </h2>--}}
{{--        <input type="text" placeholder="search a book" />--}}
{{--    </x-slot>--}}

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
{{--               <div class="p-4">--}}
{{--                   <x-btn-link href="{{route('books.create')}}">--}}
{{--                       Create book--}}
{{--                   </x-btn-link>--}}
{{--                   <x-btn-link href="{{route('books.export')}}">--}}
{{--                       export books--}}
{{--                   </x-btn-link>--}}
{{--               </div>--}}
                <livewire:edit-book />
            </div>
        </div>
    </div>
</x-app-layout>
