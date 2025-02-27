<?php

namespace App\Livewire;

use App\Livewire\Forms\BookForm;
use App\Models\Book;
use App\Repositories\LogRepository;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditBook extends Component
{
    use WithFileUploads;
    public Book $oldBookData;
    public BookForm $form;

    public function mount(Book $book) {
        $this->oldBookData = $book;
        $this->form->setBook($book);
    }

    public function editBook(LogRepository $logRepository)
    {
        $this->validate();
        $path = $this->oldBookData->cover_image;

        if($this->form->coverImage?->isValid()) {
            Storage::delete($this->oldBookData->cover_image);
            $path = $this->form->coverImage->store('books', 'public');
        }
        $book = Book::find($this->oldBookData->id);

        $book->price = $this->form->price;
        $book->name = $this->form->name;
        $book->bibliography = $this->form->bibliography;
        $book->isbn = $this->form->isbn;
        $book->cover_image = $path;

        $book->save();

        $logRepository->addRequestAction([
            'object_id' => $book->id,
            'app_section' => 'EditBook livewire component action editBook',
            'alteration_made' => 'edit book',
        ]);

        Request::session()->flash('flash.banner', 'Book updated successfully');
        Request::session()->flash('flash.bannerStyle', 'success');

        return redirect()->route('books');
    }
    public function render()
    {
        return view('livewire.edit-book')->layout('layouts.app');
    }
}
