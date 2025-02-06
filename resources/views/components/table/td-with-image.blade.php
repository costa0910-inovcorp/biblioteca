        @props(['data' => null, 'imgKey'=> 'cover_image'])
        <td>
            <div class="flex items-center gap-3">
                <div class="avatar">
                    <div class="mask mask-squircle h-12 w-12">
                        <img
                            src="{{ url($data[$imgKey]) }}"
                            alt="{{ $book->name ?? 'No image' }}" />
                    </div>
                </div>
                <div>
                    <div class="font-bold">{{ $data->name }}</div>
                </div>
            </div>
        </td>
