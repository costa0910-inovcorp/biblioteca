<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Book extends Model
{
    /** @use HasFactory<\Database\Factories\BookFactory> */
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'cover_image',
        'price',
        'bibliography',
        'isbn',
        'publisher_id',
    ];
    public $incrementing = false;

    public function authors(): belongsToMany
    {
        return $this->belongsToMany(Author::class, 'author_book', 'book_id', 'author_id');
    }

    public function publisher(): BelongsTo
    {
        return $this->belongsTo(Publisher::class, 'publisher_id', 'id');
    }

    protected function casts(): array
    {
        return [
            'cover_image' => 'encrypted',
            'isbn' => 'encrypted',
        ];
    }
}
