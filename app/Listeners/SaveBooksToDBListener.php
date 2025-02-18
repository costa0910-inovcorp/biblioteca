<?php

namespace App\Listeners;

use App\Events\SaveBooksToDB;
use App\Models\Author;
use App\Models\Book;
use App\Models\Publisher;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Str;
use Livewire\Livewire;

class SaveBooksToDBListener implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

//"items" => array:5 [▼
//0 => array:8 [▼
//"kind" => "books#volume"
//"id" => "Ucy4DwAAQBAJ"
//"etag" => "QOxKKhJ5o/M"
//"selfLink" => "https://www.googleapis.com/books/v1/volumes/Ucy4DwAAQBAJ"
//"volumeInfo" => array:20 [▼
//"title" => "The Brut"
//"subtitle" => "Or The Chronicles of England"
//"authors" => array:1 [▼
//0 => "Friedrich W. D. Brie"
//]
//"publisher" => "Routledge"
//"publishedDate" => "2019-10-16"
//"description" => "Originally published in 1906. This volume includes the full text of The Brut of England, and runs from the legendary time of Albina and Brutus until the battle  ▶"
//"industryIdentifiers" => array:2 [▼
//0 => array:2 [▼
//"type" => "ISBN_13"
//"identifier" => "9781000697179"
//]
//1 => array:2 [▼
//"type" => "ISBN_10"
//"identifier" => "1000697177"
//]
//]
//"readingModes" => array:2 [▼
//"text" => true
//"image" => true
//]
//"pageCount" => 322
//"printType" => "BOOK"
//"categories" => array:1 [▼
//0 => "Literary Criticism"
//]
//"maturityRating" => "NOT_MATURE"
//"allowAnonLogging" => false
//"contentVersion" => "1.3.2.0.preview.3"
//"panelizationSummary" => array:2 [▼
//"containsEpubBubbles" => false
//"containsImageBubbles" => false
//]
//"imageLinks" => array:2 [▼
//"smallThumbnail" => "http://books.google.com/books/content?id=Ucy4DwAAQBAJ&printsec=frontcover&img=1&zoom=5&edge=curl&source=gbs_api"
//"thumbnail" => "http://books.google.com/books/content?id=Ucy4DwAAQBAJ&printsec=frontcover&img=1&zoom=1&edge=curl&source=gbs_api"
//]
//"language" => "en"
//"previewLink" => "http://books.google.pt/books?id=Ucy4DwAAQBAJ&pg=PA147&dq=herry+po&hl=&cd=1&source=gbs_api"
//"infoLink" => "https://play.google.com/store/books/details?id=Ucy4DwAAQBAJ&source=gbs_api"
//"canonicalVolumeLink" => "https://play.google.com/store/books/details?id=Ucy4DwAAQBAJ"
//]
//"saleInfo" => array:7 [▶]
//"accessInfo" => array:10 [▶]
//"searchInfo" => array:1 [▶]

    /**
     * Handle the event.
     */
    public function handle(SaveBooksToDB $event): void
    {
        $books = $event->books;

        //look through book

        foreach ($books as $book) {
            $volumeInfo = $book['volumeInfo'];
            // find or create publisher
            $publisher = $this->findOrCreatePublisher($volumeInfo['publisher']);
            //find or create author
            $authors = $this->findOrCreateAuthors($volumeInfo['authors']);

            //create book and save
            $dbBook = $this->findOrCreateBook($book, $publisher->id);

            $dbBook->authors()->sync($authors);
        }

        //dispatch event that's books saved on db
//        Livewire::dispatch('booksSaved', $books['itemsIdentifier']);
    }

    private function findOrCreatePublisher(string $name): Publisher {
        return Publisher::query()->firstOrCreate(['name' => $name], [
            'name' => $name,
            'logo' => null, // no image for publisher on Google books
            'id' => Str::uuid()
        ]);
    }

    private function findOrCreateAuthors(array $authors): array
    {
        $dbAuthors = [];

        foreach ($authors as $author) {
            $dbAuthor = Author::query()->firstOrCreate(['name' => $author], [
                'name' => $author,
                'photo' => null,
                'id' => Str::uuid()
            ]);

            $dbAuthors[] = $dbAuthor;
        }

        return $dbAuthors;
    }

    private function findOrCreateBook(array $book, string $publisherId): Book
    {
        $isbn = $this->getIsbn($book['volumeInfo']['industryIdentifiers']);

        $dbBook =  Book::query()->where('isbn', $isbn)->first();
        if ($dbBook->exists) {
            return $dbBook;
        }

        $dbBook = Book::query()->where('name', $book['volumeInfo']['title'])->first();
        if ($dbBook->exists && !$isbn) {
            return $dbBook;
        }

        $price = $this->getPrice($book['volumeInfo']['saleInfo']);

        return Book::query()->create([
            'id' => Str::uuid(),
            'name' => $book['volumeInfo']['title'],
            'bibliography' => $book['volumeInfo']['description'],
            'isbn' => $isbn,
            'price' => $price,
            'publisher_id' => $publisherId,
            'cover_image' => $book['volumeInfo']['imageLinks']['smallThumbnail'],
        ]);
    }

    private function getPrice(array $saleInfo) : float
    {
        if ($saleInfo['retailPrice']) {
            return $saleInfo['retailPrice'];
        }

        if ($saleInfo['listPrice']) {
            return $saleInfo['listPrice'];
        }

        return 0;
    }

    private function getIsbn(?array $industryIdentifiers): string | null
    {
        if (empty($industryIdentifiers)) {
            return null;
        }

        return $industryIdentifiers[0]['identifier'];
    }
}
