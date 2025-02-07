@props(['headData'=> []])

<tr>
    @foreach($headData as $thData)
        <th>
            <div class="flex gap-2">
                {{ $thData['field'] }}
                @if($thData['sort'])
                    <span class="block cursor-pointer" @click="sortCol('{{ $thData['col'] }}')">
                        <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 5L12 19" stroke="#200E32" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M8 16L12 20L16 16" stroke="#200E32" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M16 8L12 4L8 8" stroke="#200E32" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                @endif
            </div>
        </th>
    @endforeach
    <th></th>
</tr>
