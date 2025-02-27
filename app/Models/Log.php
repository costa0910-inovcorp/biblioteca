<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    //
    protected $fillable = [
        'user_id',
        'user_agent',
        'ip_address',
        'app_section',
        'date',
        'time',
        'object_id',
        'alteration'
    ];
    public $incrementing = false;


    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
