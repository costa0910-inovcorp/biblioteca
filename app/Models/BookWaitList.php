<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookWaitList extends Model
{
    //
    public $incrementing = false;

    protected $table = 'book_wait_list';

    protected $fillable = [
        'user_id',
        'book_id',
        'id',
        'position'
    ];

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class, 'book_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
