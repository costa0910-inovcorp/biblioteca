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
        <p>{{ $head }}</p>
    </x-slot:header>
</x-generic-form>
