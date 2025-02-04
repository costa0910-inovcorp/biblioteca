        @props(['data'=> '', 'span'=> ''])

        <td>
            {{$data}}
            @unless($span)
                <br />
                <span class="badge badge-ghost badge-sm">{{$span}}</span>
            @endunless
        </td>
