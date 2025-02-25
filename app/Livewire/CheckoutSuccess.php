<?php

namespace App\Livewire;

use App\Models\Order;
use Illuminate\Http\Request;
use Laravel\Cashier\Cashier;
use Livewire\Attributes\On;
use Livewire\Component;

class CheckoutSuccess extends Component
{
    public Order $order;

    public function mount(Request $request)
    {
        $sessionId = $request->get('session_id');

        if ($sessionId === null) {
            return;
        }

        $session = Cashier::stripe()->checkout->sessions->retrieve($sessionId);

        if ($session->payment_status !== 'paid') {
            return;
        }

        $orderId = $session['metadata']['order_id'] ?? null;

        $order = Order::findOrFail($orderId);

        $order->update(['status' => 'completed']);
        $this->order = $order;
        $this->dispatch('order-placed');
    }

    public function render()
    {
        return view('livewire.checkout-success')->layout('layouts.app');
    }
}
