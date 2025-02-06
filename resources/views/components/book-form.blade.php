@props(['method'=>'createPost', 'btn' => 'Create', 'authors' => null, 'publishers' => null])

<div class="flex flex-col items-center py-6 space-y-4">
    <div class="flex w-1/2 items-center gap-6">
        {{ $header }}
    </div>
    <form wire:submit.prevent="{{ $method }}" class="space-y-4 w-1/2">
        <div class="space-y-1">
            <x-label for="name" value="Name" />
            <x-input type="text" wire:model.live.debounce.250ms="form.name" id="name" class="w-full"/>
            <x-input-error for="form.name"/>
        </div>

        <div class="space-y-1">
            <x-label for="isbn" value="ISBN" />
            <x-input type="text" wire:model="form.isbn" id="isbn" class="w-full"/>
            <x-input-error for="form.isbn"/>
        </div>

        <div class="space-y-1">
            <x-label for="price" value="Price" />
            <x-input type="text" wire:model="form.price" id="price" class="w-full"/>
            <x-input-error for="form.price"/>
        </div>

        <div class="space-y-1">
            <x-label for="bibliography" value="Bibliography" />
            <textarea id="bibliography" class="textarea textarea-bordered w-full" wire:model="form.bibliography" placeholder="Book bibliography here..."></textarea>
            <x-input-error for="form.bibliography"/>
        </div>

        @isset($authors)
            <div class="space-y-1">
                <x-label for="authors" value="Authors" />
                <x-select :options="$authors" model="form.authorsId" id="authors" />
                <x-input-error for="form.authorsId"/>
            </div>
        @endisset

        @isset($publishers)
            <div class="space-y-1">
                <x-label for="publisher" value="Publisher" />
                <x-select id="publisher" :options="$publishers" model="form.publisherId" :multiple="false" default="Select book publisher"/>
                <x-input-error for="form.publisherId"/>
            </div>
        @endisset

        <div class="space-y-1">
            <x-label for="coverImage" value="Cover image" />
            <input type="file" wire:model="form.coverImage" accept="image/*">
            <x-input-error for="form.coverImage"/>

{{--            @if ( $book->cover_image)--}}
{{--                <img src="{{ Storage::url($book->cover_image) }}" class="w-32 mt-2">--}}
{{--            @endif--}}
        </div>
        <x-button>
            {{ $btn }}
        </x-button>
    </form>
</div>
