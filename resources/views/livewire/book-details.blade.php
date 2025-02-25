<div>
    <x-guest-navigation-menu />
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 my-8 max-sm:space-y-8">
{{--        <a class="btn btn-sm mt-2 mb-4 mx-2 sm:mx-0" href="/">Back</a>--}}
        <div class="md:grid md:grid-cols-2 md:gap-6">
            <div class="md:col-span-1">
                <div class="px-4 sm:px-0 w-full">
                    <div class="flex justify-center">
                        <img src="{{ asset($book->cover_image) }}" alt="{{ $book->name }}" class="image-full">

                    </div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ $book->name }}</h3>

                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        <strong>ISBN:</strong> {{ $book->isbn }}
                    </p>
                    {{--                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">--}}
                    {{--                        <strong>Price:</strong> {{ $book->price }}--}}
                    {{--                    </p>--}}
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        <strong>Is available:</strong> {{ $book->is_available ? 'Yes' : 'No' }}
                    </p>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        {{ $book->bibliography }}
                    </p>
                </div>
            </div>
            <div class="mt-5 md:mt-0 px-4 sm:px-0 md:flex md:justify-end md:items-start">
                <div class="card bg-base-100 lg:w-10/12 shadow-xl">
                    <div class="card-body">
                        <h2 class="card-title text-primary">€{{ $book->price }}</h2>
                        @if($book->is_available)
                            <p>Book it's available, add to cart or borrow now</p>
                            <div class="card-actions">
                                @role('citizen')
                                    <button class="btn btn-primary w-full rounded-full" wire:click="addToCart">ADD TO CART</button>
                                @endrole
                                <a class="btn btn-ghost btn-outline w-full rounded-full" href="{{ route('public.books.request', ['book' => $book->id]) }}">Borrow Now</a>
                            </div>
                        @else
                            <p>Books it's not available now, add it to waitlist so we can email you when it's available</p>
                            <div class="card-actions">
                                <a class="btn btn-warning rounded-full w-full" href="{{ route('public.add-to-wait-list', ['book'=> $book->id]) }}">Add to waitlist</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <x-section-border />
           @if(!empty($relevantBooks))
                <x-relevant-books :books="$relevantBooks"/>
                <x-section-border />
           @endif
            @if(count($bookRequests) != 0)
                <div class="flex flex-col space-y-4 px-4 sm:px-0 mb-4">
                    <p>Request made to this book</p>
                    <div class="flex gap-4 flex-auto">
                        @foreach($bookRequests as $request)
                            <x-request-book-card :requestBook="$request" :showUser="true" class="max-sm:flex-auto" />
                        @endforeach
                    </div>
                </div>
                <x-section-border />
            @endif
            <div class="px-4 sm:px-0 mb-4">
                <livewire:show-user-reviews bookId="{{ $book->id }}"/>
            </div>
    </div>
    <x-toast />
</div>
