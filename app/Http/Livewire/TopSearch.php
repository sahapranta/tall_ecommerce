<?php

namespace App\Http\Livewire;

// use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class TopSearch extends ModalComponent
{
    public $search = "";

    public $results = "";


    public function searchChanged()
    {
        $this->results = "I got some data";
    }

    public function render()
    {
        return view('livewire.top-search');
    }
}
