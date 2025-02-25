<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    //
    public $incrementing = false;

    protected $fillable = [
        'id',
        'book_id',
        'order_id',
        'price'
    ];

    public function book(): BelongsTo {
        return $this->belongsTo(Book::class);
    }

    public function order(): BelongsTo {
        return $this->belongsTo(Order::class);
    }
}
