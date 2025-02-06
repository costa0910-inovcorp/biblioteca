{{--        @props(['data'=> []])--}}

{{--        <tr>--}}
{{--            @foreach($data as $thData)--}}
{{--                <th>{{ $thData }}</th>--}}
{{--            @endforeach--}}
{{--            <th></th>--}}
{{--        </tr>--}}

{{--        head with sort th--}}
        @props(['headData'=> []])

        <tr>
            @foreach($headData as $thData)
                <th>{{ $thData['field'] }}
{{--                @if($thData['sort'])--}}
{{--                    <span class="btn btn-sm" @click="sortCol('{{ $thData['col'] }}')"><></span>--}}
{{--                @endif--}}
                </th>
            @endforeach
            <th></th>
        </tr>
