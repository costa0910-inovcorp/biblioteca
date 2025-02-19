<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
        <div class="flex justify-between gap-4 flex-wrap bg-white dark:bg-gray-800 shadow-xl sm:rounded-lg p-4">
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
                    <select class="select select-bordered join-item max-sm:hidden" wire:model="pageSize">
                        <option disabled selected>Page size</option>
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="30">30</option>
                        <option value="40">40</option>
                    </select>
                    <div class="indicator">
{{--                        <span class="indicator-item badge badge-secondary">new</span>--}}
                        <button class="btn join-item" wire:click="searchBooks">Search</button>
                    </div>
                </div>
                <div class="flex gap-4">
                    <livewire:saving-books-status />
                    @if(!empty($books) && empty($errorMessage))
                        <div>
                            <button class="btn btn-primary" wire:click="saveBooks">Save books</button>
                        </div>
                    @endif
                </div>
        </div>

{{--        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-4">--}}
            @if( empty($books) && empty($errorMessage))
                <p class="text-center p-4">Search books for result to appear here</p>
            @elseif(!empty($errorMessage))
                <div class="flex items-center flex-col">
                    <p class="text-red-500">{{ $errorMessage }}</p>
                    <button class="btn btn-outline" wire:click="tryAgain">Try again</button>
                </div>
            @else
            <div class="grid md:grid-cols-2 gap-4">
                @foreach($books as $book)
                    <div class="card lg:card-side bg-base-100 shadow-xl">
                       @if($book['cover_image'])
                            <figure class="lg:w-1/4">
                                <img
                                    class="image-full"
                                    src="{{ $book['cover_image'] }}"
                                    {{--                                src="https://img.daisyui.com/images/stock/photo-1635805737707-575885ab0820.webp"--}}
                                    alt="{{ $book['name'] }}" />
                            </figure>
                       @endif
                        <div class="card-body lg:w-3/4">
                            <h2 class="card-title">{{ \Illuminate\Support\Str::words($book['name'], 5) }}</h2>
                            <p>
                                <strong>Description: </strong>
                                @if($book['bibliography'])
                                    {{ \Illuminate\Support\Str::words($book['bibliography'], 15) }}
                                @else
                                    No description
                                @endif
                            </p>
                            <p>
                                <strong>Publisher: </strong>
                                @if($book['publisher'])
                                    {{ $book['publisher'] }}
                                @else
                                    Unknown
                                @endif
                            </p>
                            <p>
                                <strong>Author(s): </strong>
                                @if($book['authors'])
                                    {{ join(', ',  $book['authors'])}}
                                @else
                                    Unknown
                                @endif

                            </p>
                            <p>
                                <strong>Price: </strong>
                                @if ($book['price']))
                                    €{{ $book['price'] }}
                                @elseif($book['price'] == 0)
                                    FREE
                                @else
                                    Unknown
                                @endif
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
           @endif

            @if(!empty($pages) && empty($errorMessage))
                <div class="pt-4">
                    <div class="join flex justify-center gap-2 flex-wrap md:hidden">
                        <button class="join-item btn btn-outline" wire:click="previousPage">Previous page</button>
                        <button class="join-item btn btn-outline" wire:click="nextPage">Next</button>
                    </div>
                    <div class="join hidden md:flex justify-center gap-2 flex-wrap">
                        <button class="join-item btn btn-outline {{ $pages['prevPage'] ? '' : 'btn-disabled' }}" wire:click="previousPage">Previous page</button>
                        @isset($pages['prevPage'])
                            <button class="join-item btn" wire:click="getPage({{ $pages['prevPage'] }})">{{ $pages['prevPage'] }}</button>
                        @endisset
                        <button class="join-item btn btn-disabled">{{ $pages['currentPage'] }}</button>

                        @isset($pages['nextPage'])
                            <button class="join-item btn"  wire:click="getPage({{ $pages['nextPage'] }})">{{ $pages['nextPage'] }}</button>
                        @endisset

                        <button class="join-item btn btn-outline {{ $pages['nextPage'] ? '' : 'btn-disabled' }}" wire:click="nextPage">Next</button>
                    </div>
                </div>
            @endif
{{--        </div>--}}
    </div>
</div>
