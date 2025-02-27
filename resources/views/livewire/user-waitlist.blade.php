<div class="flex flex-col gap-4">
    @if(count($inWaitlist) == 0)
        <p class="text-center">No book in your waitlist yet</p>
    @endif

    @foreach($inWaitlist as $request)
        <x-waitlist-book-card :waitlistRequest="$request" />
    @endforeach

    {{ $inWaitlist->links() }}
</div>
