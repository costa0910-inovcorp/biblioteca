<?php

namespace App\Livewire;

use App\Models\Author;
use App\Models\Publisher;
use App\Repositories\LogRepository;
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
    public function create(LogRepository $logRepository) {
        $this->validate([
            'name' => 'required',
            'imageFile' => 'required|image|mimes:jpeg,png,jpg|max:1048',
        ]);

        $author = Author::query()->create([
            'id' => Str::uuid(),
            'name' => $this->name,
            'photo' => $this->imageFile->store('authors', 'public')
        ]);

        $logRepository->addRequestAction([
            'object_id' => $author->id,
            'app_section' => 'CreateAuthor livewire component action create',
            'alteration_made' => 'create author',
        ]);

        Request::session()->flash('flash.banner', 'Author created successfully');
        Request::session()->flash('flash.bannerStyle', 'success');

        return redirect()->route('authors');
    }

    public function edit(LogRepository $logRepository)
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

        $logRepository->addRequestAction([
            'object_id' => $author->id,
            'app_section' => 'CreateAuthor livewire component action edit',
            'alteration_made' => 'edit author',
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
