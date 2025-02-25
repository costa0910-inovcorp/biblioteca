<?php

namespace App\Livewire;

use App\Models\CartItem;
use App\Repositories\PlacingOrderRepository;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Validate;
use Livewire\Component;

class DeliveryAddress extends Component
{
    #[Validate('required')]
    public string $address = '';
    #[Validate('required')]
    public string $city = '';
    #[Validate('required:min:3')]
    public string $country = '';
    #[Validate('required|min:8', as: 'Zip code')]
    public string $zip = '';

    public function mount()
    {
        $cartItems = CartItem::query()
            ->with('book')
            ->where('user_id', auth()->id())->get();
        if (count($cartItems) == 0) {
            $this->redirect(route('cart'));
        }
    }

    public function saveDeliveryAddressAndContinue()
    {
        $this->validate();
        $fullAddress = "{$this->address} {$this->zip}, {$this->city}, {$this->country}";

        $repository = app(PlacingOrderRepository::class);
        $userItems = CartItem::query()->where('user_id', auth()->id())->get();

        try {
            DB::beginTransaction();
            $orderAndPriceIds = $repository->createOrder($userItems, $fullAddress);
            DB::commit();
            return auth()->user()->checkout($orderAndPriceIds['price_ids'], [
                'success_url' => route('checkout-success').'?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('checkout-cancel'),
                'metadata' => ['order_id' => $orderAndPriceIds['order']->id],
            ]);
        } catch (\Exception $exception) {
            DB::rollBack();
            $this->dispatch('order-fail', fail:true, message: $exception->getMessage());
        }
    }
    public function render()
    {
        return view('livewire.delivery-address')->layout('layouts.app');
    }
}
