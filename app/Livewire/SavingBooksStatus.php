<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Component;

class SavingBooksStatus extends Component
{
    public array $savingBooksProcess = [];
    #[On('save-books-to-db-start')]
    public function savingBooksStart($data): void
    {
        $this->removePreviousBooks();
        $this->savingBooksProcess[] = $data;
    }


    #[On('echo:saving-books,SavingBooksStatus')]
    public function savingBooksFinnish($event): void
    {
        Log::info('called: savingBooksFinnish');
        $data = $event['data'];
        $this->savingBooksProcess = collect($this->savingBooksProcess)->map(function ($item) use ($data) {
            if ($item['id'] === $data['id']) {
                return $data;
            }
            return $item;
        })->toArray();
    }

    private function removePreviousBooks(): void
    {
        if (count($this->savingBooksProcess) > 5) {
            $first = $this->savingBooksProcess[0];
            $this->savingBooksProcess = collect($this->savingBooksProcess)->filter(function ($item) use ($first) {
                return $item['id'] != $first['id'];
            })->toArray();
        }
    }

    public function render()
    {
        return view('livewire.saving-books-status');
    }
}
