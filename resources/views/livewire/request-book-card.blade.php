@props(['requestBook'])

@php
    use Carbon\Carbon;
@endphp

<div class="card card-side bg-base-100 shadow-xl card-compact card-bordered">
    <figure>
        <div class="avatar">
            <div class="w-24 rounded">
                <img src="{{ $requestBook->book?->cover_image }}" alt="{{ $requestBook->book?->name ?? 'No book' }}"/>
            </div>
        </div>
    </figure>
    <div class="card-body">
        <h2 class="card-title">{{ $requestBook->book?->name?? 'no book' }}</h2>
        <p>
            <span><strong>Borrow on:</strong> {{ $requestBook->created_at }}</span>
            <span class="block"><strong>Predicted return date:</strong> {{ $requestBook->predicted_return_date }}</span>
        </p>
        <div class="card-actions justify-end">
            @if($requestBook->return_date)
                <div class="badge flex-wrap">
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
                                <button type="button" class="btn btn-primary" wire:click="confirmReturnDate">Confirm return date</button>
                            </div>
                        </div>
                    </dialog>
                @endcan
            @endif
        </div>
    </div>
</div>


<script>
    Livewire.on('dateUpdated', (newDate) => {
        // Close the modal
        alert(newDate);
        document.querySelector('.modal').style.display = 'none';

        // Update the displayed return date
        // Optionally, you can also do this dynamically if needed
        document.querySelector('.return-date').innerText = newDate;
    });
</script>
