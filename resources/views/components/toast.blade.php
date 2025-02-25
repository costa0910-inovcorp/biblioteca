<div x-data="{ event: '' }" x-init="
        console.log('called');
        Livewire.on('book-added-to-cart', params => {
            addToEvent(params);
        });
        Livewire.on('not-added-to-cart', params => {
            addToEvent(params);
        });
        Livewire.on('removed-from-cart', params => {
            addToEvent(params);
        });
        Livewire.on('order-fail', params => {
            addToEvent(params);
        });

        function addToEvent(params) {
            event = params;
            setTimeout(() => event = '', 3000);
        };
        ">

    <template x-if="event.warning">
        <div class="toast toast-bottom toast-center">
            <div class="alert alert-warning">
                <span x-text="event.message"></span>
            </div>
        </div>
    </template>
    <template x-if="event.success">
        <div class="toast toast-bottom toast-center">
            <div class="alert alert-success">
                <span x-text="event.message"></span>
            </div>
        </div>
    </template>
    <template x-if="event.removed">
        <div class="toast toast-bottom toast-center">
            <div class="alert alert-error">
                <span x-text="event.message"></span>
            </div>
        </div>
    </template>

    <template x-if="event.fail">
        <div class="toast toast-bottom toast-center">
            <div class="alert alert-error">
                <span x-text="event.message"></span>
            </div>
        </div>
    </template>
</div>
