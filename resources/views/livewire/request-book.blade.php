<form wire:submit.prevent="borrow" class="space-y-4 min-h-full md:flex gap-4">
    <div class="w-full">
        <div class="dropdown dropdown-bottom w-64 min-w-28">
            {{--        <div tabindex="0" role="button" class="btn m-1">Click</div>--}}
            <div class="space-y-1">
                <x-label for="book-to-borrow" value="Books to Borrow (max 3)" />
                <input tabindex="0" type="text"
                       id="book-to-borrow"
                       wire:model.live.debounce.300ms="searchBookByName"
                       class="input input-bordered  w-64 min-w-28"
                       placeholder="Search book by name..."
                       autocomplete="off"
                />
                <ul tabindex="0" class="dropdown-content menu bg-base-100 rounded-box z-[9999] w-64 p-2 shadow overflow-auto">
                    @foreach( $availableToBorrow as $book)
                        <li wire:click="add('{{ $book['id'] }}')"><button type="button">{{ $book['name'] }}</button></li>
                    @endforeach
                    @if( count($availableToBorrow) == 0)
                               <span class="text-center">No book found.</span>
                     @endif
                </ul>
            </div>
        </div>
        <div class="flex w-62 min-w-36 flex-wrap gap-2 mt-2">
            @foreach($booksToBorrow as $selectBook)
                <button wire:click="remove('{{ $selectBook['id'] }}')" type="button" class="btn">
                    {{ $selectBook['name'] }}
                    <div class="badge flex items-center justify-center">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="4"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                </button>
{{--                <div class="flex gap-0 items-center">--}}
{{--                    <span class="badge">{{ $selectBook['book']->name }}</span>--}}
{{--                    <button type="button"  class="btn btn-xs btn-circle">--}}
{{--                        <svg--}}
{{--                            xmlns="http://www.w3.org/2000/svg"--}}
{{--                            class="h-2 w-2"--}}
{{--                            fill="none"--}}
{{--                            viewBox="0 0 24 24"--}}
{{--                            stroke="currentColor">--}}
{{--                            <path--}}
{{--                                stroke-linecap="round"--}}
{{--                                stroke-linejoin="round"--}}
{{--                                stroke-width="2"--}}
{{--                                d="M6 18L18 6M6 6l12 12" />--}}
{{--                        </svg>--}}
{{--                    </button>--}}
{{--                </div>--}}
            @endforeach
        </div>
        <x-input-error for="booksToBorrow" />
    </div>
{{--    <div class="space-y-1">--}}
{{--        <x-label for="book-to-borrow" value="Book to Borrow" />--}}
{{--        <x-select id="book-to-borrow" :options="$availableToBorrow" model="bookToBorrow" :multiple="false" default="Witch book do you want to borrow?"/>--}}
{{--        <x-input-error for="bookToBorrow"/>--}}
{{--    </div>--}}
    <button type="submit" class="btn btn-active btn-primary w-62 ">Borrow</button>
</form>
