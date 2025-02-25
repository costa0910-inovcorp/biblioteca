<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CartItem extends Model
{
    //
    public $incrementing = false;

    protected $fillable = [
        'book_id',
        'user_id',
        'id'
    ];

    public function book(): BelongsTo {
        return $this->BelongsTo(Book::class);
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}
