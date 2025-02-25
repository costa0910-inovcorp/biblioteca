<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;

class CartMenu extends Component
{

    #[On(['book-added-to-cart', 'removed-from-cart', 'order-placed', 'order-cancelled'])]
    public function updateCartItems():void
    {
        $this->dispatch('refresh');
    }

    public function render()
    {
        return view('livewire.cart-menu', [
            'items' => auth()->user()->cartItems()->count(),
        ]);
    }
}
