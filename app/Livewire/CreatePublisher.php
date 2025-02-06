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

class CreatePublisher extends Component
{
    use WithFileUploads;

    #[Rule('required')]
    public string $name;

    #[Rule(as: 'Logo')]
    public $imageFile;

    public $publisher  = null;

    public function mount(?Publisher $publisher) {
        if ($publisher->exists) {
            $this->publisher = $publisher;
            $this->name = $publisher->name;
        }
    }

    public function create() {
        $this->validate([
            'name' => 'required',
            'imageFile' => 'required|image|mimes:jpeg,png,jpg|max:1048',
        ]);

        Publisher::query()->create([
            'id' => Str::uuid(),
            'name' => $this->name,
            'logo' => $this->imageFile->store('publishers', 'public')
        ]);

        Request::session()->flash('flash.banner', 'Publisher created successfully');
        Request::session()->flash('flash.bannerStyle', 'success');

        return redirect()->route('publishers');
    }

    public function edit()
    {
        $this->validate([
            'name' => 'required',
        ]);

        $publisher = Publisher::query()->findOrFail($this->publisher->id);

        $path = $publisher->logo;

        if ($this->imageFile?->isValid()) {
            Storage::delete($path);
            $path = $this->imageFile->store('publishers', 'public');
        }

        $publisher->update([
            'name' => $this->name,
            'logo' => $path,
        ]);

        Request::session()->flash('flash.banner', 'Publisher updated successfully');
        Request::session()->flash('flash.bannerStyle', 'success');
        return redirect()->route('publishers');
    }

    public function render()
    {
        return view('livewire.create-publisher')->layout('layouts.app');
    }
}
