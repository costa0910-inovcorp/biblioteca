<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use phpDocumentor\Reflection\Types\This;

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
        'is_available',
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

    public function requests(): HasMany {
        return $this->hasMany(BookRequest::class, 'book_id', 'id');
    }

    public function reviews(): HasMany {
        return $this->hasMany(Review::class, 'book_id', 'id');
    }

    public function bookWaitList(): HasMany
    {
        return $this->hasMany(BookWaitList::class, 'book_id', 'id');
    }

    protected function casts(): array
    {
        return [
            'cover_image' => 'encrypted',
            'isbn' => 'encrypted',
        ];
    }
}
