<div>
    <div class="p-4 flex gap-2 justify-between">
        <x-btn-link href="{{route('authors.create')}}">
            Create author
        </x-btn-link>
        <x-search
            selectModel="selectedField"
            :fields="$fields"
        />
        <x-btn-link href="{{ route('authors.export')}}">
            export authors
        </x-btn-link>
    </div>

    <x-table>
        <thead>
        <x-table.head :data="$authorsHeader"/>
        </thead>
        <tbody>
        @if($authors == null)
            <tr>
                <td class="flex justify-center" colspan="5">Loading</td>
            </tr>
        @elseif(count($authors) == 0)
            <tr>
                <td class="flex justify-center" colspan="5">No Authors</td>
            </tr>
        @endif

        @foreach($authors as $author)
            <tr wire:key="{{ $author->id }}}">
                <x-table.td-with-image :data="$author" imgKey="photo" />
                <td>
                    @if (!count($author->books))
                        No books
                    @endif
                    @foreach($author->books as $book)
                        {{ $book->name }}
                        @if (!$loop->last)
                            {{ ", " }}
                        @endif
                    @endforeach
                </td>

                                <th>
                                    <div class="dropdown dropdown-top dropdown-end">
                                        <div tabindex="0" role="button" class="btn btn-ghost btn-xs">more</div>
                                        <ul tabindex="0" class="dropdown-content menu bg-base-100 rounded-box z-[100] w-52 p-2 shadow">
                                            <li><a href="{{ route("authors.edit", ['author' => $author->id]) }}">Edit</a></li>
                                            <li>
                                                <button type="button" wire:click="deleteAuthor('{{ $author->id }}')" wire:confirm="Are you sure you wanna delete this Author (it's will delete any relation this author may have with any other entity)?">delete</button>
                                            </li>
                                        </ul>
                                    </div>
                                </th>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <x-table.head :data="$authorsHeader"/>
        </tfoot>

    </x-table>

    <div class="px-4 py-6 z-0">
        {{ $authors->links() }}
    </div>
</div>
