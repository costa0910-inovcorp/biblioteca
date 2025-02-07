@php
//    @props(['method'=>'create', 'btn' => 'Create', 'fileLabel' => 'Photo'])
    if ($publisher) {
        $head = "Update $publisher->name";
        $method = 'edit';
        $btn = 'Update';
    } else {
        $head = 'Create new publisher';
        $method = 'create';
        $btn = 'Create';
    }
@endphp

<x-generic-form
    :method="$method"
    fileLabel="Logo"
    :btn="$btn">
    <x-slot:header>
{{--        <a class="link link-primary" href="{{ route('publishers') }}">Back</a>--}}
        <p>{{ $head }}</p>
    </x-slot:header>
</x-generic-form>
