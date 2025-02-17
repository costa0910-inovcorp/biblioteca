@props(['fields' => [], 'selectModel' => null, 'searchModel' => 'search'])

@php
    $sizes = [5, 10, 15, 20, 25]
@endphp
<div {{ $attributes->merge(['class' => 'flex flex-col items-center lg:space-x-4 sm:flex-row gap-2' ]) }}>
{{--    flex-wrap lg:flex-row lg:space-x-4--}}
    <!-- Search Input -->
    <input type="text"
{{--           wire:model.live="{{ $searchModel }}}"--}}
            wire:model.live.debounce.300ms="search"
           class="input input-bordered w-full md:max-w-xs"
           placeholder="Search..." />

    <!-- Select Dropdown for Fields -->
    @isset($selectModel)
        <select wire:model.live="{{ $selectModel }}" class="select select-bordered size-min">
            @foreach($fields as $field)
                <option value="{{ $field }}">{{ ucfirst($field) }}</option>
            @endforeach
        </select>
    @endisset
    <select wire:model.live="pageSize" class="select select-bordered size-min">
        @foreach($sizes as $size)
            <option value="{{ $size }}">{{ $size }}</option>
        @endforeach
    </select>
</div>
