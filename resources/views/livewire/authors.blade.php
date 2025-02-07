<x-alpine-data>
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
        <x-table.head :headData="$authorsHeader"/>
        </thead>
        <tbody>
        @if($authors == null)
            <tr>
                <td class="text-center" colspan="3">Loading authors</td>
            </tr>
        @elseif(count($authors) == 0)
            <tr>
                <td  colspan="3" class="text-center">No authors found</td>
            </tr>
        @endif
        <template x-for="author in tableData">
            <tr :key="author.id">
                <x-table.td-with-image>
                    <x-slot:img>
                        <img x-bind:src="window.location.origin + '/' + author.photo" x-bind:alt="author.name" />
                    </x-slot:img>
                    <div class="font-bold" x-text="author.name"></div>
                </x-table.td-with-image>
                <td>
                    <template x-if="author.books.length == 0">
                        <span>No books</span>
                    </template>
                    <template x-if="author.books.length >= 1">
                        <span x-text="author.books.map(b => b.name).join(', ')"></span>
                    </template>
                </td>

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
                        <ul tabindex="0" class="dropdown-content menu bg-base-100 rounded-box z-[900] w-52 p-2 shadow">
                            <li><a x-bind:href="window.location.origin + '/authors/edit/' + author.id">Edit</a></li>
                            <li>
                                <button @click="toggleModal(author.id)">delete</button>
                            </li>
                        </ul>
                    </div>
                </th>
            </tr>
        </template>
        </tbody>
        <tfoot>
        <x-table.head :headData="$authorsHeader"/>
        </tfoot>

    </x-table>

    <div class="px-4 py-6 z-0">
        {{ $authors->links() }}
    </div>
    <x-daisyui-confirmation-modal
        actionName="deleteAuthor(itemToDeleteId)"
        name="Author"
    />
</x-alpine-data>
