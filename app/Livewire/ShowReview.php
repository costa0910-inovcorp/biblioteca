<?php

namespace App\Livewire;

use App\Enums\ReviewEnum;
use App\Events\ReviewStatusChange;
use App\Models\Review as ReviewAlias;
use App\Repositories\LogRepository;
use Livewire\Component;

class ShowReview extends Component
{
    public $review;
    public string $status = '';
    public string $rejection_comment = '';

    public function mount(string $id) {
        $this->review = ReviewAlias::query()
            ->with(['user', 'book'])
            ->findOrFail($id);
    }

    public function changeStatus(LogRepository $logRepository) {
        $this->validate([
            'status' => 'required|min:1'
        ]);

        $isInEnum = in_array($this->status, array_column(ReviewEnum::cases(), 'value'));
        if (!$isInEnum) {
            abort('400', 'Status is not valid');
        }

        if ($this->status == ReviewEnum::REJECTED->value) {
            $this->validate(['rejection_comment' => 'required|min:10']);
        }

        $this->review->update([
            'status' => $this->status,
            'rejection_comment' => empty($this->rejection_comment) ? null : $this->rejection_comment,
        ]);

        ReviewStatusChange::dispatch($this->review);

        $logRepository->addRequestAction([
            'object_id' => $this->review->id,
            'app_section' => 'ShowReview livewire component action changeStatus',
            'alteration_made' => 'change review status to ' . $this->status . 'and dispatch event to send reviewer email'
        ]);
    }

    public function render()
    {
        return view('livewire.show-review')->layout('layouts.app');
    }
}
