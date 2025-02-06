{{--@props(['alpineData' => []])--}}

{{--@php--}}
{{--//dd($alpineData)--}}
{{--@endphp--}}

{{--<div class="overflow-auto table-pin-rows">--}}
{{--    <table class="table table-lg" x-data="{--}}
{{--        tableData: [],--}}
{{--        type: true,--}}
{{--        sortCol(col) {--}}
{{--            console.log(this.tableData);--}}
{{--            if (true) {--}}
{{--                this.tableData = this.tableData.sort((a, b) => a[col] - b[col]);--}}
{{--            } else {--}}
{{--                this.tableData = this.tableData.sort((a, b) => b[col] - a[col]);--}}
{{--            }--}}
{{--            this.type = !this.type;--}}
{{--            console.log(tableData['name']);--}}
{{--        },--}}
{{--     }" x-init="tableData = [1, 2, 3]">--}}
{{--        {{ $slot }}--}}
{{--    </table>--}}
{{--</div>--}}

<div class="overflow-auto table-pin-rows">
    <table class="table table-lg">
        {{ $slot }}
    </table>
</div>
