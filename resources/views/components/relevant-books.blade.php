@props(['books' => []])
<div class="space-y-3 px-4 sm:px-0 mb-4">
    <p class="text-lg">You may like this books</p>
    @if(count($books) == 0)
        <p class="text-center">Nothing found</p>
    @endif
    <div class="carousel carousel-center rounded-box w-full space-x-4 p-4">
        @foreach($books as $book)
            <div class="carousel-item">
                <div class="carousel-item card bg-base-100 w-96 shadow-xl">
                    <figure class="px-10 pt-10">
                        <img
                            src="{{ asset($book['cover_image']) }}"
                            alt="Shoes"
                            class="rounded-xl" />
                    </figure>
                    <div class="card-body items-center text-center">
                        <h2 class="card-title">{{ \Illuminate\Support\Str::words($book['name'], 5)}}</h2>
                        <p>{{ \Illuminate\Support\Str::words($book['bibliography'], 10) }}</p>
                        <div class="card-actions">
                            <a class="link link-primary" href="{{ route('books.details', ['book' => $book['id']]) }}">More details</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
