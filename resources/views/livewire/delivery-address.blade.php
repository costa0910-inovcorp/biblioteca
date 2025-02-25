<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 min-h-full space-y-4">
        <h1 class="text-2xl font-extrabold px-4 sm:px-0">Shipping</h1>
        <p class="text-neutral-500 px-4 sm:px-0">Fill in your delivery address</p>
        <form class="flex flex-col gap-4 px-4 sm:px-0" wire:submit="saveDeliveryAddressAndContinue">
            <div class="flex flex-col gap-1">
                <label for="address">Address</label>
                <input type="text" id="address" wire:model="address" placeholder="Your address" class="input input-bordered w-full max-w-xl" />
                <x-input-error  for="address"/>
            </div>
            <div class="flex flex-col gap-1">
                <label for="country">Country</label>
                <input type="text" id="country" wire:model="country" placeholder="Your country" class="input input-bordered w-full max-w-xl" />
                <x-input-error  for="country"/>
            </div>
            <div class="flex gap-4 max-w-xl">
                <div class="flex flex-col gap-1 flex-auto">
                    <label for="zip">Zip code</label>
                    <input type="text" id="zip" wire:model="zip" placeholder="2835-067" class="input input-bordered w-full" />
                    <x-input-error  for="zip"/>
                </div>
                <div class="flex flex-col gap-1 flex-auto">
                    <label for="city">City</label>
                    <input type="text" id="city" wire:model="city" placeholder="Your city" class="input input-bordered w-full" />
                    <x-input-error  for="city"/>
                </div>
            </div>
            <button class="btn btn-primary rounded-full max-w-xl">Pay</button>
            <div wire:loading>
                Placing your order...
            </div>
        </form>
    </div>

    <x-toast />
</div>
