<?php

namespace App\Livewire;

use App\Repositories\LogRepository;
use Livewire\Component;

class CheckoutCancel extends Component
{
    public function mount(LogRepository $logRepository)
    {
        $logRepository->addRequestAction([
            'object_id' => 'order called',
            'app_section' => 'CheckoutCancel livewire component mount action',
            'alteration_made' => 'order called page'
        ]);
        $this->dispatch('order-cancelled');
    }

    public function render()
    {
        return view('livewire.checkout-cancel')->layout('layouts.app');
    }
}
