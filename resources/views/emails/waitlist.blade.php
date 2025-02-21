<x-emails-template>
    <x-slot:title>
        Status change
    </x-slot:title>
    <h2 style="color: #333; font-size: 20px;">Hello {{  $waitList->user->name }},</h2>
    <p style="color: #555; font-size: 16px;">The book below is available now: </p>

    <div style="text-align: center; margin: 20px 0;">
        <div style="text-align: center; margin: 20px 0;">
            <p>{{ $waitList->book->name }}</p>
            <img src="{{ asset($waitList->book->cover_image) }}" alt="Book Cover" style="max-width: 100%; height: auto; border-radius: 5px;">
        </div>
        <p style="color: #555; font-size: 16px;">Request it quickly <a href="{{ route('public.books.request', ['book' => $waitList->book->id] ) }}" target="_blank">here</a></p>
    </div>
</x-emails-template>
