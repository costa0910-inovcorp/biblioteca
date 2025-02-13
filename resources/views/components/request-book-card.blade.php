@props(['request'])

@php
    use Carbon\Carbon;

    $return_date = '2025-02-16';
    $predicted_return_date = '2025-02-17';
@endphp

<div class="card card-side bg-base-100 shadow-xl card-compact card-bordered">
    <figure>
        <div class="avatar">
            <div class="w-24 rounded">
                <img src="{{ $request->book?->cover_image }}" alt="{{ $request->book?->name ?? 'No book' }}"/>
            </div>
        </div>
    </figure>
    <div class="card-body">
        <h2 class="card-title">{{ $request->book?->name?? 'no book' }}</h2>
        <p>
            <span><strong>Borrow on:</strong> {{ $request->created_at }}</span>
            <span class="block"><strong>Predicted return date:</strong> {{ $request->predicted_return_date }}</span>
        </p>
        <div class="card-actions justify-end">
            @if($return_date)
                <div class="badge badge-neutral flex-wrap">
                    Confirmed on {{ $return_date }},
                    <span class="ml-2">
                        @if (Carbon::parse($return_date)->equalTo(Carbon::parse($predicted_return_date)))
                            on time!
                        @elseif (Carbon::parse($return_date)->lessThan(Carbon::parse($predicted_return_date)))
                            early by {{ Carbon::parse($predicted_return_date)->diffInDays($return_date, true) }} day(s).
                        @else
                            late by {{ Carbon::parse($return_date)->diffInDays($predicted_return_date, true) }} day(s).
                        @endif
                    </span>
                </div>
            @else
                <div class="badge badge-info">No confirmation yet</div>
                @can('manage books')
                    <button class="btn btn-xs btn-primary">Confirm reception</button>
                @endcan
            @endif
        </div>
    </div>
</div>
