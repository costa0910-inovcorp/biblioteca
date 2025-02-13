<div class="space-y-4  pb-8">
{{--    <div class="flex justify-center">--}}
{{--        <x-search--}}
{{--            :fields="[]"--}}
{{--        />--}}
{{--    </div>--}}
    <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mt-8 justify-center">
        @foreach($books as $book)
            <div class="card bg-base-100 w-72 shadow-xl">
                <figure>
                    <img
{{--                        src="{{ $book->cover_image }}"--}}
                        src="https://img.daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.webp"
                        alt="{{ $book->name }}" />
                </figure>
                <div class="card-body">
                    <h2 class="card-title">
                       {{ $book->name }}
                    </h2>
                    <p>{{ \Illuminate\Support\Str::words($book->bibliography, 10) }}</p>
                    <div class="card-actions justify-end">
                        @if($book->is_available)
                            <a class="btn btn-primary btn-xs" href="{{ route('public.books.request', ['book' => $book->id]) }}">Borrow</a>
                        @else
                            <div class="badge badge-outline">Not available</div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div>
        {{ $books->links() }}
    </div>
</div>
