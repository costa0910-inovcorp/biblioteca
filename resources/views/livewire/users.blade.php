<div>
    <div class="p-4 flex gap-2 justify-between">
        <x-search
            selectModel="selectedField"
            :fields="$fields"
        />
    </div>
    <x-table>
        <thead>
        <x-table.head :headData="$usersHeader"/>
        </thead>
        <tbody>
        @if($users == null)
            <tr>
                <td class="text-center" colspan="7">Loading users</td>
            </tr>
        @elseif(count($users) == 0)
            <tr>
                <td  colspan="7" class="text-center">No users found</td>
            </tr>
        @endif
        @foreach($users as $user)
            <tr wire:key="$user->id">
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    @if($user->hasRole('admin'))
                        <div class="badge badge-primary">admin</div>
                    @else
                        <div class="badge badge-warning">Citizen</div>
                    @endif
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
                        <ul tabindex="0" class="dropdown-content menu bg-base-100 rounded-box z-[100] w-52 p-2 shadow">
                            <li>
                                <a href="{{ route('users.show', ['user' => $user->id]) }}">Details</a>
                            <li>
                                @if($user->hasRole('admin'))
                                    <button wire:click="remove({{ $user->id }})">Remove as admin</button>
                                @else
                                    <button wire:click="add({{ $user->id }})">Add as admin</button>
                                @endif
                            </li>
                        </ul>
                    </div>
                </th>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
        <x-table.head :headData="$usersHeader"/>
        </tfoot>
    </x-table>

    <div class="px-4 py-6 z-0">
        {{ $users->links() }}
    </div>
</div>
