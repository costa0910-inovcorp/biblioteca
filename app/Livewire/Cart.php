<?php

namespace App\Livewire;

use App\Models\CartItem;
use App\Repositories\LogRepository;
use Livewire\Attributes\On;
use Livewire\Component;

class Cart extends Component
{

    public function removeFromCart(string $bookId, LogRepository $logRepository): void
    {
        $item = CartItem::query()
            ->where('user_id', auth()->id())
            ->where('book_id', $bookId)->first();

        if ($item->exists) {
            $item->delete();

            $logRepository->addRequestAction([
                'object_id' => $item->book_id,
                'app_section' => 'Cart livewire component action removeFromCart',
                'alteration_made' => 'remove item from cart',
            ]);

            $this->dispatch('refresh');
            $this->dispatch('removed-from-cart', removed: true, message:'Book has been removed from your cart');
        }
    }

    public function render()
    {
        $items = CartItem::query()->with('book')
        ->where('user_id', auth()->id())->latest()->get();

        $items = $items->filter(function ($item) {
            if(!$item->book){
                $this->removeFromCart($item->book_id);
            }
            return $item->book != null;
        });

        $total = $items->sum(function ($item) {
            return $item->book->price * $item->quantity;
        });

        return view('livewire.cart', [
            'items' => $items,
            'total' => $total
        ])->layout('layouts.app');
    }
}
