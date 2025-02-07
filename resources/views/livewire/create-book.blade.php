{{--<div class="flex justify-center">--}}
{{--    <form wire:submit="createPost" class="p-4 space-y-4  w-1/2">--}}
{{--        <div class="space-y-1">--}}
{{--            <x-label for="name" value="Name" />--}}
{{--            <x-input type="text" wire:model="form.name" id="name" class="w-full"/>--}}
{{--            <x-input-error for="form.name"/>--}}
{{--        </div>--}}

{{--        <div class="space-y-1">--}}
{{--            <x-label for="isbn" value="ISBN" />--}}
{{--            <x-input type="text" wire:model="form.isbn" id="isbn" class="w-full"/>--}}
{{--            <x-input-error for="form.isbn"/>--}}
{{--        </div>--}}

{{--        <div class="space-y-1">--}}
{{--            <x-label for="price" value="Price" />--}}
{{--            <x-input type="text" wire:model="form.price" id="price" class="w-full"/>--}}
{{--            <x-input-error for="form.price"/>--}}
{{--        </div>--}}

{{--        <div class="space-y-1">--}}
{{--            <x-label for="bibliography" value="Bibliography" />--}}
{{--            <textarea id="bibliography" class="textarea textarea-bordered w-full" wire:model="form.bibliography" placeholder="Book bibliography here..."></textarea>--}}
{{--            <x-input type="text" wire:model="form.bibliography" id="bibliography" class="w-full"/>--}}
{{--            <x-input-error for="form.bibliography"/>--}}
{{--        </div>--}}

{{--        <div class="space-y-1">--}}
{{--            <x-label for="authors" value="Authors" />--}}
{{--            <x-select :options="$authors" model="form.authorsId" id="authors" />--}}
{{--            <x-input-error for="form.authorsId"/>--}}
{{--        </div>--}}

{{--        <div class="space-y-1">--}}
{{--            <x-label for="publisher" value="Publisher" />--}}
{{--            <x-select--}}
{{--                id="publisher"--}}
{{--                :options="$publishers"--}}
{{--                model="form.publisherId"--}}
{{--                :multiple="false"--}}
{{--                default="Select book publisher"--}}
{{--            />--}}
{{--            <x-input-error for="form.publisherId"/>--}}
{{--        </div>--}}

{{--        <div class="space-y-1">--}}
{{--            @if ($form->coverImage)--}}
{{--                <img src="{{ $form->coverImage->temporaryUrl() ?? '' }}">--}}
{{--            @endif--}}
{{--            <x-label for="coverImage" value="Cover image" />--}}
{{--            <input type="file" wire:model="form.coverImage" accept="jpg,jpeg,png">--}}

{{--            <x-input-error for="form.coverImage"/>--}}
{{--        </div>--}}
{{--        <x-button>--}}
{{--            Create--}}
{{--        </x-button>--}}
{{--    </form>--}}
{{--</div>--}}

<x-book-form
    :authors="$authors"
    :publishers="$publishers" >
    <x-slot:header>
        <a class="link link-primary" href="{{ route('books') }}">back</a>
        <p>Create new book</p>
    </x-slot:header>
</x-book-form>
