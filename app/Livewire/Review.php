<?php

namespace App\Livewire;

use App\Models\Review as ReviewModel;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;


class Review extends Component
{
    use WithPagination;

    #[url(as: 'q')]
    public ?string $search = null;
    public int $pageSize = 5;
    public $alpineData = [];
    public array $reviewsHeader = [
        ['field' => 'COMMENT', 'sort' => true, 'col' => 'comment'],
        ['field' => 'STATUS', 'sort' => true, 'col' => 'status'],
        ['field' => 'RATING', 'sort' => true, 'col' => 'rating']
    ];

    public function render()
    {

        if ($this->search) {
            $this->resetPage();
            $reviews = ReviewModel::query()
                ->whereAny(['comment', 'status'],  'like', '%' . $this->search . '%')
                ->orderByDesc('created_at')
                ->paginate($this->pageSize);

        } else {
            $reviews = ReviewModel::query()
                ->orderByDesc('created_at')
                ->paginate($this->pageSize);
        }

        $this->alpineData = $reviews->toArray()['data'];
        return view('livewire.review', [
            'reviews' => $reviews,
        ]);
    }
}
