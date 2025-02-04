        @props(['data'=> []])

        <thead>
        <tr>
            @foreach($data as $thData)
                <th>{{ $thData }}</th>
            @endforeach
            <th></th>
        </tr>
        </thead>
