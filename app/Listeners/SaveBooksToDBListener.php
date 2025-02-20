<?php

namespace App\Listeners;

use App\Events\SaveBooksToDB;
use App\Events\SavingBooksStatus;
use App\Models\Author;
use App\Models\Book;
use App\Models\Publisher;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SaveBooksToDBListener implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(SaveBooksToDB $event): void
    {
        $booksSaved = 0;
        $books = $event->books;
        $processId = $event->processId;
        $userId = $event->userId;

        try {
            DB::beginTransaction();

            //loop through book
            foreach ($books as $book) {
                // find or create publisher
                $publisher = $this->findOrCreatePublisher($book['publisher']);
                //find or create author
                $authors = $this->findOrCreateAuthors($book['authors']);

                //create/find book
                $result = $this->findOrCreateBook($book, $publisher?->id);

                if ($result['justCreated']) {
                    $dbBook = $result['book'];
                    foreach ($authors as $author) {
                        $dbBook->authors()->attach($author);
                    }
                    $booksSaved++;
                }
            }

            Db::commit();

        } catch (\Exception $e) {
            //TODO: ROLLBACK AND EMIT ERROR EVENT
            Log::info('called: error');
            DB::rollBack();
            SavingBooksStatus::dispatch([
                'booksSaved' => 0,
                'totalBooks' => count($books),
                'id' => $processId,
                'status' => 'ERROR',
                'message' => $e->getMessage(),
            ]);
//            broadcast(new SavingBooksStatus([
//                'booksSaved' => $booksSaved,
//                'totalBooks' => count($books),
//                'id' => $processId,
//                'status' => 'ERROR',
//                'message' => $e->getMessage(),
//            ]));
        }

        //TODO: EMIT SUCCESS EVENT
        //dispatch event that's books saved on db
//        Livewire::dispatch('booksSaved', $books['itemsIdentifier']);
        SavingBooksStatus::dispatch([
            'status' => 'SAVED',
            'booksSaved' => $booksSaved,
            'totalBooks' => count($books),
            'id' => $processId,
        ]);

        Log::info('called: success');

//        broadcast(new SavingBooksStatus([
//            'status' => 'SAVED',
//            'booksSaved' => $booksSaved,
//            'totalBooks' => count($books),
//            'id' => $processId,
//        ]));

    }

    private function findOrCreatePublisher(?string $name = null): Publisher | null {
        if (is_null($name)) {
            return null;
        }

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

    private function findOrCreateBook(array $book, ?string $publisherId = null): array
    {
        $dbBook =  Book::query()->where('isbn', $book['isbn'])->first();
        if ($dbBook?->exists) {
            return ['book' => $dbBook, 'justCreated' => false];
        }

        $dbBook = Book::query()->where('name', $book['name'])->first();
        if ($dbBook?->exists && !$book['isbn']) {
            return ['book' => $dbBook, 'justCreated' => false];
        }

        $dbBook =  Book::query()->create([
            'id' => Str::uuid(),
            'name' => $book['name'],
            'bibliography' => $book['bibliography'],
            'isbn' => $book['isbn'],
            'price' => $book['price'],
            'publisher_id' => $publisherId,
            'cover_image' => $book['cover_image'],
        ]);

        return ['book' => $dbBook, 'justCreated' => true];
    }
}
