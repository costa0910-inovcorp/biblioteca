<x-emails-template>
    <x-slot:title>
        Status change
    </x-slot:title>
    <h2 style="color: #333; font-size: 20px;">Hello {{  $review->user->name }},</h2>
    <p style="color: #555; font-size: 16px;">Status of your review has change,</p>

    <div style="text-align: center; margin: 20px 0;">
        @if($review->status == \App\Enums\ReviewEnum::APPROVED->value)
            <p>Congratulations, your review was approved, now all users can see your review.</p>
        @else
            <p>Your review on book({{ $review->book->name }}) was <strong>Rejected</strong></p>
            <p><strong>Why?</strong> {{ $review->rejection_comment }}</p>
        @endif
    </div>
</x-emails-template>
