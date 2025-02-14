<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookRequest extends Model
{
    /** @use HasFactory<\Database\Factories\BookRequestFactory> */
    use HasFactory;

    protected $fillable = ['user_id', 'book_id', 'user_name', 'user_email', 'predicted_return_date'];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function book(): BelongsTo {
        return $this->belongsTo(Book::class, 'book_id', 'id');
    }
}
