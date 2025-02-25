<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800  shadow-xl sm:rounded-lg">
                <x-alpine-data>
                <div class="p-4 flex justify-center">
                    <x-search
                    />
                </div>
                <x-table :alpineData="$orders->toArray()['data']">
                    <thead>
                    <x-table.head :headData="$ordersHeader"/>
                    </thead>
                    <tbody>
                    @if($orders == null)
                        <tr>
                            <td class="text-center" colspan="7">Loading orders</td>
                        </tr>
                    @elseif(count($orders) == 0)
                        <tr>
                            <td  colspan="7" class="text-center">No orders found</td>
                        </tr>
                    @endif
                    <template x-for="order in tableData">
                        <tr :key="order.id">
                            <td x-text="order.user.name > 80 ? order.user.name.substring(0, 80) + '...' : order.user.name"></td>
                            <td x-text="order.delivery_address"></td>
                            <template x-if="order.status == 'completed'">
                                <td>
                                    <div class="badge badge-primary" x-text="order.status"></div>
                                </td>
                            </template>
                            <template x-if="order.status == 'pending'">
                                <td>
                                    <div class="badge badge-warning" x-text="order.status"></div>
                                </td>
                            </template>
                            <td x-text="'€' + order.total_price"></td>
                        </tr>
                    </template>
                    </tbody>
                    <tfoot>
                    <x-table.head :headData="$ordersHeader"/>
                    </tfoot>
                </x-table>

                <div class="px-4 py-6 z-0">
                    {{ $orders->links() }}
                </div>
            </x-alpine-data>
        </div>
    </div>
</div>
