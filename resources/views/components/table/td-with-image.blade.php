        @props(['book' => null])
        <td>
            <div class="flex items-center gap-3">
                <div class="avatar">
                    <div class="mask mask-squircle h-12 w-12">
                        <img
                            src="{{ $book->cover_image }}"
                            alt="{{ $book->name ?? 'No image' }}" />
                    </div>
                </div>
                <div>
                    <div class="font-bold">{{ $book->name }}</div>
                </div>
            </div>
        </td>
