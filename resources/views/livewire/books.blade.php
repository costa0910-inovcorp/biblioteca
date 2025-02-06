<div x-data="{
            tableData: @entangle('alpineData'),
            orders: {},
            sortCol(col) {
                //store order, asc or desc
                this.orders[col] = !this.orders[col]; // true by default

                this.tableData = this.tableData.sort((a, b) => {
                    if (typeof a[col] === 'string' && col != 'price') {
                        return this.orders[col]
                            ? a[col].localeCompare(b[col])
                            : b[col].localeCompare(a[col]);
                    } else {
                        if (typeof a[col] == 'object') {
                            return this.orders[col] ? a[col].name - b[col].name : b[col].name - a[col].name;
                        } else {
                            pa = parseFloat(a[col]);
                            pb = parseFloat(b[col]);
                            return this.orders[col] ? pa - pb : pb - pa;
                        }
                    }
                });
            }
        }">
    <div class="p-4 flex gap-2 justify-between">
        <x-btn-link href="{{route('books.create')}}">
            Create book
        </x-btn-link>
        <x-search
            selectModel="selectedField"
            :fields="$fields"
        />
        <x-btn-link href="{{route('books.export')}}">
            export books
        </x-btn-link>
    </div>
    <x-table :alpineData="$books->toArray()['data']">
        <thead>
            <x-table.head :headData="$booksHeader"/>
        </thead>
        <tbody>
        @if($books == null)
            <tr>
                <td class="flex justify-center" colspan="5">Loading</td>
            </tr>
        @elseif(count($books) == 0)
            <tr>
                <td class="flex justify-center" colspan="5">No books</td>
            </tr>
        @endif

        @foreach($books as $book)
            <tr wire:key="{{ $book->id }}}">
                <x-table.td-with-image :data="$book" />
                <td>
                    {{ $book->isbn }}

                </td>

                <td>
                    {{ \Illuminate\Support\Str::words($book->bibliography, 10) }}
                </td>
                <td>
                    {{ $book->publisher->name }}
                </td>
                <td>
                    {{ "$$book->price" }}
                </td>
                <td class="flex flex-wrap gap-1">
                    @foreach($book->authors as $author)
                        {{ $author->name }}
                        @if (!$loop->last)
                            {{ ", " }}
                        @endif
                    @endforeach
                </td>
                <th>
                    <div class="dropdown dropdown-top dropdown-end">
                        <div tabindex="0" role="button" class="btn btn-ghost btn-xs">more</div>
                        <ul tabindex="0" class="dropdown-content menu bg-base-100 rounded-box z-[100] w-52 p-2 shadow">
                            <li><a href="{{ route("books.edit", ['book' => $book->id]) }}">Edit</a></li>
                            <li>
                                <button type="button" wire:click="deleteBook('{{ $book->id }}')" wire:confirm="Are you sure you wanna delete this book (it's will delete any relation this book may have with any other entity)?">delete</button>
                            </li>
                        </ul>
                    </div>
                </th>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
            <x-table.head :data="$booksHeader"/>
        </tfoot>
    </x-table>

    <div class="px-4 py-6 z-0">
        {{ $books->links() }}
    </div>
</div>
