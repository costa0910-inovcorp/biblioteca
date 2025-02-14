<x-emails-template>
    <x-slot:title>
        Reminder that's date to return book it's tomorrow
    </x-slot:title>
    <h2 style="color: #333; font-size: 20px;">Hello {{  $requestDetails->user_name }},</h2>
    <p style="color: #555; font-size: 16px;">This email it's to remainder that's tomorrow {{ $requestDetails->predicted_return_date  }} it's the due date to return the book included below.</p>

    <div style="text-align: center; margin: 20px 0;">
        <p>{{ $requestDetails->book->name }}</p>
        <img src="{{ asset($requestDetails->cover_image) }}" alt="Book Cover" style="max-width: 100%; height: auto; border-radius: 5px;">
    </div>
</x-emails-template>
