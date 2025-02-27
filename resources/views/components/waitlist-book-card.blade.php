@php
    use Carbon\Carbon;
@endphp

<div {{ $attributes->merge(['class' => 'card card-side bg-base-100 shadow-sm card-compact card-bordered']) }}>
    <figure>
        <div class="avatar">
            <div class="w-24 rounded">
                <img src="{{ asset($waitlistRequest->book?->cover_image) }}" alt="{{ $waitlistRequest->book?->name ?? 'No book' }}"/>
            </div>
        </div>
    </figure>
    <div class="card-body">
        <div class="max-sm:flex-col card-title">
            <h2>{{ \Illuminate\Support\Str::words($waitlistRequest->book?->name, 7)?? 'no book' }}</h2>
        </div>
        <p class="max-sm:flex max-sm:flex-col max-sm:items-center">
            <span><strong>Added on:</strong> {{ Carbon::parse($waitlistRequest->created_at)->toDayDateTimeString() }}</span>
        </p>
        <div class="card-actions justify-center">
            <div class="badge badge-lg flex items-center h-fit gap-1">
                    @if($waitlistRequest->position == 1)
                        <span class="font-extrabold">First</span> on the line
                    @elseif($waitlistRequest->position == 2)
                        <span class="font-extrabold">Second</span> on the line
                    @else
                        <span class="font-extrabold">
                            {{ $waitlistRequest->position - 1 }}
                        </span>
                            users in front of you
                    @endif
            </div>
        </div>
    </div>
</div>
