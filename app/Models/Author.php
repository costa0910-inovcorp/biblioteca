<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Author extends Model
{
    /** @use HasFactory<\Database\Factories\AuthorFactory> */
    use HasFactory;
    public $incrementing = false;

    protected $fillable = ['name', 'id', 'photo'];

    public function books(): belongsToMany
    {
        return $this->belongsToMany(Book::class, 'author_book', 'author_id', 'book_id');
    }

    protected function casts(): array
    {
        return [
            'photo' => 'encrypted',
        ];
    }
}
