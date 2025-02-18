<div class="join">
    <div>
        <div>
            <input
                class="input input-bordered join-item"
                   placeholder="Search" wire:model="searchTerm" />
        </div>
    </div>
    <select class="select select-bordered join-item" wire:model="filterBy">
        <option disabled selected>Filter</option>
        <option value="all">All</option>
        <option value="returned">Returned</option>
        <option value="not-returned">Not returned</option>
    </select>
    <div class="indicator">
        <span class="indicator-item badge badge-secondary">new</span>
        <button class="btn join-item" wire:click="filterOrSearch">Search</button>
    </div>
</div>
