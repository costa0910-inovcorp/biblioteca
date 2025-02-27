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
        'date',
        'time',
        'object_id',
        'app_section',
        'alteration_made'
    ];
    public $incrementing = false;


    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
