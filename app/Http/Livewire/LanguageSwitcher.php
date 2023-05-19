<?php

namespace App\Http\Livewire;

use Livewire\Component;

class LanguageSwitcher extends Component
{
    public function render()
    {
        $currentLocaleRegion = \LaravelLocalization::getCurrentLocaleRegional();
        $flag = placename($currentLocaleRegion);
        return view('livewire.language-switcher', ['flag' => $flag]);
    }
}
