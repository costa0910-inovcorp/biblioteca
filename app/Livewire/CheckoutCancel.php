<?php

namespace App\Livewire;

use Livewire\Component;

class CheckoutCancel extends Component
{
    public function mount()
    {
        $this->dispatch('order-cancelled');
    }

    public function render()
    {
        return view('livewire.checkout-cancel')->layout('layouts.app');
    }
}
