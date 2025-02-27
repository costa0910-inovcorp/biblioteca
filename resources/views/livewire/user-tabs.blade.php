<div class="flex flex-col gap-2">
    <div role="tablist" class="tabs tabs-boxed">
        <button role="tab" wire:click="toggleDefaultTab('requests')" class="tab {{ $defaultTab ? 'tab-active' : '' }}">Requests</button>
        <button role="tab" wire:click="toggleDefaultTab('waitlist')"  class="tab {{ $defaultTab ? '' : 'tab-active' }}">Waitlist</button>
    </div>
    @if($defaultTab)
        <livewire:user-requests />
    @else
        <livewire:user-waitlist />
    @endif
</div>
