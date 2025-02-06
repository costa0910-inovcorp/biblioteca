<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Publisher extends Model
{
    /** @use HasFactory<\Database\Factories\PublisherFactory> */
    use HasFactory;
    public $incrementing = false;

    protected $fillable = ['name', 'id', 'logo'];

    public function books(): hasMany
    {
       return $this->hasMany(Book::class, 'publisher_id', 'id');
    }

    protected function casts(): array
    {
        return [
            'logo' => 'encrypted',
        ];
    }
}
