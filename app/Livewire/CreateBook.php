<?php

namespace App\Livewire;

use App\Livewire\Forms\BookForm;
use App\Models\Author;
use App\Models\Book;
use App\Models\Publisher;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateBook extends Component
{
    use WithFileUploads;
    public BookForm $form;
    public Collection $publishers;

    public Collection $authors;

    public function mount() {
        $this->publishers = Publisher::all()->map(fn ($publisher) => $this->form->createOptions($publisher));

        $this->authors = Author::all()->map(fn ($author) => $this->form->createOptions($author));
    }

    /**
     * @throws \Exception
     */
    public function createPost() {
        $this->validate();

        //create require, update optional
        $this->validate([
            'form.coverImage' => 'required|image|max:1024|mimes:jpg,jpeg,png'
        ]);
        $this->form->validateSelect($this->publishers, 'value', $this->form->publisherId);
        $this->form->validateMultipleSelect($this->authors, 'value', $this->form->authorsId);

        DB::beginTransaction();

        $path = $this->form->coverImage->store('books', 'public');
        try {
            $newBook = Book::create([
                'id' => Str::uuid(),
                'cover_image' => $path,
                'name' => $this->form->name,
                'bibliography' => $this->form->bibliography,
                'isbn' => $this->form->isbn,
                'price' => $this->form->price,
                'publisher_id' => $this->form->publisherId
            ]);

            $newBook->save();
            $newBook->authors()->attach($this->form->authorsId);

            DB::commit();

            Request::session()->flash('flash.banner', 'Book created successfully');
            Request::session()->flash('flash.bannerStyle', 'success');

            return redirect()->route('books');

        } catch (\Exception $e) {
            DB::rollBack();

            if ($path) {
                Storage::delete($path);
            }
            Request::session()->flash('flash.banner', 'An error occurred while creating book');
            Request::session()->flash('flash.bannerStyle', 'danger');
            return back();
        }
    }
    public function render()
    {
        return view('livewire.create-book')->layout('layouts.app');
    }
}
