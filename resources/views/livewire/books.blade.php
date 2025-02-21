<x-alpine-data>
    <div class="p-4 grid md:grid-cols-3 gap-4 lg:grid-cols-8">
        @can('manage books')
            <x-btn-link href="{{ route('books.create')}}">
                Create book
            </x-btn-link>
        @endcan
           <x-search
               selectModel="selectedField"
               class="flex flex-wrap lg:flex-row lg:col-span-6 lg:justify-center"
               :fields="$fields"
           />
        @can('manage books')
            <x-btn-link href="{{ route('books.export')}}">
                export books
            </x-btn-link>
        @endcan
    </div>
    <x-table :alpineData="$books->toArray()['data']">
        <thead>
            <x-table.head :headData="$booksHeader"/>
        </thead>
        <tbody>
        @if($books == null)
            <tr>
                <td class="text-center" colspan="7">Loading books</td>
            </tr>
        @elseif(count($books) == 0)
            <tr>
                <td  colspan="7" class="text-center">No books found</td>
            </tr>
        @endif
            <template x-for="book in tableData">
            <tr :key="book.id">
                <x-table.td-with-image>
                    <x-slot:img>
                        <img x-bind:src="book.cover_image.includes('http')? book.cover_image : window.location.origin + '/' + book.cover_image" x-bind:alt="book.name" />
                    </x-slot:img>
                    <div class="font-bold" x-text="book.name.length > 20? book.name.substring(0,20) + '...' : book.name"></div>
                </x-table.td-with-image>
                <td x-text="book.isbn"></td>
                <td x-text="book.bibliography.length > 80 ? book.bibliography.substring(0, 80) + '...' : book.bibliography"></td>
                <td x-text="book.publisher.name"></td>
                <td x-text="book.price"></td>
                <td x-text="book.authors.map(a => a.name).join(', ')"></td>
                <th>
                    <div class="dropdown dropdown-bottom dropdown-end">
                        <div tabindex="0" role="button" class="btn btn-ghost btn-xs">
                            <svg width="25px" height="25px" viewBox="0 0 24 24" fill="#000000" xmlns="http://www.w3.org/2000/svg">

                                <title/>

                                <g id="Complete">

                                    <g id="F-More">

                                        <path d="M8,12a2,2,0,1,1-2-2A2,2,0,0,1,8,12Zm10-2a2,2,0,1,0,2,2A2,2,0,0,0,18,10Zm-6,0a2,2,0,1,0,2,2A2,2,0,0,0,12,10Z" id="Horizontal"/>

                                    </g>

                                </g>

                            </svg>
                        </div>
                        <ul tabindex="0" class="dropdown-content menu bg-base-100 rounded-box z-[100] w-52 p-2 shadow">
                            @can('manage books')
                                <li><a x-bind:href="window.location.origin + '/books/edit/' + book.id">Edit</a></li>
                                <li>
                                    <button @click="toggleModal(book.id)">delete</button>
                                </li>
                            @endcan
                            <li><a x-bind:href="window.location.origin + '/books/show/' + book.id">Details</a></li>
                        </ul>
                    </div>
                </th>
            </tr>
            </template>
        </tbody>
        <tfoot>
            <x-table.head :headData="$booksHeader"/>
        </tfoot>
    </x-table>

    <div class="px-4 py-6 z-0">
        {{ $books->links() }}
    </div>
    <x-daisyui-confirmation-modal
        actionName="deleteBook(itemToDeleteId)"
        name="Book"
    />
</x-alpine-data>
