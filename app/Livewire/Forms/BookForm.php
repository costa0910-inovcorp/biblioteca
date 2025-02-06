<?php

namespace App\Livewire\Forms;
use App\Models\Book;
use http\Exception\InvalidArgumentException;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rules\ImageFile;
use Livewire\Attributes\Validate;
use Livewire\Form;

class BookForm extends Form
{
    #[Validate('required')]
    public string $name = '';

    #[Validate('required')]
    public string $isbn = '';

    #[Validate('required', attribute: 'Authors')]
    public array $authorsId = [];

    #[Validate('required|min:50')]
    public string $bibliography = '';

//    #[Validate('required|image|max:1024|mimes:jpg,jpeg,png' )]
    public $coverImage;

    #[Validate('required')]
    public float $price;

    #[Validate('required', attribute: 'Publisher')]
    public string $publisherId;

    public function setBook($book) {
        $this->name = $book->name;
        $this->isbn = $book->isbn;
        $this->bibliography = $book->bibliography;
        $this->price = $book->price;
        $this->publisherId = $book->publisher_id;
        $this->authorsId = ["1"]; //to avoid validation error on update, won't be added to db
    }

    public function createOptions($option): array  {
        return ['label' => $option->name, 'value' => $option->id];
    }

    public function validateSelect(Collection $collection, string $key, string $value) : void {
        if (!$collection->contains($key, $value)) {
//            throw new InvalidArgumentException("Publisher '$value' does not exist.");
            abort(400,  "Publisher '$value' does not exist.");
        }
    }

    public function validateMultipleSelect(Collection $collection, string $key, array $value) : void
    {
        foreach ($value as $item) {
            $this->validateSelect($collection, $key, $item);
        }
    }
}
