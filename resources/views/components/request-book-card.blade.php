@props(['requestBook', 'showUser' => false])

@php
    use Carbon\Carbon;
@endphp

<div class="card card-side bg-base-100 shadow-xl card-compact card-bordered">
    @if(!$showUser)
        <figure>
            <div class="avatar">
                <div class="w-24 rounded">
                    <img src="{{ asset($requestBook->book?->cover_image) }}" alt="{{ $requestBook->book?->name ?? 'No book' }}"/>
                </div>
            </div>
        </figure>
    @endif
    <div class="card-body">
        <div class="max-sm:flex-col card-title">
            @if($showUser)
                <h2>{{ $requestBook->user_name  }}</h2>
                <span class="text-sm">{{ $requestBook->user_email }}</span>
            @else
                <h2>{{ \Illuminate\Support\Str::words($requestBook->book?->name, 7)?? 'no book' }}</h2>
            @endif
        </div>
        <p class="max-sm:flex max-sm:flex-col max-sm:items-center">
            <span><strong>Borrow on:</strong> {{ $requestBook->created_at }}</span>
            <span class="block"><strong>Predicted return date:</strong> {{ $requestBook->predicted_return_date }}</span>
        </p>
        <div class="card-actions justify-end">
            @if($requestBook->return_date)
                <div class="badge flex-wrap h-fit">
                    Confirmed on {{ $requestBook->return_date }},
                    <strong class="ml-2">
                        @if (Carbon::parse($requestBook->return_date)->equalTo(Carbon::parse($requestBook->predicted_return_date)))
                            on time!
                        @elseif (Carbon::parse($requestBook->return_date)->lessThan(Carbon::parse($requestBook->predicted_return_date)))
                            early by {{ Carbon::parse($requestBook->predicted_return_date)->diffInDays($requestBook->return_date, true) }} day(s).
                        @else
                            late by {{ Carbon::parse($requestBook->return_date)->diffInDays($requestBook->predicted_return_date, true) }} day(s).
                        @endif
                    </strong>
                </div>
                @can('review books')
                    @if(!$requestBook->is_reviewed && $requestBook->user_id == auth()->id())
                        <button onclick="book_review_{{ $requestBook->id }}.showModal()" class="btn btn-xs btn-primary">Review</button>
                        <dialog id="book_review_{{ $requestBook->id }}" class="modal"  wire:ignore.self>
                            <div class="modal-box">
                                <h3 class="text-lg font-bold">What was your experience with this book?</h3>
                                <div class="mt-2">
                                    <input type="range" min="1" max="5" wire:model="rating" class="range" step="0.5" />
                                    <div class="flex w-full justify-between px-2 text-xs">
                                        <span>1</span>
                                        <span>2</span>
                                        <span>3</span>
                                        <span>4</span>
                                        <span>5</span>
                                    </div>
                                    <x-input-error for="rating" class="mt-1" />
                                </div>
                                <div class="mt-4">
                                    <textarea class="textarea textarea-bordered w-full" wire:model="comment" placeholder="Your experience"></textarea>
                                    <x-input-error for="comment" class="mt-1" />
                                </div>
                                <div class="modal-action space-x-4">
                                    <form method="dialog">
                                        <!-- if there is a button in form, it will close the modal -->
                                        <button class="btn">Close</button>
                                    </form>
                                    <button type="button" class="btn btn-primary" wire:click="reviewBook({{ $requestBook->id }})">Submit review</button>
                                </div>
                            </div>
                        </dialog>
                    @endif
                @endcan
            @else
                <div class="badge badge-warning">No confirmation yet</div>
                @can('manage books')
                    <button onclick="confirm_return_date_{{ $requestBook->id }}.showModal()" class="btn btn-xs btn-primary">Confirm reception</button>
                    <dialog id="confirm_return_date_{{ $requestBook->id }}" class="modal"  wire:ignore.self>
                        <div class="modal-box">
                            <h3 class="text-lg font-bold">Witch date the book was returned?</h3>
                            <div class="mt-2">
                                <input type="date" wire:model="returnDate" class="input input-bordered w-full" />
                                <x-input-error for="returnDate" class="mt-2" />
                            </div>
                            <div class="modal-action space-x-4">
                                <form method="dialog">
                                    <!-- if there is a button in form, it will close the modal -->
                                    <button class="btn">Close</button>
                                </form>
                                <button type="button" class="btn btn-primary" wire:click="confirmReturnDate({{ $requestBook->id }})">Confirm return date</button>
                            </div>
                        </div>
                    </dialog>
                @endcan
            @endif
        </div>
    </div>
</div>
