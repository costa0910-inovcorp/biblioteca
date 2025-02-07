<div x-data="{
            tableData: @entangle('alpineData'),
            orders: {},
            itemToDeleteId: null,
            sortCol(col) {
                //store order, asc or desc (true or false)
                this.orders[col] = !this.orders[col]; // true by default

                this.tableData = this.tableData.sort((a, b) => {
                    if (typeof a[col] === 'string' && col != 'price') {
                        return this.orders[col]
                            ? a[col].localeCompare(b[col])
                            : b[col].localeCompare(a[col]);
                    } else {
                        if (typeof a[col] == 'object') {
                            console.log(this.orders[col])
                            return this.orders[col] ?
                                a[col].name.localeCompare(b[col].name)
                                : b[col].name.localeCompare(a[col].name);
                        } else {
                            pa = parseFloat(a[col]);
                            pb = parseFloat(b[col]);
                            return this.orders[col] ? pa - pb : pb - pa;
                        }
                    }
                });
            },
            toggleModal(id) {
                this.itemToDeleteId = id;
                window.delete_modal.showModal() // in another x-data state
            }
        }">
    {{ $slot }}
</div>
