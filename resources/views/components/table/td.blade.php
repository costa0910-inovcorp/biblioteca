        @props(['head'=> []])

        <thead>
            <tr>
                @foreach($head as $thData)
                    <th>{{ $thData }}</th>
                @endforeach
                <th></th>
            </tr>
        </thead>
