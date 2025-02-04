<x-table>
        <x-table.head :data="$booksHeader"/>
          <tbody>
              @if($books == null)
                  <tr>Loading...</tr>
              @elseif(count($books) == 0)
                  <tr>No books</tr>
              @endif

              @foreach($books as $book)
                  <tr>
                      <x-table.td-with-image :$book />
                      <td>
                          {{ $book->isbn }}
                      </td>
                      <td>
                          {{ $book->bibliography }}
                      </td>
                      <th>
                          <button class="btn btn-ghost btn-xs">details</button>
                      </th>
                </tr>
              @endforeach
          </tbody>
</x-table>
