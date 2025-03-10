@php
    if ($maxToBorrow == 0) {
        $valueText = 'Return some books to borrow again';
    } else {
        $valueText = "Books to Borrow (max $maxToBorrow)";
    }
@endphp

<form wire:submit.prevent="borrow" class="space-y-4 min-h-full md:flex">
    <div class="w-full">
        <div class="dropdown dropdown-bottom w-72">
            {{--        <div tabindex="0" role="button" class="btn m-1">Click</div>--}}
            <div class="space-y-1">
                <x-label for="book-to-borrow" :value="$valueText" />
                <input tabindex="0" type="text"
                       id="book-to-borrow"
                       wire:model.live.debounce.300ms="searchBookByName"
                       class="input input-bordered  w-72"
                       placeholder="Search book by name..."
                       autocomplete="off"
                />
                <ul tabindex="0" class="dropdown-content menu bg-base-100 rounded-box z-[9999] w-72 p-2 shadow overflow-auto">
                    @foreach( $availableToBorrow as $book)
                        <li wire:click="add('{{ $book['id'] }}')">
                            <button type="button">
                                {{ \Illuminate\Support\Str::words($book['name'], 5) }}
                                @if(!$book['is_available'])
                                    <span class="bg-warning rounded flex justify-center items-center p-1">Waitlist</span>
                                @endif
                            </button>
                        </li>
                    @endforeach
                    @if( count($availableToBorrow) == 0)
                               <span class="text-center">No book found.</span>
                     @endif
                </ul>
            </div>
        </div>
        <div class="flex w-62 min-w-36 flex-wrap gap-2 mt-2">
            @foreach($booksToBorrow as $selectBook)
                <div role="button" wire:click="remove('{{ $selectBook['id'] }}')"  class="badge badge-primary flex p-2 h-fit">
                    {{ \Illuminate\Support\Str::words($selectBook['name'], 5) }}
                    @if(!$selectBook['is_available'])
                        <span class="badge badge-warning flex items-center justify-center h-fit">
                            Waitlist
                        </span>
                    @endif
                </div>
            @endforeach
        </div>
        <x-input-error for="booksToBorrow" />
    </div>
    <button type="submit" class="btn btn-primary ">Borrow</button>
</form>
