@props(['fields' => [], 'selectModel' => null, 'searchModel' => 'search'])

@php
    $sizes = [5, 10, 15, 20, 25]
@endphp
<div class="flex items-center space-x-4">
    <!-- Search Input -->
    <input type="text"
{{--           wire:model.live="{{ $searchModel }}}"--}}
            wire:model.live.debounce.300ms="search"
           class="input input-bordered w-full max-w-xs"
           placeholder="Search..." />

    <!-- Select Dropdown for Fields -->
    @isset($selectModel)
        <select wire:model.live="{{ $selectModel }}" class="select select-bordered">
            @foreach($fields as $field)
                <option value="{{ $field }}">{{ ucfirst($field) }}</option>
            @endforeach
        </select>
    @endisset
    <select wire:model.live="pageSize" class="select select-bordered">
        @foreach($sizes as $size)
            <option value="{{ $size }}">{{ $size }}</option>
        @endforeach
    </select>
</div>
