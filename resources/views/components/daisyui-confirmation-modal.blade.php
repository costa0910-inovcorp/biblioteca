@props(['actionName' => '', 'name' => 'Book'])

{{--<button class="btn" onclick="delete_modal.showModal()">open modal</button>--}}
<dialog id="delete_modal" class="modal">
    <div class="modal-box">
        <h3 class="text-lg font-bold">Delete {{ $name }}</h3>
        <p class="py-4">Are you sure you want to delete this {{ $name }}? Once this {{ $name }} is deleted, all of its relation with other tables will be permanently deleted.
        </p>
        <div class="modal-action">
            <form method="dialog" class="flex gap-6">
                <!-- if there is a button in form, it will close the modal -->
                <button class="btn">Cancel</button>
                <button wire:loading.attr="disabled" wire:click="{{ $actionName }}" class="btn btn-error">Delete {{ $name }}</button>
            </form>
        </div>
    </div>
</dialog>
