<?php

namespace App\Livewire;

use App\Models\CartItem;
use Livewire\Attributes\On;
use Livewire\Component;

class Cart extends Component
{

    public function removeFromCart(string $bookId): void
    {
        $item = CartItem::query()
            ->where('user_id', auth()->id())
            ->where('book_id', $bookId)->first();

        if ($item->exists) {
            $item->delete();
            $this->dispatch('refresh');
            $this->dispatch('removed-from-cart', removed: true, message:'Book has been removed from your cart');
        }
    }

    public function render()
    {
        $items = auth()->user()->cartItems()->with('book')->get();
        $total = $items->sum(function ($item) {
            return $item->book->price * $item->quantity;
        });

        return view('livewire.cart', [
            'items' => $items,
            'total' => $total
        ])->layout('layouts.app');
    }
}
