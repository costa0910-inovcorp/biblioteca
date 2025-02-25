<?php

namespace App\Livewire;

use App\Livewire\Forms\ReturnRequestMethod;
use App\Models\Book;
use App\Models\CartItem;
use App\Repositories\RelevantBooksRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class BookDetails extends Component
{
    use ReturnRequestMethod, WithPagination;

    public Book $book;

    public function mount(Book $book): void {
        $this->book = $book;
    }

    public function addToCart()
    {
        if(empty(auth()->user())) {
            return redirect()->route('login');
        }

        $item = CartItem::query()
            ->where('user_id', auth()->id())
            ->where('book_id', $this->book->id)->first();
        if(!empty($item)) {
            $this->dispatch('not-added-to-cart', warning: true, message:'Book already added to cart');
            //No need to increment item, because only one book can exist in cart
            return;
        }

        CartItem::query()
            ->create([
                'user_id' => auth()->id(),
                'book_id' => $this->book->id,
                'id' => Str::uuid(),
            ]);
        $this->dispatch('book-added-to-cart', success: true, message:'Book added to cart');
    }

    public function render()
    {
        return view('livewire.book-details', [
            'relevantBooks' => $this->relatedBooks(),
            'bookRequests' => $this->getRequestsBaseOnPermission(),
        ])->layout('layouts.guest');
    }

    protected function relatedBooks(): array
    {
        $repository = app(RelevantBooksRepository::class);
        return $repository->getSimilarBooks($this->book);
    }

    protected function getRequestsBaseOnPermission(): LengthAwarePaginator | array
    {
        if (empty(auth()->user())) return [];

        if (auth()->user()->can('view all requests')) {
            return $this->book->requests()->with(['user'])->latest()->paginate(3);
        } else {
            return $this->book->requests()
                ->where('user_id', auth()->id())
                ->with(['user'])->latest()->paginate(3);
        }
    }
}
