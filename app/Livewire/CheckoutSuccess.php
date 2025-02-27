<?php

namespace App\Livewire;

use App\Models\Order;
use App\Repositories\LogRepository;
use Illuminate\Http\Request;
use Laravel\Cashier\Cashier;
use Livewire\Attributes\On;
use Livewire\Component;

class CheckoutSuccess extends Component
{
    public Order $order;

    public function mount(Request $request, LogRepository $logRepository)
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

        $logRepository->addRequestAction([
            'object_id' => $order->id,
            'app_section' => 'CheckoutSuccess livewire action on component mount',
            'alteration_made' => 'change order status to completed',
        ]);

        $this->order = $order;
        $this->dispatch('order-placed');
    }

    public function render()
    {
        return view('livewire.checkout-success', [
            'items' => $this->order->items()
                ->with('book')
                ->get()
        ])->layout('layouts.app');
    }
}
