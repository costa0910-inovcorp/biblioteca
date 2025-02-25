<?php

namespace App\Repositories;

use App\Models\Book;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;
use Stripe\StripeClient;

class PlacingOrderRepository
{
    // Set your secret key. Remember to switch to your live secret key in production.
    // See your keys here: https://dashboard.stripe.com/apikeys

    protected function CreateOrFindPriceIds($items): array {
        $stripe = new StripeClient(config('services.stripe.secret'));
        $currency = config('cashier.currency');

        $priceIds = [];

        foreach ($items as $item) {
            $book = $item->book;
            if ($book->stripe_price_id) {
                $priceIds[] = $book->stripe_price_id;
            } else {
                $product = $stripe->products->create(['name' => $book->name]);
                $price = $stripe->prices->create([
                    'product' => $product->id,
                    'unit_amount' => $book->price * 100,
                    'currency' => $currency,
                ]);
                $book->stripe_price_id = $price->id;
                $book->save();
                $priceIds[] = $price->id;
            }
        }

        return $priceIds;
    }

    public function createOrder($cartItems, string $address): array
    {
        $price_Ids = $this->CreateOrFindPriceIds($cartItems);
        $order = Order::query()->create([
            'id' => Str::uuid(),
            'user_id' => auth()->id(),
            'total_price' => $this->getTotalPrice($cartItems),
            'delivery_address' => $address
        ]);

        $cartItemsIds = [];
        foreach ($cartItems as $cartItem) {
            $this->createOrderItem($order->id, $cartItem);
            $cartItemsIds[] = $cartItem->id;
            Book::query()->where('id', $cartItem->book_id)->update([
                'is_available' => false
            ]);
        }

        //Delete all
        CartItem::query()->whereIn('id',$cartItemsIds)->delete();

        return [
            'order' => $order,
            'price_ids' => $price_Ids
        ];
    }

    protected function getTotalPrice($cartItems): float
    {
        return $cartItems->sum(function ($item) {
            return $item->book->price * $item->quantity;
        });
    }

    protected function createOrderItem(string $orderId, CartItem $cartItem):void
    {
        OrderItem::query()->create([
            'id' => Str::uuid(),
            'order_id' => $orderId,
            'book_id' => $cartItem->book->id,
            'price' => $cartItem->book->price,
        ]);
    }
}
