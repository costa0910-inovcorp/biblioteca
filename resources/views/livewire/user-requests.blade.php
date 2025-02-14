<div class="space-y-4">
    <p>In box (your requests)</p>

    <div class="flex flex-col gap-4">
        @if(count($userRequests) == 0)
            <p class="text-center">Borrow books for requests to appear here</p>
        @endif

        @foreach($userRequests as $requestBook)
            <x-request-book-card :requestBook="$requestBook" wire:key="$requestBook->id"  />
        @endforeach

        {{ $userRequests->links() }}
    </div>
</div>
