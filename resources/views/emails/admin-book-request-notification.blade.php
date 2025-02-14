<x-emails-template>
    <x-slot:title>
        New Book Requested
    </x-slot:title>
    <h2 style="color: #333; font-size: 20px;">New Book Request Received</h2>
    <p style="color: #555; font-size: 16px;"><strong>{{ $data['user_name'] }}</strong> ({{ $data['user_email'] }}) has requested the book <strong>{{ $data['book_name'] }}</strong>.</p>

    <div style="text-align: center; margin: 20px 0;">
        <img src="{{ asset($data['cover_image']) }}" alt="Book Cover" style="max-width: 100%; height: auto; border-radius: 5px;">
    </div>
</x-emails-template>
