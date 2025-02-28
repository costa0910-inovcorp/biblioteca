<?php

namespace App\Livewire;

use App\Models\Order;
use App\Models\Review as ReviewModel;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class OrderSummary extends Component
{
    use WithPagination;

    #[url(as: 'q')]
    public ?string $search = null;
    public int $pageSize = 5;
    public $alpineData = [];
    public array $ordersHeader = [
        ['field' => 'User', 'sort' => true, 'col' => 'user'],
        ['field' => 'Address', 'sort' => true, 'col' => 'delivery_address'],
        ['field' => 'STATUS', 'sort' => true, 'col' => 'status'],
        ['field' => 'Total', 'sort' => true, 'col' => 'total_price']
    ];

    public function render()
    {

        if ($this->search) {
            $this->resetPage();
            $orders = Order::query()
                ->with(['user'])
                ->whereAny(['delivery_address', 'status'], 'like', '%'.$this->search.'%')
                ->orWhereHas('user', function ($query) {
                    $query->where('name', 'LIKE', "%{$this->search}%");
                })->orderByDesc('created_at')
                ->paginate($this->pageSize);

        } else {
            $orders = Order::query()
                ->with(['user'])
                ->orderByDesc('created_at')
                ->paginate($this->pageSize);
        }

        $this->alpineData = $orders->toArray()['data'];
        return view('livewire.order-summary', [
            'orders' => $orders
        ])->layout('layouts.app');
    }
}
