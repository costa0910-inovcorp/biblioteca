<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 min-h-full space-y-4">
        @if(count($items) == 0)
            <p class="text-center text-2xl font-extrabold">Nothing in your cart, browse books</p>
        @else
            <p><strong class="text-lg font-extrabold px-4 sm:px-0">My cart</strong> ({{ count($items) }} items)</p>
            <div class="grid gap-6 md:grid-cols-3 px-4 sm:px-0">
                <div class="md:col-span-2 flex flex-col gap-2">
                    @foreach($items as $item)
                        <div class="card bg-base-100 w-full  lg:w-9/12 card-side">
                            <figure class="p-5">
                                <img
                                    src="{{ $item->book?->cover_image }}"
                                    alt="{{ $item->book->name }}"
                                    class="rounded-xl" />
                            </figure>
                            <div class="card-body items-center text-center">
                                <a href="{{ route('books.details', ['book' => $item->book->id]) }}" class="font-extrabold text-lg">
                                    {{ \Illuminate\Support\Str::words($item->book->name, 10) }}
                                </a>
                                <p class="text-primary font-extrabold text-xl">€{{ $item->book->price }}</p>
                                <div class="card-actions">
                                    <button class="link link-neutral" wire:click="removeFromCart('{{ $item->book->id }}')">Remove</button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="flex flex-col gap-4">
                    <div class="flex justify-between">
                        <p>Subtotal</p>
                        <p class="font-bold">€{{ $total }}</p>
                    </div>
                    <div class="flex justify-between">
                        <p>Delivery cost</p>
                        <p class="font-bold">€0,00</p>
                    </div>
                    <x-section-border :hide="false"/>
                    <div class="flex flex-col gap-4">
                        <div class="flex justify-between">
                            <p class="text-2xl font-extrabold">Total</p>
                            <p class="text-2xl font-extrabold text-primary">€{{ $total }}</p>
                        </div>
                        <a class="btn btn-primary rounded-full w-full text-lg" href="{{ route('delivery-address') }}">Buy now</a>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <x-toast />
</div>
