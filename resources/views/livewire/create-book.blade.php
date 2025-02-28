<x-book-form
    :authors="$authors"
    :publishers="$publishers">
    <x-slot:header>
        <a class="link link-primary" href="{{ route('books') }}">back</a>
        <p>Create new book</p>
    </x-slot:header>
</x-book-form>
