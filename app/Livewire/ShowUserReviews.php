<?php

namespace App\Livewire;

use App\Enums\ReviewEnum;
use Livewire\Component;

class ShowUserReviews extends Component
{
    public string $bookId;

    public function render()
    {
        $reviews = \App\Models\Review::query()
            ->with(['user'])
            ->where('book_id', $this->bookId)
            ->where('status', '=', ReviewEnum::APPROVED->value)
            ->orderBy('created_at', 'desc')
            ->paginate(6);
        return view('livewire.show-user-reviews', ['reviews' => $reviews]);
    }
}
