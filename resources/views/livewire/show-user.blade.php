<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="md:grid md:grid-cols-3 md:gap-6">
            <div class="md:col-span-1 flex justify-between">
                <div class="px-4 sm:px-0">
{{--                    <img src="{{ asset($book->cover_image) }}" alt="{{ $book->name }}" class="rounded-full size-20 object-cover">--}}
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ $user->name }}</h3>

                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        <strong>Email:</strong> {{ $user->email}}
                    </p>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        <strong>Books borrowed:</strong> {{ $user->books_request_count }}
                    </p>
                </div>

            </div>
            <div class="mt-5 md:mt-0 md:col-span-2 px-4 sm:px-0">
                <div class="flex flex-col gap-4">
                    @foreach($userRequests as $request)
                        <x-request-book-card :requestBook="$request" />
                    @endforeach
                </div>

                {{ $userRequests->links() }}

                @if(count($userRequests) == 0)
                    <p class="text-center">This user does not made any request yet</p>
                @endif
            </div>
        </div>
    </div>
</div>
