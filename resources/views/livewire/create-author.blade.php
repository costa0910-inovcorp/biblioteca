@php
//    @props(['method'=>'create', 'btn' => 'Create', 'fileLabel' => 'Photo'])
    if ($author) {
        $head = "Update $author->name";
        $method = 'edit';
        $btn = 'Update';
    } else {
        $head = 'Create new author';
        $method = 'create';
        $btn = 'Create';
    }
@endphp

<x-generic-form
    :method="$method"
    :btn="$btn">
    <x-slot:header>
        <a class="link link-primary" href="{{ route('authors') }}">Back</a>
        <p class="">{{ $head }}</p>
    </x-slot:header>
</x-generic-form>
