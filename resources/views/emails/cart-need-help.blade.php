<x-emails-template>
    <x-slot:title>
        Cart inactive
    </x-slot:title>
    <h2 style="color: #333; font-size: 20px;">Hello {{  $user->name }},</h2>
    <p style="color: #555; font-size: 16px;">We notice that's you added books to your cart pass hour and we just want to let your know we are here for you.</p>

    <div style="text-align: center; margin: 20px 0;">
        <p>If you need assistance, email us <p><a href="mailto:{{ config('mail.from.address') }}">Send email</a></p> </p>
    </div>
</x-emails-template>
