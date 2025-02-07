<div>
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
                <td class="flex justify-center" colspan="5">Loading</td>
            </tr>
        @elseif(count($publishers) == 0)
            <tr>
                <td class="flex justify-center" colspan="5">No Publishers</td>
            </tr>
        @endif

        @foreach($publishers as $publisher)
            <tr wire:key="{{ $publisher->id }}}">
                <x-table.td-with-image :data="$publisher" imgKey="logo" />
                <td>
                    @if(count($publisher->books) == 0)
                        No books yet
                    @elseif(count($publisher->books) < 2)
                        {{ count($publisher->books) . ' book' }}
                    @else
                        {{ count($publisher->books) . ' books' }}
                    @endif
                </td>

                <th>
                    <div class="dropdown dropdown-bottom dropdown-end">
                        <div tabindex="0" role="button" class="btn btn-ghost btn-xs">more</div>
                        <ul tabindex="0" class="dropdown-content menu bg-base-100 rounded-box z-[100] w-52 p-2 shadow">
                            <li><a href="{{ route("publishers.edit", ['publisher' => $publisher->id]) }}">Edit</a></li>
                            <li>
                                <button type="button" wire:click="deletePublisher('{{ $publisher->id }}')" wire:confirm="Are you sure you wanna delete this Publisher (it's will delete any relation this publisher may have with any other entity)?">delete</button>
                            </li>
                        </ul>
                    </div>
                </th>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <x-table.head :data="$publishersHeader"/>
        </tfoot>

    </x-table>

    <div class="px-4 py-6 z-0">
        {{ $publishers->links() }}
    </div>
</div>
