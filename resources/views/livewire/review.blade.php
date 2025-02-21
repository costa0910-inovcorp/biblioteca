<x-alpine-data>
    <div class="p-4 flex justify-center">
        <x-search
        />
    </div>
    <x-table :alpineData="$reviews->toArray()['data']">
        <thead>
        <x-table.head :headData="$reviewsHeader"/>
        </thead>
        <tbody>
        @if($reviews == null)
            <tr>
                <td class="text-center" colspan="7">Loading reviews</td>
            </tr>
        @elseif(count($reviews) == 0)
            <tr>
                <td  colspan="7" class="text-center">No reviews found</td>
            </tr>
        @endif
        <template x-for="review in tableData">
            <tr :key="review.id">
                <td x-text="review.comment.length > 80 ? review.comment.substring(0, 80) + '...' : review.comment"></td>
                <td x-text="review.status"></td>
                <td x-text="review.rating"></td>
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
                                <li><a x-bind:href="window.location.origin + '/reviews/' + review.id">Details</a></li>
                            @endcan
                        </ul>
                    </div>
                </th>
            </tr>
        </template>
        </tbody>
        <tfoot>
        <x-table.head :headData="$reviewsHeader"/>
        </tfoot>
    </x-table>

    <div class="px-4 py-6 z-0">
        {{ $reviews->links() }}
    </div>
</x-alpine-data>
