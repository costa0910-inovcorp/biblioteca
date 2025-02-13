<?php

namespace App\Livewire;

use App\Models\BookRequest;
use Livewire\Attributes\On;
use Livewire\Component;

class RequestBookStats extends Component
{
    public int $activeRequests = 0;
    public int $last30DaysRequests = 0;
    public int $returnedBooksToday = 0;

    protected function calculateActiveRequests(): void
    {
        $this->activeRequests = BookRequest::query()
            ->where('return_date', null)->count();
    }
    protected function calculateReturnedBooksToday(): void {
        $this->returnedBooksToday = BookRequest::query()
            ->whereDate('return_date', today()->toDateString())->count();
    }

    protected function calculateLast30DaysRequests(): void {
        $this->last30DaysRequests = BookRequest::query()
            ->whereDate('created_at','>=', today()->subDays(30)->toDateString())
            ->count();
    }

    #[On('book-returned')]
    #[On('books-borrowed')]
    public function calculateStats(): void
    {
        $this->calculateActiveRequests();
        $this->calculateReturnedBooksToday();
        $this->calculateLast30DaysRequests();
    }

    public function render()
    {
        $this->calculateStats();
        return view('livewire.request-book-stats');
    }
}
