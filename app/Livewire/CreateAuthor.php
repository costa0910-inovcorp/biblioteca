<?php

namespace App\Livewire;

use App\Models\Author;
use App\Models\Publisher;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateAuthor extends Component
{
    use WithFileUploads;

    #[Rule('required')]
    public string $name;

    public  $author = null;

    #[Rule(as: 'Photo')]
    public $imageFile;

    public function mount(?Author $author) {
        if ($author->exists) { // Means edit
           $this->author = $author;
           $this->name = $author->name;
        }
    }
    public function create() {
        $this->validate([
            'name' => 'required',
            'imageFile' => 'required|image|mimes:jpeg,png,jpg|max:1048',
        ]);

        Author::query()->create([
            'id' => Str::uuid(),
            'name' => $this->name,
            'photo' => $this->imageFile->store('authors', 'public')
        ]);

        Request::session()->flash('flash.banner', 'Author created successfully');
        Request::session()->flash('flash.bannerStyle', 'success');

        return redirect()->route('authors');
    }

    public function edit()
    {
        $this->validate([
            'name' => 'required',
        ]);

        $author = Author::query()->findOrFail($this->author->id);

        $path = $author->photo;

        if ($this->imageFile?->isValid()) {
            Storage::delete($path);
            $path = $this->imageFile->store('authors', 'public');
        }

        $author->update([
            'name' => $this->name,
            'photo' => $path,
        ]);

        Request::session()->flash('flash.banner', 'Author updated successfully');
        Request::session()->flash('flash.bannerStyle', 'success');
        return redirect()->route('authors');
    }
    public function render()
    {
        return view('livewire.create-author')->layout('layouts.app');
    }
}
