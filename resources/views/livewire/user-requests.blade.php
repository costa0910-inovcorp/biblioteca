<div class="space-y-4">
    <p>In box (your requests)</p>

    <div class="flex flex-col gap-4">

        @foreach($userRequests as $requestBook)
            <livewire:request-book-card :requestBook="$requestBook" wire:key="$requestBook->id"  />
        @endforeach

        {{ $userRequests->links() }}
    </div>
</div>
