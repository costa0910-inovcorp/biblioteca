<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    //
    public $incrementing = false;

    protected $fillable = [
        'id',
        'user_id',
        'total_price',
        'delivery_address',
        'status',
    ];

    public function items(): HasMany {
        return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }
}
