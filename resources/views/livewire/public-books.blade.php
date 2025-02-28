<div class="space-y-4  pb-4">
    <div class="flex flex-wrap sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mt-8 justify-center">
        @foreach($books as $book)
            <div class="card bg-base-100 w-72 shadow">
                <a href="{{ route('books.details', ['book' => $book->id]) }}">
                    <figure class="px-10 pt-10">
                        <img
                            class="rounded-xl"
                            src="{{ $book->cover_image }}"
                            alt="{{ $book->name }}" />
                    </figure>
                    <div class="card-body items-center text-center">
                            <h2 class="card-title">
                               {{ \Illuminate\Support\Str::words($book->name, 5) }}
                            </h2>
                            <p>{{ \Illuminate\Support\Str::words($book->bibliography, 10) }}</p>
                    </div>
                </a>
            </div>
        @endforeach

        @if(count($books) == 0)
            <p class="text-center">No books found</p>
        @endif
    </div>
    <div class="pt-4">
        {{ $books->links() }}
    </div>
</div>
