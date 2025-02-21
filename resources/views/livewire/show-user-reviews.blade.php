<div class="space-y-3">
    {{-- Because she competes with no one, no one can compete with her. --}}
    <p class="text-lg">Reviews</p>
    <div class="flex gap-2 flex-wrap">
        @if(count($reviews) == 0)
            <p>No reviews yet!</p>
        @endif
        @foreach($reviews as $review)
            <div class="card bg-base-100 w-96 shadow-xl max-md:flex-auto">
                <div class="card-body">
                    <h2 class="card-title">{{ $review->user->name }}</h2>
                     <div class="rating flex items-center space-x-1">
{{--                            @dd($review->rating, $reviews->toArray())--}}
                            @for ($i = 1; $i <= 5; $i++)
                                @if (floor($review->rating) >= $i)
                                    <input disabled type="radio" class="mask mask-star bg-black cursor-default" />
                                @elseif ($review->rating == $i - 0.5)
{{--                                    @dd(abs($i), 'half', $review->rating)--}}
                                    <div class="relative w-6 h-6">
                                        <div class="absolute inset-0 mask mask-star bg-gray-300">
                                            <div class="absolute inset-0 w-1/2 mask mask-star-1 bg-black"></div>
                                        </div>
                                    </div>
                                @else
{{--                                    @dd(abs($i), 'end', abs($review->rating))--}}
                                    <input disabled type="radio" class="mask mask-star bg-gray-300 cursor-default" />
                                @endif
                            @endfor
                    </div>
                    <p>{{ $review->comment }}</p>
                </div>
            </div>
        @endforeach
    </div>

    {{ $reviews->links() }}
</div>
