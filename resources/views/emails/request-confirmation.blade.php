<x-book-request-confirmation-email>
    <x-slot:title>
        Book Request Confirmation
    </x-slot:title>
    <h2 style="color: #333; font-size: 20px;">Hello, {{ $data['user_name'] }}!</h2>
    <p style="color: #555; font-size: 16px;">Your book request for <strong>{{ $data['book_name'] }}</strong> has been received.</p>
    {{--    <p style="color: #555; font-size: 16px;">We will notify you when it is ready for pickup.</p>--}}

    <div style="text-align: center; margin: 20px 0;">
        <img src="{{ asset($data['cover_image']) }}" alt="Book Cover" style="max-width: 100%; height: auto; border-radius: 5px;">
    </div>

    <a href="{{ url('/') }}" style="display: inline-block; margin-top: 10px; padding: 10px 20px; background: #3490dc; color: #ffffff; text-decoration: none; border-radius: 5px;">
        Go to Library
    </a>
</x-book-request-confirmation-email>
