<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    protected $fillable = [
        'id',
        'book_id',
        'user_id',
        'status',
        'rating',
        'comment',
    ];

    public function book(): BelongsTo {
        return $this->belongsTo(Book::class, 'book_id', 'id');
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
