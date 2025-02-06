<x-book-form
    method="editBook"
    btn="Update">
    <x-slot:header>
        <a class="link link-primary" href="{{ route('books') }}">back</a>
        <p class="">Update {{ $oldBookData->name }}</p>
    </x-slot:header>
</x-book-form>
