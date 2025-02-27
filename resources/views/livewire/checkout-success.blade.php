<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 my-8 max-sm:space-y-8">
        <div class="flex flex-col justify-center items-center gap-5 px-4 sm:px-0">
            <div class="flex flex-col items-center gap-2">
                <h1 class="font-extrabold text-2xl md:text-3xl">Thank you for your purchase</h1>
                <div class="flex flex-col items-center md:text-xl">
                    <p>We've receive your order will ship in 5-7 business days.</p>
                    <p>Your order number is #{{ \Illuminate\Support\Str::of($order->id)->take(5) }}</p>
                </div>
            </div>
            <div class="card card-compact bg-base-100 w-fit shadow-sm">
                <div class="card-body">
                    <h2 class="card-title font-extrabold">Order Summary</h2>
                    @foreach($items as $item)
                        <div class="flex items-center gap-3">
                            <div class="avatar">
                                <div class="mask mask-squircle h-12 w-12">
                                    <img
                                        src="{{ $item->book?->cover_image }}"
                                        alt="{{ $item->book->name }}" />
                                </div>
                            </div>
                            <div class="flex justify-between items-center w-full">
                                <div class="text-wrap">{{ $item->book->name }}</div>
                                <div class="text-nowrap w-1/2 flex justify-end font-bold">€{{ $item->price }}</div>
                            </div>
                        </div>
                        <x-section-border :hide="false"/>
                    @endforeach
                    <div class="flex justify-around text-xl font-extrabold">
                        <div>Total</div>
                        <div>€{{ $order->total_price }}</div>
                    </div>
                </div>
            </div>
            <a class="btn  btn-outline btn-sm border-2" href="/">Back to Home</a>
        </div>
</div>
