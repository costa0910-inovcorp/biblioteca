<x-alpine-data>
    <div class="p-4 flex gap-2 justify-between">
        <x-btn-link href="{{route('publishers.create')}}">
            Create publisher
        </x-btn-link>
        <x-search
        />
        <x-btn-link href="{{route('publishers.export')}}">
            export publishers
        </x-btn-link>
    </div>

    <x-table>
        <thead>
        <x-table.head :headData="$publishersHeader"/>
        </thead>
        <tbody>
        @if($publishers == null)
            <tr>
                <td  colspan="3" class="text-center">Loading publishers...</td>
            </tr>
        @elseif(count($publishers) == 0)
            <tr>
                <td  colspan="3" class="text-center">No publishers found</td>
            </tr>
        @endif
        <template x-for="publisher in tableData">
            <tr :key="publisher.id">
                <x-table.td-with-image>
                    <x-slot:img>
                        <img x-bind:src="window.location.origin + '/' + publisher.logo" x-bind:alt="publisher.name" />
                    </x-slot:img>
                    <div class="font-bold" x-text="publisher.name"></div>
                </x-table.td-with-image>
                <td>
                    <template x-if="publisher.books.length == 0">
                        <span>No books</span>
                    </template>
                    <template x-if="publisher.books.length >= 1">
                        <span x-text="publisher.books.map(b => b.name).join(', ')"></span>
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
                            <li><a x-bind:href="window.location.origin + '/publishers/edit/' + publisher.id">Edit</a></li>
                            <li>
                                <button @click="toggleModal(publisher.id)">delete</button>
                            </li>
                        </ul>
                    </div>
                </th>
            </tr>
        </template>
        </tbody>
        <tfoot>
        <x-table.head :headData="$publishersHeader"/>
        </tfoot>

    </x-table>

    <div class="px-4 py-6 z-0">
        {{ $publishers->links() }}
    </div>

    <x-daisyui-confirmation-modal
        actionName="deletePublisher(itemToDeleteId)"
        name="Publisher"
    />
</x-alpine-data>
