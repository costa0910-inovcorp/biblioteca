<div class="indicator mr-4">
    <span class="indicator-item badge badge-primary">{{ count($savingBooksProcess) }}</span>
    <div class="dropdown dropdown-bottom md:dropdown-end">
        <div tabindex="0" role="button" class="btn">
            Saving
            <svg class="-me-0.5 size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path>
            </svg>
        </div>

        <div
            tabindex="0"
            class="card compact dropdown-content bg-base-100 rounded-box z-[9999] w-80 overflow-auto mt-1">
            <div tabindex="0" class="card-body">
                @if(empty($savingBooksProcess))
                    <p class="text-center">No process</p>
                @endif
                @foreach($savingBooksProcess as $process)
                    @if($process['status'] == 'SUCCESS')
                        <div class="alert alert-success">
                            <span>Process id: {{ $process['id'] }}</span>
                            <span>{{ $process['booksSaved'] }} of {{ $process['totalBooks'] }} saved successfully.</span>
                        </div>
                    @elseif($process['status'] == 'START')
                        <div class="alert">
                            <div class="flex flex-col overflow-hidden">
                                <span>Process id: {{ $process['id'] }}</span>
                                <span>Trying to save {{ $process['totalBooks'] }} books</span>
                                <span>
                                    <progress class="progress w-full"></progress>
                                </span>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-error">
                            <span>Process id: {{ $process['id'] }}</span>
                            <span>Error saving books: {{ $process['message'] }}</span>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
