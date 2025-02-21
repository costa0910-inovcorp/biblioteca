<?php

namespace App\Repositories;

use App\Models\Book;
use App\Models\BookRequest;
use App\Models\BookWaitList;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use function Laravel\Prompts\error;
use function Pest\Laravel\put;

class RequestBookRepository
{
    private const LIMIT_TO_BORROW = 3;

    public function borrowBooks(array $booksToBorrow): int
    {
        $authUser = auth()->user();

        if ($authUser->books_request_count >= self::LIMIT_TO_BORROW) {
            abort(403, 'You can not request more than 3 books at the same time.');
        }

        try {
            foreach ($booksToBorrow as $book) {
                //TODO: ask Nuno if to let user choose return date and if to emit only one event
                $request = BookRequest::create([
                    'book_id' => $book['id'],
                    'user_id' => $authUser->id,
                    'user_name' => $authUser->name,
                    'user_email' => $authUser->email
                ]);

                Book::query()->where('id', $book['id'])->update([
                    'is_available' => false,
                ]);

                //TODO: emit event, that's request has been made
//                BookRequested::dispatch($request); On 80% in emails test
            }

            $user = User::query()->where('id', $authUser->id)->first();
            $user->books_request_count += count($booksToBorrow);
            $user->save();
            DB::commit();

            return self::LIMIT_TO_BORROW - $user->books_request_count;

        } catch (Exception $exception) {
            DB::rollBack();
            abort(500, $exception->getMessage());
        }
    }

    public function addBooksToWaitList(array $booksToAdd): void
    {
        $id = auth()->id();

        DB::transaction(function () use ($booksToAdd, $id) {
            foreach ($booksToAdd as $book) {
                $alreadyInWaiByUser = BookWaitList::query()
                    ->where('book_id', $book['id'])
                    ->where('user_id', $id)->get();

                //Only add book if user is not already wait for it
                if ($alreadyInWaiByUser->isEmpty()) {
                    BookWaitList::query()->create([
                        'id' => Str::uuid(),
                        'book_id' => $book['id'],
                        'user_id' => $id
                    ]);
                }
//                else throw error if needed
            }
        });
    }
}
