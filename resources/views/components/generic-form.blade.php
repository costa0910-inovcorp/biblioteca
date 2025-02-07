@props(['method'=>'create', 'btn' => 'Create', 'fileLabel' => 'Photo', 'routeName' => 'authors'])

<div class="flex flex-col items-center py-6 space-y-4">
    <div class="flex w-1/2 items-center gap-6">
        <a class="link link-primary" href="{{ url()->previous() }}">Back</a>
        {{ $header }}
    </div>
    <form wire:submit.prevent="{{ $method }}" class="space-y-4 w-1/2">
        <div class="space-y-1">
            <x-label for="name" value="Name" />
            <x-input type="text" wire:model.live.debounce.250ms="name" id="name" class="w-full"/>
            <x-input-error for="name"/>
        </div>

        <div class="space-y-1">
            <x-label for="image" value="{{ $fileLabel }}" />
            <input id="image" type="file" wire:model="imageFile" accept="image/*">
            <x-input-error for="imageFile"/>

{{--            @if ( $book->cover_image)--}}
{{--                <img src="{{ Storage::url($book->cover_image) }}" class="w-32 mt-2">--}}
{{--            @endif--}}
        </div>
        <x-button>
            {{ $btn }}
        </x-button>
    </form>
</div>
