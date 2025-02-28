

<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800  shadow-sm sm:rounded-lg">
            <x-alpine-data>
                <div class="p-4 flex justify-center">
                    <x-search
                    />
                </div>
                <x-table>
                    <thead>
                    <x-table.head :headData="$logsHeader"/>
                    </thead>
                    <tbody>
                    @if($logs == null)
                        <tr>
                            <td class="text-center" colspan="7">Loading logs</td>
                        </tr>
                    @elseif(count($logs) == 0)
                        <tr>
                            <td  colspan="7" class="text-center">No logs found</td>
                        </tr>
                    @endif
                    <template x-for="log in tableData">
                        <tr :key="log.id">
                            <td x-text="log.created_at"></td>
                            <td x-text="log.user.name > 80 ? log.user.name.substring(0, 80) + '...' : log.user.name"></td>
                            <td x-text="log.user_agent"></td>
                            <td x-text="log.ip_address"></td>
                            <td x-text="log.object_id"></td>
                            <td x-text="log.app_section"></td>
                            <td x-text="log.alteration_made"></td>
                        </tr>
                    </template>
                    </tbody>
                    <tfoot>
                    <x-table.head :headData="$logsHeader"/>
                    </tfoot>
                </x-table>

                <div class="px-4 py-6 z-0">
                    {{ $logs->links() }}
                </div>
            </x-alpine-data>
        </div>
    </div>
</div>
