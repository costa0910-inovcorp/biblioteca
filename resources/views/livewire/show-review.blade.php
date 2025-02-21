<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">
        <div class="flex justify-between gap-4 flex-wrap bg-white dark:bg-gray-800 shadow-xl sm:rounded-lg p-4">
            <div class="sm:px-0">
                <img src="{{ asset($review->book->cover_image) }}" alt="{{ $review->book->name }}" class="size-40 object-cover">
                <p class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    <strong>Book name:</strong> {{ $review->book->name }}</p>
                <p class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    <strong>Reviewed by:</strong> {{ $review->user->name }}</p>

                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    <strong>Status:</strong> <span class="badge badge-primary">{{ $review->status }}</span>
                </p>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    <strong>Rating:</strong> <span class="badge badge-warning">{{ $review->rating }}</span>
                </p>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    <strong>Comment:</strong> {{ $review->comment }}
                </p>
                @isset($review->rejection_comment)
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        <strong>Rejection comment:</strong> {{ $review->rejection_comment }}
                    </p>
                @endisset
            </div>

            @if($review->status == 'pending')
{{--                <div class="flex flex-col gap-2 w-52">--}}
                    <form wire:submit="changeStatus" class="flex flex-col gap-2 w-52">
                        <div>
                            <select class="select select-bordered w-full max-w-xs" wire:model.live="status">
                                <option selected>Select status</option>
                                <option value="approved">APPROVED</option>
                                <option value="rejected">REJECTED</option>
                            </select>
                            <x-input-error for="status"/>
                        </div>
                        @if($status == 'rejected')
                            <div>
                                <textarea class="textarea textarea-bordered w-full" wire:model="rejection_comment" placeholder="Why?"></textarea>
                                <x-input-error for="rejection_comment"/>
                            </div>
                        @endif
                        <button
                            type="submit"
                            wire:loading.attr="disabled"
                            class="btn btn-sm btn-primary">Change status</button>
                    </form>
{{--                </div>--}}
            @endif
        </div>
    </div>
</div>
