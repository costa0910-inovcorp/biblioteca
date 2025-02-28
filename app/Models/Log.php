<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Log extends Model
{
    //
    protected $fillable = [
        'user_id',
        'user_agent',
        'ip_address',
        'date',
        'time',
        'object_id',
        'app_section',
        'alteration_made',
        'id'
    ];
    public $incrementing = false;


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
