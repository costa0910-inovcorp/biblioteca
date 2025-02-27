<?php

namespace App\Livewire;

use Livewire\Component;

class UserTabs extends Component
{
    private array $tabs = ['requests', 'waitlist'];
    public bool $defaultTab = true;

    public function toggleDefaultTab(string $tab): void
    {
        if(in_array($tab, $this->tabs) && $tab == 'requests') {
            $this->defaultTab = true;
        } else if(in_array($tab, $this->tabs) && $tab == 'waitlist') {
            $this->defaultTab = false;
        }
    }

    public function render()
    {
        return view('livewire.user-tabs');
    }
}
