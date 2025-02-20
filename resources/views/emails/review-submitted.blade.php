<x-emails-template>
    <x-slot:title>
        New Review Submitted
    </x-slot:title>
    <h2 style="color: #333; font-size: 20px;">New review has been submitted</h2>
    <p style="color: #555; font-size: 16px;">
        <strong>{{ $review->user->name }}</strong> ({{ $review->user->email }}) has submit review on
        <strong>{{ $review->book->name }}</strong>.</p>

    <p style="color: #555; font-size: 16px;">Review details <a href="{{ route('reviews.show', ['id' => $review->id] ) }}" target="_blank">here</a></p>
</x-emails-template>
